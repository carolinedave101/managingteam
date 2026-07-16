<?php

namespace App\Filament\Admin\Resources\Memberships;

use App\Filament\Admin\Resources\Memberships\Pages\CreateMembership;
use App\Filament\Admin\Resources\Memberships\Pages\EditMembership;
use App\Filament\Admin\Resources\Memberships\Pages\ListMemberships;
use App\Filament\Admin\Resources\Memberships\Schemas\MembershipForm;
use App\Filament\Admin\Resources\Memberships\Tables\MembershipsTable;
use App\Models\Membership;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MembershipResource extends Resource
{
    protected static ?string $model = Membership::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'Fan Management';
    }

    public static function getNavigationLabel(): string
    {
        return 'Subscriptions';
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('is_active', true)->count();
    }

    public static function form(Schema $schema): Schema
    {
        return MembershipForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MembershipsTable::configure($table);
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
            'index' => ListMemberships::route('/'),
            'create' => CreateMembership::route('/create'),
            'edit' => EditMembership::route('/{record}/edit'),
        ];
    }
}
