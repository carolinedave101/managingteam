<?php

namespace App\Filament\Admin\Resources\Wallets;

use App\Filament\Admin\Resources\Wallets\Pages\EditWallet;
use App\Filament\Admin\Resources\Wallets\Pages\ListWallets;
use App\Filament\Admin\Resources\Wallets\Schemas\WalletForm;
use App\Filament\Admin\Resources\Wallets\Tables\WalletsTable;
use App\Models\Wallet;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WalletResource extends Resource
{
    protected static ?string $model = Wallet::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWallet;

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return 'Fan Management';
    }

    public static function getNavigationLabel(): string
    {
        return 'Fan Wallets';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('user', 'celebrity')
            ->withCount('transactions')
            ->withAggregate('transactions', 'created_at', 'max');
    }

    public static function form(Schema $schema): Schema
    {
        return WalletForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WalletsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWallets::route('/'),
            'edit' => EditWallet::route('/{record}/edit'),
        ];
    }
}
