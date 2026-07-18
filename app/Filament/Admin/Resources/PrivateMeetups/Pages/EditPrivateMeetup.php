<?php

namespace App\Filament\Admin\Resources\PrivateMeetups\Pages;

use App\Events\PrivateMeetupBooked;
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

    protected function afterSave(): void
    {
        $record = $this->record;
        $original = $record->getOriginal();

        if (($original['status'] ?? null) !== $record->status) {
            safe_event(new PrivateMeetupBooked($record));
        }
    }
}
