<?php

namespace App\Filament\Admin\Resources\Wallets\Pages;

use App\Filament\Admin\Resources\Wallets\WalletResource;
use App\Models\Celebrity;
use App\Models\User;
use App\Models\Wallet;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListWallets extends ListRecords
{
    protected static string $resource = WalletResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('newTransaction')
                ->label('New Transaction')
                ->icon('heroicon-o-plus-circle')
                ->color('primary')
                ->modalHeading('Create a New Wallet Transaction')
                ->modalDescription('Use this to manually add a single credit (deposit) or debit (withdrawal) to any fan\'s wallet. The wallet will be created automatically if it doesn\'t exist yet.')
                ->form([
                    Select::make('user_id')
                        ->label('Fan')
                        ->options(fn () => User::orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->helperText('Select the fan who will receive or lose funds.'),
                    Select::make('celebrity_id')
                        ->label('Celebrity Portal')
                        ->options(fn () => Celebrity::orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->helperText('Select which celebrity portal this transaction belongs to. Fans have separate wallets per celebrity.'),
                    Select::make('type')
                        ->label('Type')
                        ->options([
                            'credit' => 'Credit (Deposit)',
                            'debit' => 'Debit (Withdrawal)',
                        ])
                        ->required()
                        ->helperText('Credit adds funds to the wallet. Debit removes funds.'),
                    TextInput::make('amount')
                        ->required()
                        ->numeric()
                        ->minValue(0.01)
                        ->prefix('$')
                        ->helperText('Enter the dollar amount. Must be at least $0.01.'),
                    Textarea::make('description')
                        ->required()
                        ->placeholder('e.g. Manual deposit, Adjustment, Fan credit, etc.')
                        ->helperText('Explain why this transaction is being made. This will appear in the funding history.'),
                    DateTimePicker::make('timestamp')
                        ->label('Transaction Date')
                        ->default(now())
                        ->displayFormat('M j, Y g:i A')
                        ->helperText('Set the date and time for this transaction. Backdate to reflect past activity, or leave as now for immediate posting.'),
                ])
                ->action(function (array $data) {
                    $user = User::findOrFail($data['user_id']);
                    $celebrity = Celebrity::findOrFail($data['celebrity_id']);
                    $wallet = Wallet::findOrCreateForUser($user, $celebrity);
                    $timestamp = $data['timestamp'] ? now()->parse($data['timestamp']) : null;

                    if ($data['type'] === 'credit') {
                        $wallet->credit(
                            amount: $data['amount'],
                            description: $data['description'],
                            referenceType: 'admin_manual',
                            createdBy: auth()->user(),
                            timestamp: $timestamp,
                        );
                    } else {
                        try {
                            $wallet->debit(
                                amount: $data['amount'],
                                description: $data['description'],
                                referenceType: 'admin_manual',
                                createdBy: auth()->user(),
                                timestamp: $timestamp,
                            );
                        } catch (\RuntimeException $e) {
                            Notification::make()
                                ->title('Transaction failed')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();

                            return;
                        }
                    }

                    Notification::make()
                        ->title('Transaction created')
                        ->body("\${$data['amount']} {$data['type']} for {$user->name} on {$celebrity->name}'s portal.")
                        ->success()
                        ->send();
                }),

            Action::make('generateTransactions')
                ->label('Auto-Generate Transactions')
                ->icon('heroicon-o-sparkles')
                ->color('warning')
                ->modalHeading('Auto-Generate Wallet Transactions')
                ->modalDescription('Automatically create multiple credit or debit transactions for a fan\'s wallet. Each transaction gets a random amount, random description, and random timestamp within your chosen date range. Credits increase the balance; debits decrease it.')
                ->form([
                    Select::make('user_id')
                        ->label('Fan')
                        ->options(fn () => User::orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->helperText('Select the fan whose wallet will receive these transactions.'),
                    Select::make('celebrity_id')
                        ->label('Celebrity Portal')
                        ->options(fn () => Celebrity::orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->helperText('Select the celebrity portal. Fans have separate wallets per celebrity.'),
                    Select::make('type')
                        ->label('Transaction Type')
                        ->options([
                            'credit' => 'Credit (Deposit)',
                            'debit' => 'Debit (Withdrawal)',
                        ])
                        ->default('credit')
                        ->required()
                        ->helperText('Credit adds funds to the wallet. Debit removes funds from the wallet balance.'),
                    TextInput::make('count')
                        ->required()
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(500)
                        ->default(50)
                        ->label('Number of Transactions')
                        ->helperText('How many transactions to generate. Max 500 per batch to keep things fast.'),
                    TextInput::make('max_amount')
                        ->required()
                        ->numeric()
                        ->minValue(0.01)
                        ->default(25)
                        ->prefix('$')
                        ->label('Max Amount per Transaction')
                        ->helperText('Each transaction gets a random dollar amount between $0.01 and this value. For example, set to $50 for varied amounts.'),
                    DatePicker::make('start_date')
                        ->label('Date Range — Start')
                        ->default(now()->subMonths(3))
                        ->helperText('The earliest date a generated transaction can have. Defaults to 3 months ago.'),
                    DatePicker::make('end_date')
                        ->label('Date Range — End')
                        ->default(now())
                        ->helperText('The latest date a generated transaction can have. Defaults to today.'),
                ])
                ->action(function (array $data) {
                    $user = User::findOrFail($data['user_id']);
                    $celebrity = Celebrity::findOrFail($data['celebrity_id']);
                    $wallet = Wallet::findOrCreateForUser($user, $celebrity);

                    $count = (int) $data['count'];
                    $type = $data['type'];
                    $maxAmount = (float) $data['max_amount'];
                    $startDate = $data['start_date'] ? now()->parse($data['start_date']) : now()->subMonths(3);
                    $endDate = $data['end_date'] ? now()->parse($data['end_date']) : now();
                    $totalGenerated = 0;
                    $rangeSeconds = max(1, $endDate->timestamp - $startDate->timestamp);

                    if ($type === 'debit') {
                        $maxPossible = round(mt_rand(1, max(1, (int) ($maxAmount * 100))) / 100, 2) * $count;
                        if ($wallet->balance < $maxPossible) {
                            Notification::make()
                                ->title('Insufficient balance')
                                ->body("The fan's balance (\${$wallet->balance}) may not be enough for {$count} debit transactions averaging \${$maxAmount} each. Reduce the count or max amount, or switch to credit.")
                                ->danger()
                                ->send();

                            return;
                        }
                    }

                    $creditDescriptions = [
                        'Membership subscription payment',
                        'Fan club monthly contribution',
                        'Exclusive content access fee',
                        'Meet & greet ticket purchase',
                        'Digital merchandise purchase',
                        'Premium newsletter subscription',
                        'Behind-the-scenes content access',
                        'VIP event registration',
                        'Fan appreciation bonus',
                        'Rewards program deposit',
                        'Special edition photobook purchase',
                        'Live stream access fee',
                        'Private video message booking',
                        'Signed merchandise purchase',
                        'Fan of the month award',
                        'Community challenge reward',
                        'Referral bonus credit',
                        'Birthday special deposit',
                        'Anniversary fan reward',
                        'Exclusive wallpaper pack purchase',
                        'Fan art contest winnings',
                        'Loyalty program bonus',
                        'Early access pass purchase',
                        'Virtual meetup ticket',
                        'Donation to fan fund',
                    ];

                    $debitDescriptions = [
                        'Withdrawal to bank account',
                        'Refund processed',
                        'Admin fee deduction',
                        'Service charge applied',
                        'Correction adjustment',
                        'Transfer to another wallet',
                        'Payment reversal',
                        'Balance adjustment',
                        'Fee correction',
                        'Dispute resolution chargeback',
                        'Cancellation refund',
                        'Overpayment returned',
                        'Duplicate payment reversed',
                        'Promotional credit removed',
                        'Manual adjustment by Management Team',
                    ];

                    $descriptions = $type === 'credit' ? $creditDescriptions : $debitDescriptions;

                    $records = [];

                    for ($i = 0; $i < $count; $i++) {
                        $amount = round(mt_rand(1, max(1, (int) ($maxAmount * 100))) / 100, 2);
                        $randomOffset = mt_rand(0, $rangeSeconds);
                        $timestamp = (clone $startDate)->addSeconds($randomOffset);

                        $records[] = [
                            'wallet_id' => $wallet->id,
                            'type' => $type,
                            'amount' => $amount,
                            'status' => 'completed',
                            'description' => $descriptions[array_rand($descriptions)],
                            'reference_type' => 'seeded',
                            'reference_id' => null,
                            'created_by' => auth()->id(),
                            'created_at' => $timestamp,
                            'updated_at' => $timestamp,
                        ];

                        $totalGenerated += $amount;
                    }

                    $wallet->transactions()->insert($records);

                    if ($type === 'credit') {
                        $wallet->increment('balance', $totalGenerated);
                    } else {
                        $wallet->decrement('balance', $totalGenerated);
                    }

                    $label = $type === 'credit' ? 'added to' : 'deducted from';

                    Notification::make()
                        ->title('Transactions generated')
                        ->body("{$count} {$type} transactions totaling \${$totalGenerated} {$label} {$user->name}'s wallet on {$celebrity->name}'s portal.")
                        ->success()
                        ->send();
                }),
        ];
    }
}
