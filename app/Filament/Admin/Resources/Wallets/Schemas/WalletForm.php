<?php

namespace App\Filament\Admin\Resources\Wallets\Schemas;

use App\Models\Celebrity;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WalletForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Fan Wallet Details')
                    ->description('View the fan\'s wallet information. Use the action buttons above to deposit, withdraw, or seed transactions.')
                    ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->disabled()
                            ->helperText('The fan who owns this wallet. All transactions here belong to this fan.'),
                        Select::make('celebrity_id')
                            ->options(fn () => Celebrity::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->disabled()
                            ->helperText('The celebrity portal this wallet belongs to. Fans have separate wallets for each celebrity.'),
                        TextInput::make('balance')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->disabled()
                            ->helperText('Current available balance. Updated automatically when deposits, withdrawals, or seeded transactions are processed.'),
                    ]),
            ]);
    }
}
