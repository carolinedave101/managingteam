<?php

namespace App\Filament\Admin\Resources\FanApplications\Pages;

use App\Events\ApplicationReviewed;
use App\Filament\Admin\Resources\FanApplications\FanApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFanApplication extends EditRecord
{
    protected static string $resource = FanApplicationResource::class;

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

        if ($original['status'] !== $record->status) {
            safe_event(new ApplicationReviewed($record));
        }
    }
}
