<?php

namespace App\Filament\Admin\Resources\Memberships\Pages;

use App\Events\MembershipUpdated;
use App\Filament\Admin\Resources\Memberships\MembershipResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMembership extends EditRecord
{
    protected static string $resource = MembershipResource::class;

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

        if ((bool) $original['is_active'] !== (bool) $record->is_active) {
            $action = $record->is_active ? 'approved' : 'cancelled';
            safe_event(new MembershipUpdated($record, $action));
        }
    }
}
