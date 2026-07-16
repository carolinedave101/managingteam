<?php

namespace App\Filament\Admin\Resources\WalletTopUps;

use App\Filament\Admin\Resources\WalletTopUps\Pages\EditWalletTopUp;
use App\Filament\Admin\Resources\WalletTopUps\Pages\ListWalletTopUps;
use App\Filament\Admin\Resources\WalletTopUps\Schemas\WalletTopUpForm;
use App\Filament\Admin\Resources\WalletTopUps\Tables\WalletTopUpsTable;
use App\Models\WalletTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WalletTopUpResource extends Resource
{
    protected static ?string $model = WalletTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpCircle;

    protected static ?int $navigationSort = 6;

    public static function getNavigationGroup(): ?string
    {
        return 'Fan Management';
    }

    public static function getNavigationLabel(): string
    {
        return 'Wallet Top-Ups';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', 'credit')
            ->where('status', 'pending')
            ->with('wallet.user', 'wallet.celebrity');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('type', 'credit')->where('status', 'pending')->count();
    }

    public static function form(Schema $schema): Schema
    {
        return WalletTopUpForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WalletTopUpsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWalletTopUps::route('/'),
            'edit' => EditWalletTopUp::route('/{record}/edit'),
        ];
    }
}
