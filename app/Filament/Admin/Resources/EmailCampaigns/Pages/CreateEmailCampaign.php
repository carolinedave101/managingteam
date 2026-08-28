<?php

namespace App\Filament\Admin\Resources\EmailCampaigns\Pages;

use App\Filament\Admin\Resources\EmailCampaigns\EmailCampaignResource;
use App\Models\EmailCampaign;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class CreateEmailCampaign extends CreateRecord
{
    protected static string $resource = EmailCampaignResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = 'draft';
        $data['created_by'] = auth()->id();
        $data['hourly_limit'] = 50;
        $data['daily_limit'] = 1000;

        $hasCsv = ! empty($data['csv_file']);
        $hasCelebrity = ! empty($data['celebrity_id']);
        $total = 0;

        // Default: send to fans when a celebrity is selected.
        // Toggle only matters when a CSV is also uploaded (allows opting out of fans).
        if ($hasCelebrity && (! $hasCsv || ($data['send_to_fans'] ?? false))) {
            $total += User::where('role', 'fan')
                ->whereHas('celebrities', fn ($q) => $q->where('celebrity_id', $data['celebrity_id']))
                ->count();
        }

        if ($hasCsv) {
            try {
                $csv = $this->parseCsvFile($data['csv_file']);
                if ($csv !== null) {
                    $total += count($csv);
                }
            } catch (\Throwable $e) {
                Log::warning('CSV parsing failed during campaign creation', ['error' => $e->getMessage()]);
            }
        }

        $data['total_recipients'] = $total;

        unset($data['send_to_fans'], $data['csv_file']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $campaign = $this->record;

        $this->createFanRecipients($campaign);
        $this->createCsvRecipients($campaign);

        $campaign->refresh();

        if ($campaign->total_recipients === 0) {
            $campaign->updateQuietly(['status' => 'completed']);
        }
    }

    protected function createFanRecipients(EmailCampaign $campaign): void
    {
        $formData = $this->form->getRawState();

        $hasCsv = ! empty($formData['csv_file']);
        $hasCelebrity = ! empty($formData['celebrity_id']);

        if (! $hasCelebrity) {
            return;
        }

        // Same logic as mutateFormDataBeforeCreate
        if ($hasCsv && ! ($formData['send_to_fans'] ?? false)) {
            return;
        }

        $celebrityId = $formData['celebrity_id'];

        $fans = User::where('role', 'fan')
            ->whereHas('celebrities', fn ($q) => $q->where('celebrity_id', $celebrityId))
            ->get();

        $recipients = $fans->map(fn ($fan) => [
            'campaign_id' => $campaign->id,
            'user_id' => $fan->id,
            'email' => null,
            'name' => null,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        if (! empty($recipients)) {
            $campaign->recipients()->insert($recipients);
        }
    }

    protected function createCsvRecipients(EmailCampaign $campaign): void
    {
        $formData = $this->form->getRawState();

        $rawCsv = $formData['csv_file'] ?? null;
        if (empty($rawCsv)) {
            return;
        }

        try {
            $leads = $this->parseCsvFile($rawCsv);
            if ($leads === null || empty($leads)) {
                return;
            }

            $recipients = array_map(fn ($lead) => [
                'campaign_id' => $campaign->id,
                'user_id' => null,
                'email' => $lead['email'],
                'name' => $lead['name'] ?: null,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ], $leads);

            $campaign->recipients()->insert($recipients);
        } catch (\Throwable $e) {
            Log::warning('CSV parsing failed during recipient creation', [
                'campaign_id' => $campaign->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function parseCsvFile(mixed $csvField): ?array
    {
        $filename = is_string($csvField) ? $csvField : (is_array($csvField) ? reset($csvField) : null);

        if (blank($filename)) {
            return null;
        }

        // Filament stores uploads on the configured filesystem disk (local by default)
        $disk = Storage::disk('local');

        if (! $disk->exists($filename)) {
            $disk = Storage::disk('public');
        }

        if (! $disk->exists($filename)) {
            Log::warning('CSV file not found on any disk', ['filename' => $filename]);

            return null;
        }

        $csv = Reader::createFromString($disk->get($filename));
        $csv->setHeaderOffset(0);

        $leads = [];
        foreach ($csv->getRecords() as $record) {
            $email = trim($record['email'] ?? '');
            $name = trim($record['name'] ?? '');
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $leads[] = ['email' => $email, 'name' => $name];
            }
        }

        return $leads;
    }

    protected function getRedirectUrl(): string
    {
        return EmailCampaignResource::getUrl('edit', ['record' => $this->record]);
    }
}
