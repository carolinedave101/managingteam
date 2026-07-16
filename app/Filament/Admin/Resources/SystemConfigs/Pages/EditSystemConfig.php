<?php

namespace App\Filament\Admin\Resources\SystemConfigs\Pages;

use App\Filament\Admin\Resources\SystemConfigs\SystemConfigResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSystemConfig extends EditRecord
{
    protected static string $resource = SystemConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
