<?php

namespace App\Filament\Admin\Resources\MeetGreetTickets\Pages;

use App\Filament\Admin\Resources\MeetGreetTickets\MeetGreetTicketResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeetGreetTickets extends ListRecords
{
    protected static string $resource = MeetGreetTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
