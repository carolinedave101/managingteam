<?php

namespace App\Filament\Admin\Resources\SystemConfigs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SystemConfigForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Configuration')
                    ->description('Manage global key-value configuration settings that apply across all celebrity portals and the admin panel. Use this to store system-wide parameters such as API keys, feature flags, pricing defaults, registration settings, or any dynamic configuration value. Each entry is a unique key paired with a value. For complex or nested data, use JSON format in the value field.')
                    ->schema([
                        TextInput::make('key')
                            ->required()
                            ->helperText('A unique identifier for this configuration setting. Convention: use dot-notation or snake_case to namespace keys (e.g. "stripe.secret_key", "pricing.membership.monthly", "feature.meet_greet_enabled"). Must be unique across all config entries — duplicates will be rejected. Required. Choose a descriptive, memorable name that makes the setting purpose clear at a glance.'),
                        TextInput::make('value')
                            ->required()
                            ->helperText('The value for this configuration key. For simple settings, enter a plain string or number (e.g. "true", "usd", "5000"). For complex or nested configurations, use valid JSON (e.g. {"tiers": [{"name": "Gold", "price": 29.99}]}). The system parses this field according to how the application reads the config key. Required — must not be empty.'),
                    ]),
            ]);
    }
}
