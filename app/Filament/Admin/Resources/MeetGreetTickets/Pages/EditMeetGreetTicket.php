<?php

namespace App\Filament\Admin\Resources\MeetGreetTickets\Pages;

use App\Filament\Admin\Resources\MeetGreetTickets\MeetGreetTicketResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMeetGreetTicket extends EditRecord
{
    protected static string $resource = MeetGreetTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
