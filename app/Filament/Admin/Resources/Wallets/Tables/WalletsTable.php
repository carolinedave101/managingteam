<?php

namespace App\Filament\Admin\Resources\Wallets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WalletsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('celebrity.name')
                    ->label('Celebrity')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Fan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('balance')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('transactions_count')
                    ->label('Transactions')
                    ->counts('transactions'),
                TextColumn::make('transactions_max_created_at')
                    ->label('Latest Activity')
                    ->dateTime(),
            ])
            ->filters([])
            ->actions([
                EditAction::make()
                    ->tooltip('Click to manage this wallet — deposit, withdraw, seed transactions, and view funding history.'),
            ])
            ->headerActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
