<?php

namespace App\Filament\Admin\Middleware;

use App\Models\EmailCampaign;
use App\Services\CampaignProcessingService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AutoProcessCampaigns
{
    protected const MAX_PER_REQUEST = 3;

    protected static bool $migrated = false;

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (! static::$migrated && ! Schema::hasTable('email_campaigns')) {
            try {
                Artisan::call('migrate', [
                    '--force' => true,
                    '--path' => 'database/migrations/2026_07_30_012026_create_email_campaigns_table.php',
                ]);
                Artisan::call('migrate', [
                    '--force' => true,
                    '--path' => 'database/migrations/2026_07_30_012029_create_email_campaign_recipients_table.php',
                ]);
                static::$migrated = true;
                Log::info('AutoProcessCampaigns: Email campaign tables migrated');
            } catch (\Throwable $e) {
                Log::warning('AutoProcessCampaigns migration failed: '.$e->getMessage());
                return $response;
            }
        }

        try {
            $campaign = EmailCampaign::where('status', 'sending')
                ->orderBy('created_at')
                ->first();

            if ($campaign) {
                app(CampaignProcessingService::class)
                    ->withBatchSize(self::MAX_PER_REQUEST)
                    ->processBatch($campaign);
            }
        } catch (\Throwable $e) {
            Log::warning('AutoProcessCampaigns failed: '.$e->getMessage());
        }

        return $response;
    }
}