<?php

namespace App\Filament\Admin\Resources\Giveaways;

use App\Filament\Admin\Resources\Giveaways\Pages\CreateGiveaway;
use App\Filament\Admin\Resources\Giveaways\Pages\EditGiveaway;
use App\Filament\Admin\Resources\Giveaways\Pages\ListGiveaways;
use App\Filament\Admin\Resources\Giveaways\Schemas\GiveawayForm;
use App\Filament\Admin\Resources\Giveaways\Tables\GiveawayTable;
use App\Models\Giveaway;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GiveawayResource extends Resource
{
    protected static ?string $model = Giveaway::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGift;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'Giveaways';
    }

    public static function getNavigationLabel(): string
    {
        return 'Giveaway Contests';
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('is_active', true)->where('status', 'active')->count();
    }

    public static function form(Schema $schema): Schema
    {
        return GiveawayForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GiveawayTable::configure($table);
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
            'index' => ListGiveaways::route('/'),
            'create' => CreateGiveaway::route('/create'),
            'edit' => EditGiveaway::route('/{record}/edit'),
        ];
    }
}
