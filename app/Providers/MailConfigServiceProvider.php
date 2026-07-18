<?php

namespace App\Providers;

use App\Models\SystemConfig;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        try {
            $record = SystemConfig::where('key', 'mail.settings')->first();

            if ($record && $settings = $record->value) {
                $host = $settings['host'] ?? null;
                $username = $settings['username'] ?? null;
                $password = $settings['password'] ?? null;
                $fromAddress = $settings['from_address'] ?? null;
                $fromName = $settings['from_name'] ?? null;

                $config = [];

                // Always use failover as the default mailer
                $config['mail.default'] = 'failover';

                // Primary mailer (STARTTLS on configured port or 587)
                if ($host) {
                    $config['mail.mailers.smtp_primary.host'] = $host;
                    $config['mail.mailers.smtp_primary.port'] = (int) ($settings['port'] ?? 587);
                    $config['mail.mailers.smtp_primary.scheme'] = 'smtp';
                }
                if ($username) {
                    $config['mail.mailers.smtp_primary.username'] = $username;
                }
                if ($password !== null && $password !== '') {
                    $config['mail.mailers.smtp_primary.password'] = $password;
                }

                // Secondary mailer (implicit SSL on port 465)
                if ($host) {
                    $config['mail.mailers.smtp_secondary.host'] = $host;
                    $config['mail.mailers.smtp_secondary.port'] = 465;
                    $config['mail.mailers.smtp_secondary.scheme'] = 'smtps';
                }
                if ($username) {
                    $config['mail.mailers.smtp_secondary.username'] = $username;
                }
                if ($password !== null && $password !== '') {
                    $config['mail.mailers.smtp_secondary.password'] = $password;
                }

                // From address/name
                if ($fromAddress) {
                    $config['mail.from.address'] = $fromAddress;
                }
                if ($fromName) {
                    $config['mail.from.name'] = $fromName;
                }

                config($config);
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
