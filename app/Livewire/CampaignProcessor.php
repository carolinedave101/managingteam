<?php

namespace App\Livewire;

use App\Models\EmailCampaign;
use App\Services\CampaignProcessingService;
use Filament\Notifications\Notification;
use Livewire\Component;

class CampaignProcessor extends Component
{
    public int $campaignId;

    public string $status = 'draft';

    public int $sentCount = 0;

    public int $failedCount = 0;

    public int $totalRecipients = 0;

    public float $progressPercent = 0;

    public int $hourlySent = 0;

    public int $hourlyLimit = 50;

    public int $dailySent = 0;

    public int $dailyLimit = 1000;

    public ?string $lastResult = null;

    protected CampaignProcessingService $service;

    public function boot(CampaignProcessingService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $this->loadCampaign();
    }

    public function loadCampaign(): void
    {
        $campaign = EmailCampaign::find($this->campaignId);

        if (! $campaign) {
            return;
        }

        $this->status = $campaign->status;
        $this->sentCount = $campaign->sent_count;
        $this->failedCount = $campaign->failed_count;
        $this->totalRecipients = $campaign->total_recipients;
        $this->progressPercent = $campaign->progressPercent();
        $this->hourlySent = $campaign->hourly_sent_count;
        $this->hourlyLimit = $campaign->hourly_limit;
        $this->dailySent = $campaign->daily_sent_count;
        $this->dailyLimit = $campaign->daily_limit;
    }

    public function processBatch(): void
    {
        $campaign = EmailCampaign::find($this->campaignId);

        if (! $campaign || $campaign->status !== 'sending') {
            return;
        }

        $result = $this->service->processBatch($campaign);
        $this->loadCampaign();
        $this->lastResult = json_encode($result);
    }

    public function render()
    {
        return view('livewire.campaign-processor');
    }
}