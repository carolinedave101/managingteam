<?php

namespace App\Filament\Admin\Resources\Giveaways\Pages;

use App\Filament\Admin\Resources\Giveaways\GiveawayResource;
use App\Filament\Admin\Resources\Giveaways\RelationManagers\GiveawayEntriesRelationManager;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGiveaway extends EditRecord
{
    protected static string $resource = GiveawayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getRelationManagers(): array
    {
        return [
            GiveawayEntriesRelationManager::class,
        ];
    }
}
