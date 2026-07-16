<?php

namespace App\Filament\Admin\Resources\WalletTopUps\Pages;

use App\Filament\Admin\Resources\WalletTopUps\WalletTopUpResource;
use Filament\Resources\Pages\ListRecords;

class ListWalletTopUps extends ListRecords
{
    protected static string $resource = WalletTopUpResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
