<?php

namespace App\Services;

use App\Mail\CampaignMail;
use App\Models\EmailCampaign;
use App\Models\EmailCampaignRecipient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CampaignProcessingService
{
    protected int $batchSize = 10;

    public function withBatchSize(int $size): static
    {
        $this->batchSize = $size;

        return $this;
    }

    public function processNextPendingCampaign(): ?array
    {
        $campaign = EmailCampaign::where('status', 'sending')
            ->orderBy('created_at')
            ->first();

        if (! $campaign) {
            return null;
        }

        return $this->processBatch($campaign);
    }

    public function processBatch(EmailCampaign $campaign): array
    {
        if (! $campaign->canSend()) {
            return $this->pausedResult($campaign);
        }

        $maxToSend = min($this->batchSize, $campaign->remainingHourly(), $campaign->remainingDaily());

        $recipients = $campaign->recipients()
            ->where('status', 'pending')
            ->limit($maxToSend)
            ->get();

        if ($recipients->isEmpty()) {
            $campaign->status = 'completed';
            $campaign->saveQuietly();

            return ['sent' => 0, 'failed' => 0, 'remaining' => 0, 'status' => 'completed'];
        }

        $sent = 0;
        $failed = 0;

        foreach ($recipients as $recipient) {
            try {
                $this->sendToRecipient($campaign, $recipient);
                $recipient->update(['status' => 'sent', 'sent_at' => now()]);
                $sent++;
            } catch (\Throwable $e) {
                $recipient->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
                $failed++;

                Log::warning('Campaign email failed', [
                    'campaign_id' => $campaign->id,
                    'recipient_id' => $recipient->id,
                    'email' => $recipient->recipientEmail(),
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $campaign->markBatchProgress($sent, $failed);

        return [
            'sent' => $sent,
            'failed' => $failed,
            'remaining' => $campaign->recipients()->where('status', 'pending')->count(),
            'status' => $campaign->status,
            'hourly_remaining' => $campaign->remainingHourly(),
            'daily_remaining' => $campaign->remainingDaily(),
        ];
    }

    public function sendTest(EmailCampaign $campaign, array|string $emails): array
    {
        if (is_string($emails)) {
            $emails = array_map('trim', explode(',', $emails));
        }

        $sent = 0;
        $failed = 0;

        foreach ($emails as $email) {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $failed++;
                continue;
            }

            try {
                Mail::send(new CampaignMail(
                    celebrity: $campaign->celebrity,
                    recipientEmail: $email,
                    recipientName: null,
                    subject: $campaign->subject,
                    bodyHtml: $campaign->body,
                ));
                $sent++;
            } catch (\Throwable $e) {
                $failed++;
                Log::warning('Campaign test email failed', [
                    'campaign_id' => $campaign->id,
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return ['sent' => $sent, 'failed' => $failed];
    }

    protected function sendToRecipient(EmailCampaign $campaign, EmailCampaignRecipient $recipient): void
    {
        Mail::send(new CampaignMail(
            celebrity: $campaign->celebrity,
            recipientEmail: $recipient->recipientEmail(),
            recipientName: $recipient->recipientName(),
            subject: $campaign->subject,
            bodyHtml: $campaign->body,
        ));
    }

    protected function pausedResult(EmailCampaign $campaign): array
    {
        $reason = '';

        if (! $campaign->isWithinHourlyLimit()) {
            $reason = 'hourly_limit';
        } elseif (! $campaign->isWithinDailyLimit()) {
            $reason = 'daily_limit';
        }

        return [
            'sent' => 0,
            'failed' => 0,
            'remaining' => $campaign->recipients()->where('status', 'pending')->count(),
            'status' => 'paused',
            'reason' => $reason,
        ];
    }
}