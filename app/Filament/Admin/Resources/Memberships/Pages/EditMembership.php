<?php

namespace App\Filament\Admin\Resources\Memberships\Pages;

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
}
