<?php

namespace App\Filament\Admin\Resources\Withdrawals\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WithdrawalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('celebrity.name')
                    ->label('Celebrity Portal')
                    ->searchable()
                    ->sortable()
                    ->tooltip('The celebrity portal this withdrawal was requested from.'),
                TextColumn::make('user.name')
                    ->label('Fan')
                    ->searchable()
                    ->sortable()
                    ->tooltip('The fan who requested this withdrawal.'),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('USD')
                    ->sortable()
                    ->tooltip('The dollar amount requested for withdrawal.'),
                TextColumn::make('withdrawalAccount.label')
                    ->label('Account')
                    ->tooltip('The saved account this withdrawal will be sent to.'),
                TextColumn::make('withdrawalAccount.type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->tooltip('The type of withdrawal account (bank, CashApp, PayPal, crypto).'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->tooltip('Current status of this withdrawal request.'),
                TextColumn::make('created_at')
                    ->label('Requested')
                    ->dateTime('M d, Y g:i A')
                    ->sortable()
                    ->tooltip('When the fan submitted this withdrawal request.'),
                TextColumn::make('reviewed_at')
                    ->label('Reviewed')
                    ->dateTime('M d, Y g:i A')
                    ->sortable()
                    ->placeholder('—')
                    ->tooltip('When this request was reviewed by the celebrity\'s Management Team.'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                EditAction::make()
                    ->tooltip('Review and approve/reject this withdrawal request.'),
            ]);
    }
}
