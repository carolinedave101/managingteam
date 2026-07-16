<?php

namespace App\Filament\Admin\Resources\MembershipCards\Pages;

use App\Filament\Admin\Resources\MembershipCards\MembershipCardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMembershipCards extends ListRecords
{
    protected static string $resource = MembershipCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
