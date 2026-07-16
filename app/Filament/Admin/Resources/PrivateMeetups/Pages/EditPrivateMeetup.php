<?php

namespace App\Filament\Admin\Resources\PrivateMeetups\Pages;

use App\Filament\Admin\Resources\PrivateMeetups\PrivateMeetupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPrivateMeetup extends EditRecord
{
    protected static string $resource = PrivateMeetupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
