<?php

namespace App\Filament\Admin\Resources\SystemConfigs\Pages;

use App\Filament\Admin\Resources\SystemConfigs\SystemConfigResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSystemConfig extends CreateRecord
{
    protected static string $resource = SystemConfigResource::class;
}
