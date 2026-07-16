<?php

namespace App\Filament\Admin\Resources\FanApplications\Pages;

use App\Filament\Admin\Resources\FanApplications\FanApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFanApplication extends EditRecord
{
    protected static string $resource = FanApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
