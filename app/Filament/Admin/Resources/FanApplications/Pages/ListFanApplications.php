<?php

namespace App\Filament\Admin\Resources\FanApplications\Pages;

use App\Filament\Admin\Resources\FanApplications\FanApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFanApplications extends ListRecords
{
    protected static string $resource = FanApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
