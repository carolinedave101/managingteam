<?php

namespace App\Filament\Admin\Resources\Withdrawals\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WithdrawalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Withdrawal Request Details')
                    ->description('Review the withdrawal request details below. The fan is requesting to withdraw funds from their wallet to their saved account. Verify the details before approving or rejecting.')
                    ->schema([
                        Placeholder::make('fan')
                            ->label('Fan')
                            ->content(fn ($record) => $record->user->name)
                            ->helperText('The fan who requested this withdrawal.'),
                        Placeholder::make('celebrity')
                            ->label('Celebrity Portal')
                            ->content(fn ($record) => $record->celebrity->name)
                            ->helperText('The celebrity portal this request belongs to.'),
                        Placeholder::make('amount')
                            ->label('Withdrawal Amount')
                            ->content(fn ($record) => '$'.number_format($record->amount, 2))
                            ->helperText('The dollar amount the fan wants to withdraw.'),
                        Placeholder::make('wallet_balance')
                            ->label('Current Wallet Balance')
                            ->content(fn ($record) => '$'.number_format($record->wallet->balance, 2))
                            ->helperText('The fan\'s current wallet balance before this withdrawal.'),
                        Placeholder::make('account_type')
                            ->label('Account Type')
                            ->content(fn ($record) => ucfirst($record->withdrawalAccount->type))
                            ->helperText('The type of account the fan wants to withdraw to.'),
                        Placeholder::make('account_label')
                            ->label('Account Label')
                            ->content(fn ($record) => $record->withdrawalAccount->label)
                            ->helperText('The fan\'s label for this account.'),
                        Placeholder::make('account_details')
                            ->label('Account Details')
                            ->content(fn ($record) => json_encode($record->withdrawalAccount->details, JSON_PRETTY_PRINT))
                            ->helperText('The stored account details for this withdrawal.'),
                        Placeholder::make('requested_at')
                            ->label('Requested At')
                            ->content(fn ($record) => $record->created_at->format('M d, Y g:i A'))
                            ->helperText('When the fan submitted this withdrawal request.'),
                        Textarea::make('admin_notes')
                            ->label('Admin Notes')
                            ->placeholder('Optional notes about this withdrawal (visible to the fan).')
                            ->helperText('Any notes you leave here will be visible to the fan. Use this to explain why a request was rejected or provide additional context.'),
                    ]),
            ]);
    }
}
