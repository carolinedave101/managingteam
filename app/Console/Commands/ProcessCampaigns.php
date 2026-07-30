<?php

namespace App\Console\Commands;

use App\Services\CampaignProcessingService;
use Illuminate\Console\Command;

class ProcessCampaigns extends Command
{
    protected $signature = 'campaigns:process';

    protected $description = 'Process the next batch of pending email campaigns';

    public function handle(CampaignProcessingService $service): int
    {
        $result = $service->processNextPendingCampaign();

        if ($result === null) {
            $this->info('No pending campaigns to process.');

            return Command::SUCCESS;
        }

        $this->line(sprintf(
            'Campaign batch: sent=%d failed=%d remaining=%d status=%s',
            $result['sent'],
            $result['failed'],
            $result['remaining'],
            $result['status'],
        ));

        return Command::SUCCESS;
    }
}