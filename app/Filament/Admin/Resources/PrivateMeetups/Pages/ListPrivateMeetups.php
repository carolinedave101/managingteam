<?php

namespace App\Filament\Admin\Resources\PrivateMeetups\Pages;

use App\Filament\Admin\Resources\PrivateMeetups\PrivateMeetupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPrivateMeetups extends ListRecords
{
    protected static string $resource = PrivateMeetupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
