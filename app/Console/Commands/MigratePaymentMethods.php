<?php

namespace App\Console\Commands;

use App\Models\Celebrity;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:migrate-payment-methods')]
#[Description('Migrate payment_methods from config JSON to celebrity_payment_methods table')]
class MigratePaymentMethods extends Command
{
    public function handle()
    {
        $count = 0;
        foreach (Celebrity::cursor() as $celebrity) {
            $methods = $celebrity->config['payment_methods'] ?? [];
            if (empty($methods)) {
                continue;
            }
            foreach ($methods as $i => $method) {
                $celebrity->paymentMethods()->create([
                    'type' => $method['type'],
                    'label' => $method['label'],
                    'enabled' => $method['enabled'] ?? true,
                    'details' => is_array($method['details'] ?? null) ? $method['details'] : ['text' => $method['details'] ?? ''],
                    'sort_order' => $i,
                ]);
            }
            $celebrity->forceFill(['config->payment_methods' => null])->saveQuietly();
            $count++;
        }

        $this->info("Migrated payment methods for {$count} celebrities.");
    }
}
