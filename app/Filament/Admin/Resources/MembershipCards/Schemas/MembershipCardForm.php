<?php

namespace App\Filament\Admin\Resources\MembershipCards\Schemas;

use App\Models\Celebrity;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class MembershipCardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Card Details')
                    ->description('Issue and manage digital fan ID cards here. Steps: (1) Select the celebrity portal and fan recipient. (2) Enter a unique card number and the matching membership tier. (3) Set the price charged for the card. (4) Define the issuance and expiry dates. (5) Toggle active status to allow the fan to display the card. (6) Record payment details and link the Stripe payment ID if applicable. Save when done.')
                    ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                    ->schema([
                        Select::make('celebrity_id')
                            ->options(fn () => Celebrity::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->helperText('Required. Choose the celebrity portal this membership card belongs to. Cards are scoped per celebrity — a fan can have different cards for different celebrities. Only active celebrities appear in the list.'),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->helperText('Required. Select the fan who will receive this digital membership card. The fan must already exist in the system. Search by name to find and assign the correct recipient.'),
                        TextInput::make('card_number')
                            ->required()
                            ->helperText('Required. A unique identifier for this physical or digital card. Use a consistent format (e.g. "MC-2024-0001" or a UUID). This number is displayed on the fan\'s digital card and used for verification. Must be unique across all cards.'),
                        TextInput::make('tier')
                            ->required()
                            ->helperText('Required. The membership tier this card represents (e.g. "Gold", "VIP", "Standard"). Must match a tier defined in the celebrity\'s configuration. The tier determines the card\'s design, color scheme, and associated perks displayed to the fan.'),
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('$')
                            ->helperText('Optional. The fee charged to the fan for issuing this card in USD. Use numeric values only (e.g. 15.00). This is separate from the membership subscription price — it covers the card issuance cost. Leave blank if the card is free.'),
                        DateTimePicker::make('issued_at')
                            ->helperText('Optional. The date and time the card was officially issued to the fan. Defaults to the current timestamp if left blank. This date is displayed on the fan\'s digital card as the "Issued On" date. Format: YYYY-MM-DD HH:MM.'),
                        DateTimePicker::make('expires_at')
                            ->helperText('Optional. The date and time the card expires and becomes invalid. After this date, the card will no longer be displayed as active to the fan (unless is_active is toggled independently). Leave blank for lifetime cards. Format: YYYY-MM-DD HH:MM.'),
                        Toggle::make('is_active')
                            ->required()
                            ->helperText('Required. Toggle ON to allow the fan to view and display this digital card on their profile. When OFF, the card is hidden from the fan\'s view even if it hasn\'t expired yet. Use this to manually revoke card access without deleting the record.'),
                        Textarea::make('rejection_reason')
                            ->label('Deactivation Reason (optional)')
                            ->placeholder('Provide a reason if deactivating this card...')
                            ->columnSpanFull(),
                        TextInput::make('payment_method')
                            ->helperText('Optional but recommended. Record how the fan paid for the card (e.g. "credit_card", "stripe", "wallet", "paypal", "bank_transfer"). Used for financial reconciliation. Free-text — keep consistent naming across records for accurate reporting.'),
                        TextInput::make('payment_ref')
                            ->helperText('Optional. The external payment transaction reference (e.g. PayPal receipt ID, bank transfer reference, or internal order number). Helps cross-reference payments across systems and simplifies dispute resolution.'),
                        Placeholder::make('payment_proof')
                            ->label('Payment Proof')
                            ->content(function ($record) {
                                $path = $record?->payment_proof;
                                if (! $path) {
                                    return '<span class="text-gray-400">—</span>';
                                }
                                if ($path === 'wallet') {
                                    return '<span class="text-emerald-600 font-medium">✅ Paid via Wallet</span>';
                                }
                                $url = Storage::disk('public')->url($path);
                                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                    return '<img src="'.$url.'" class="proof-preview-trigger max-w-xs max-h-48 rounded-lg border shadow-sm cursor-pointer hover:opacity-90 transition" data-src="'.$url.'" title="Click to view full size">';
                                }

                                return '<a href="'.$url.'" target="_blank" class="text-primary-600 underline font-medium">📎 View Proof File</a>';
                            })
                            ->helperText('Displays the uploaded payment receipt or wallet payment indicator. If the fan paid via wallet funds, it shows "Paid via Wallet". Otherwise a clickable link to the uploaded proof file is shown. This field is read-only and populated automatically through the payment process.'),
                        TextInput::make('stripe_payment_id')
                            ->helperText('Optional. The Stripe PaymentIntent ID (e.g. "pi_123abc...") if payment was processed via Stripe. Links the card issuance to a specific Stripe transaction for refunds, reconciliation, and webhook event handling. Leave blank for non-Stripe payments.'),
                    ]),
            ]);
    }
}
