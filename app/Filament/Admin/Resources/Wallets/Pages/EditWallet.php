<?php

namespace App\Filament\Admin\Resources\Wallets\Pages;

use App\Filament\Admin\Resources\Wallets\WalletResource;
use App\Models\Wallet;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditWallet extends EditRecord
{
    protected static string $resource = WalletResource::class;

    public Wallet $wallet;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('deposit')
                ->label('Deposit Funds')
                ->icon('heroicon-o-plus-circle')
                ->color('success')
                ->modalHeading('Deposit Funds into Fan Wallet')
                ->modalDescription('Add funds to this fan\'s wallet. The balance will be updated immediately and a credit transaction will appear in the funding history. Use this for grants, rewards, corrections, or any manual credit.')
                ->form([
                    TextInput::make('amount')
                        ->required()
                        ->numeric()
                        ->minValue(0.01)
                        ->prefix('$')
                        ->label('Deposit Amount')
                        ->helperText('Enter the dollar amount to deposit. Must be at least $0.01.'),
                    Textarea::make('description')
                        ->required()
                        ->label('Description')
                        ->placeholder('e.g. Fan support grant, Event winnings, etc.')
                        ->helperText('Explain why this deposit is being made. This description will appear in the fan\'s funding history.'),
                    DateTimePicker::make('timestamp')
                        ->label('Transaction Date')
                        ->default(now())
                        ->displayFormat('M j, Y g:i A')
                        ->helperText('Set the date and time for this transaction. Backdate to reflect past activity, or leave as now for immediate posting.'),
                ])
                ->action(function (array $data, Wallet $record) {
                    $timestamp = $data['timestamp'] ? now()->parse($data['timestamp']) : null;
                    $record->credit(
                        amount: $data['amount'],
                        description: $data['description'],
                        referenceType: 'admin_deposit',
                        createdBy: auth()->user(),
                        timestamp: $timestamp,
                    );

                    Notification::make()
                        ->title('Deposit successful')
                        ->body("$${$data['amount']} deposited to {$record->user->name}'s wallet.")
                        ->success()
                        ->send();

                    $this->refreshFormData(['balance']);
                }),

            Action::make('withdraw')
                ->label('Withdraw Funds')
                ->icon('heroicon-o-minus-circle')
                ->color('danger')
                ->modalHeading('Withdraw Funds from Fan Wallet')
                ->modalDescription('Remove funds from this fan\'s wallet. The balance will be reduced immediately and a debit transaction will appear in the funding history. Use this for refunds, fees, adjustments, or corrections. The fan\'s balance must be sufficient for the withdrawal amount.')
                ->form([
                    TextInput::make('amount')
                        ->required()
                        ->numeric()
                        ->minValue(0.01)
                        ->prefix('$')
                        ->label('Withdrawal Amount')
                        ->helperText('Enter the dollar amount to withdraw. Cannot exceed the fan\'s current balance.'),
                    Textarea::make('description')
                        ->required()
                        ->label('Description')
                        ->placeholder('e.g. Refund, Adjustment, Fee, etc.')
                        ->helperText('Explain why funds are being withdrawn. This description will appear in the fan\'s funding history.'),
                    DateTimePicker::make('timestamp')
                        ->label('Transaction Date')
                        ->default(now())
                        ->displayFormat('M j, Y g:i A')
                        ->helperText('Set the date and time for this transaction. Backdate to reflect past activity, or leave as now for immediate posting.'),
                ])
                ->action(function (array $data, Wallet $record) {
                    try {
                        $timestamp = $data['timestamp'] ? now()->parse($data['timestamp']) : null;
                        $record->debit(
                            amount: $data['amount'],
                            description: $data['description'],
                            referenceType: 'admin_withdrawal',
                            createdBy: auth()->user(),
                            timestamp: $timestamp,
                        );

                        Notification::make()
                            ->title('Withdrawal successful')
                            ->body("$${$data['amount']} withdrawn from {$record->user->name}'s wallet.")
                            ->success()
                            ->send();

                        $this->refreshFormData(['balance']);
                    } catch (\RuntimeException $e) {
                        Notification::make()
                            ->title('Withdrawal failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('seed')
                ->label('Auto-Generate Transactions')
                ->icon('heroicon-o-sparkles')
                ->color('warning')
                ->modalHeading('Auto-Generate Wallet Transactions')
                ->modalDescription('Automatically create multiple credit or debit transactions for this fan\'s wallet. Each transaction receives a random amount, a random description, and a random timestamp within your chosen date range. Credits increase the balance; debits decrease it. Use this to populate realistic funding history.')
                ->form([
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
                        ->helperText('The earliest date a generated transaction can have. Defaults to 3 months ago. Set this further back to make the wallet look older.'),
                    DatePicker::make('end_date')
                        ->label('Date Range — End')
                        ->default(now())
                        ->helperText('The latest date a generated transaction can have. Defaults to today.'),
                ])
                ->action(function (array $data, Wallet $record) {
                    $count = (int) $data['count'];
                    $type = $data['type'];
                    $maxAmount = (float) $data['max_amount'];
                    $startDate = $data['start_date'] ? now()->parse($data['start_date']) : now()->subMonths(3);
                    $endDate = $data['end_date'] ? now()->parse($data['end_date']) : now();
                    $totalGenerated = 0;
                    $rangeSeconds = max(1, $endDate->timestamp - $startDate->timestamp);

                    if ($type === 'debit') {
                        $maxPossible = round(mt_rand(1, max(1, (int) ($maxAmount * 100))) / 100, 2) * $count;
                        if ($record->balance < $maxPossible) {
                            Notification::make()
                                ->title('Insufficient balance')
                                ->body("The fan's balance (\${$record->balance}) may not be enough for {$count} debit transactions averaging \${$maxAmount} each. Reduce the count or max amount, or choose a different type.")
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
                        'Manual adjustment by admin',
                    ];

                    $descriptions = $type === 'credit' ? $creditDescriptions : $debitDescriptions;

                    $records = [];

                    for ($i = 0; $i < $count; $i++) {
                        $amount = round(mt_rand(1, max(1, (int) ($maxAmount * 100))) / 100, 2);
                        $randomOffset = mt_rand(0, $rangeSeconds);
                        $timestamp = (clone $startDate)->addSeconds($randomOffset);

                        $records[] = [
                            'wallet_id' => $record->id,
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

                    $record->transactions()->insert($records);

                    if ($type === 'credit') {
                        $record->increment('balance', $totalGenerated);
                    } else {
                        $record->decrement('balance', $totalGenerated);
                    }

                    $this->refreshFormData(['balance']);

                    $label = $type === 'credit' ? 'added to' : 'deducted from';

                    Notification::make()
                        ->title('Transactions generated')
                        ->body("{$count} {$type} transactions totaling \${$totalGenerated} {$label} {$record->user->name}'s wallet.")
                        ->success()
                        ->send();
                }),

            Action::make('back')
                ->label('Back to List')
                ->url(WalletResource::getUrl('index')),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['balance'] = $this->record->balance;

        return $data;
    }

    public function getRelationManagers(): array
    {
        return [
            \App\Filament\Admin\Resources\Wallets\RelationManagers\TransactionsRelationManager::class,
        ];
    }
}
