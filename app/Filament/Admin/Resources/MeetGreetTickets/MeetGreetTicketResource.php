<?php

namespace App\Filament\Admin\Resources\MeetGreetTickets;

use App\Filament\Admin\Resources\MeetGreetTickets\Pages\CreateMeetGreetTicket;
use App\Filament\Admin\Resources\MeetGreetTickets\Pages\EditMeetGreetTicket;
use App\Filament\Admin\Resources\MeetGreetTickets\Pages\ListMeetGreetTickets;
use App\Filament\Admin\Resources\MeetGreetTickets\Schemas\MeetGreetTicketForm;
use App\Filament\Admin\Resources\MeetGreetTickets\Tables\MeetGreetTicketsTable;
use App\Models\MeetGreetTicket;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MeetGreetTicketResource extends Resource
{
    protected static ?string $model = MeetGreetTicket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'Events';
    }

    public static function getNavigationLabel(): string
    {
        return 'Event Ticket Sales';
    }

    public static function form(Schema $schema): Schema
    {
        return MeetGreetTicketForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeetGreetTicketsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMeetGreetTickets::route('/'),
            'create' => CreateMeetGreetTicket::route('/create'),
            'edit' => EditMeetGreetTicket::route('/{record}/edit'),
        ];
    }
}
