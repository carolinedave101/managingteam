<?php

namespace App\Filament\Admin\Resources\Giveaways\Pages;

use App\Filament\Admin\Resources\Giveaways\GiveawayResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGiveaways extends ListRecords
{
    protected static string $resource = GiveawayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
