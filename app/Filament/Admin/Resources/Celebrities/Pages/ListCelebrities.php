<?php

namespace App\Filament\Admin\Resources\Celebrities\Pages;

use App\Filament\Admin\Resources\Celebrities\CelebrityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCelebrities extends ListRecords
{
    protected static string $resource = CelebrityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
