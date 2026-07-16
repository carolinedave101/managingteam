<?php

namespace App\Filament\Admin\Resources\MeetGreetEvents;

use App\Filament\Admin\Resources\MeetGreetEvents\Pages\CreateMeetGreetEvent;
use App\Filament\Admin\Resources\MeetGreetEvents\Pages\EditMeetGreetEvent;
use App\Filament\Admin\Resources\MeetGreetEvents\Pages\ListMeetGreetEvents;
use App\Filament\Admin\Resources\MeetGreetEvents\Schemas\MeetGreetEventForm;
use App\Filament\Admin\Resources\MeetGreetEvents\Tables\MeetGreetEventsTable;
use App\Models\MeetGreetEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MeetGreetEventResource extends Resource
{
    protected static ?string $model = MeetGreetEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'Events';
    }

    public static function getNavigationLabel(): string
    {
        return 'Meet & Greet Events';
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('date', '>', now())->where('is_active', true)->count();
    }

    public static function form(Schema $schema): Schema
    {
        return MeetGreetEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeetGreetEventsTable::configure($table);
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
            'index' => ListMeetGreetEvents::route('/'),
            'create' => CreateMeetGreetEvent::route('/create'),
            'edit' => EditMeetGreetEvent::route('/{record}/edit'),
        ];
    }
}
