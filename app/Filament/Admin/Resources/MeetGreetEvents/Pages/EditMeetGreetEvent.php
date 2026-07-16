<?php

namespace App\Filament\Admin\Resources\MeetGreetEvents\Pages;

use App\Filament\Admin\Resources\MeetGreetEvents\MeetGreetEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMeetGreetEvent extends EditRecord
{
    protected static string $resource = MeetGreetEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
