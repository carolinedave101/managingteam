<?php

namespace App\Filament\Admin\Resources\MembershipCards;

use App\Filament\Admin\Resources\MembershipCards\Pages\CreateMembershipCard;
use App\Filament\Admin\Resources\MembershipCards\Pages\EditMembershipCard;
use App\Filament\Admin\Resources\MembershipCards\Pages\ListMembershipCards;
use App\Filament\Admin\Resources\MembershipCards\Schemas\MembershipCardForm;
use App\Filament\Admin\Resources\MembershipCards\Tables\MembershipCardsTable;
use App\Models\MembershipCard;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MembershipCardResource extends Resource
{
    protected static ?string $model = MembershipCard::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return 'Fan Management';
    }

    public static function getNavigationLabel(): string
    {
        return 'Fan ID Cards';
    }

    public static function form(Schema $schema): Schema
    {
        return MembershipCardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MembershipCardsTable::configure($table);
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
            'index' => ListMembershipCards::route('/'),
            'create' => CreateMembershipCard::route('/create'),
            'edit' => EditMembershipCard::route('/{record}/edit'),
        ];
    }
}
