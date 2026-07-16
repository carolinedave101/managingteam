<?php

namespace App\Filament\Admin\Resources\MeetGreetEvents\Pages;

use App\Filament\Admin\Resources\MeetGreetEvents\MeetGreetEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeetGreetEvents extends ListRecords
{
    protected static string $resource = MeetGreetEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
