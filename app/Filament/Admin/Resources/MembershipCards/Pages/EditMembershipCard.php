<?php

namespace App\Filament\Admin\Resources\MembershipCards\Pages;

use App\Filament\Admin\Resources\MembershipCards\MembershipCardResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMembershipCard extends EditRecord
{
    protected static string $resource = MembershipCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
