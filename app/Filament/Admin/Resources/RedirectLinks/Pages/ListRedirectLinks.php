<?php

namespace App\Filament\Admin\Resources\RedirectLinks\Pages;

use App\Filament\Admin\Resources\RedirectLinks\RedirectLinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRedirectLinks extends ListRecords
{
    protected static string $resource = RedirectLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
