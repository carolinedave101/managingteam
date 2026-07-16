<?php

namespace App\Filament\Admin\Resources\RedirectLinks\Pages;

use App\Filament\Admin\Resources\RedirectLinks\RedirectLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRedirectLink extends EditRecord
{
    protected static string $resource = RedirectLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
