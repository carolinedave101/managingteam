<?php

namespace App\Filament\Admin\Resources\PrivateMeetups;

use App\Filament\Admin\Resources\PrivateMeetups\Pages\CreatePrivateMeetup;
use App\Filament\Admin\Resources\PrivateMeetups\Pages\EditPrivateMeetup;
use App\Filament\Admin\Resources\PrivateMeetups\Pages\ListPrivateMeetups;
use App\Filament\Admin\Resources\PrivateMeetups\Schemas\PrivateMeetupForm;
use App\Filament\Admin\Resources\PrivateMeetups\Tables\PrivateMeetupsTable;
use App\Models\PrivateMeetup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PrivateMeetupResource extends Resource
{
    protected static ?string $model = PrivateMeetup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return 'Events';
    }

    public static function getNavigationLabel(): string
    {
        return 'Private Meetup Requests';
    }

    public static function form(Schema $schema): Schema
    {
        return PrivateMeetupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrivateMeetupsTable::configure($table);
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
            'index' => ListPrivateMeetups::route('/'),
            'create' => CreatePrivateMeetup::route('/create'),
            'edit' => EditPrivateMeetup::route('/{record}/edit'),
        ];
    }
}
