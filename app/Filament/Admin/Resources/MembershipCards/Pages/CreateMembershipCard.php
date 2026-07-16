<?php

namespace App\Filament\Admin\Resources\MembershipCards\Pages;

use App\Filament\Admin\Resources\MembershipCards\MembershipCardResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMembershipCard extends CreateRecord
{
    protected static string $resource = MembershipCardResource::class;
}
