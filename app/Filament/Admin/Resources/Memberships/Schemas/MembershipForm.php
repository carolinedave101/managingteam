<?php

namespace App\Filament\Admin\Resources\Memberships\Schemas;

use App\Models\Celebrity;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class MembershipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Membership Details')
                    ->description('Create and manage fan subscription records here. Steps: (1) Select the celebrity portal and fan subscriber. (2) Choose the membership tier and set the price. (3) Define the subscription period via start/end dates. (4) Toggle active status and auto-renewal. (5) Record payment method, reference, and proof. (6) Link the Stripe subscription ID if payment was processed via Stripe. Save when done.')
                    ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                    ->schema([
                        Select::make('celebrity_id')
                            ->options(fn () => Celebrity::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->helperText('Required. Choose the celebrity this membership belongs to. This determines which portal/fan base the subscription is linked to. Only active celebrities appear in the list.'),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->helperText('Required. Select the fan who is purchasing or receiving this membership. The fan must already be registered on the platform. Search by name to find the correct user.'),
                        TextInput::make('tier')
                            ->required()
                            ->helperText('Required. Enter the membership tier name exactly as configured (e.g. "Bronze", "Silver", "Gold", "Platinum"). This determines which perks and access levels the fan receives. Must match a valid tier in the celebrity\'s configuration.'),
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->helperText('Required. The subscription amount charged to the fan in USD. Use numeric values only (e.g. 29.99). This is the total price for the subscription period, before any platform fees.'),
                        DateTimePicker::make('start_date')
                            ->helperText('Optional. The date and time the subscription period begins. Defaults to the moment of creation if left blank. Affects billing cycles and access grant timing. Format: YYYY-MM-DD HH:MM.'),
                        DateTimePicker::make('end_date')
                            ->helperText('Optional. The date and time the subscription period expires. Leave blank for indefinite/ongoing subscriptions. Once past this date, the system will automatically deactivate access if is_active is enabled. Format: YYYY-MM-DD HH:MM.'),
                        Toggle::make('is_active')
                            ->required()
                            ->helperText('Required. Toggle ON to grant the fan access to premium features tied to this membership tier. When OFF, the fan loses access to gated content, even if the membership record exists. Auto-renews will reactivate this.'),
                        Toggle::make('auto_renew')
                            ->required()
                            ->helperText('Required. Toggle ON to enable automatic renewal at the end of the subscription period. When ON, the system will attempt to charge the saved payment method and extend the end_date automatically. OFF means the subscription lapses after end_date.'),
                        TextInput::make('payment_method')
                            ->helperText('Optional but recommended. Record how the fan paid (e.g. "credit_card", "paypal", "stripe", "wallet", "bank_transfer", "cash"). Used for reconciliation and reporting. Free-text field — keep values consistent across records.'),
                        TextInput::make('payment_ref')
                            ->helperText('Optional. The external payment transaction ID or reference number (e.g. PayPal transaction ID, bank transfer reference, or internal order number). Useful for cross-referencing with payment gateways and accounting.'),
                        Placeholder::make('payment_proof')
                            ->label('Payment Proof')
                            ->content(fn ($record) => $record?->payment_proof
                                ? ($record->payment_proof === 'wallet'
                                    ? '✅ Paid via Wallet'
                                    : '<a href="'.Storage::url($record->payment_proof).'" target="_blank" class="text-primary-600 underline">📎 View Proof File</a>')
                                : 'N/A')
                            ->helperText('Displays the uploaded proof of payment file or wallet indicator. If the fan paid via wallet, it shows "Paid via Wallet". Otherwise, a link to the uploaded receipt/screenshot is shown. This is read-only and managed through the payment flow.'),
                        TextInput::make('stripe_sub_id')
                            ->helperText('Optional. The Stripe subscription ID (e.g. "sub_123abc...") if payment was processed through Stripe. This links the internal membership record to the Stripe subscription object for billing management, refunds, and webhook handling.'),
                    ]),
            ]);
    }
}
