<?php

namespace App\Filament\Admin\Resources\Celebrities;

use App\Filament\Admin\Resources\Celebrities\Pages\CreateCelebrity;
use App\Filament\Admin\Resources\Celebrities\Pages\EditCelebrity;
use App\Filament\Admin\Resources\Celebrities\Pages\ListCelebrities;
use App\Filament\Admin\Resources\Celebrities\Schemas\CelebrityForm;
use App\Filament\Admin\Resources\Celebrities\Tables\CelebritiesTable;
use App\Models\Celebrity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CelebrityResource extends Resource
{
    protected static ?string $model = Celebrity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return 'Celebrity Portals';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Celebrity Management';
    }

    public static function form(Schema $schema): Schema
    {
        return CelebrityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CelebritiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCelebrities::route('/'),
            'create' => CreateCelebrity::route('/create'),
            'edit' => EditCelebrity::route('/{record}/edit'),
        ];
    }
}
