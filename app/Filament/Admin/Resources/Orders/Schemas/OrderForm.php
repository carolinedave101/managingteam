<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use App\Models\Celebrity;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Details')
                    ->description('View and manage payment orders across all celebrity portals. Workflow: An order is created when a fan purchases a membership, meetup, or event ticket (pending) → Payment is confirmed (confirmed) → Service is delivered (completed) → Optionally cancelled or refunded if issues arise. Use metadata and description to track what the order is for. Stripe payment IDs are automatically populated when processed via Stripe.')
                    ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                    ->schema([
                        Select::make('celebrity_id')
                            ->options(fn () => Celebrity::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->helperText('The celebrity portal this order belongs to. Orders are scoped per celebrity so each portal only shows its own transactions. Select the correct celebrity to ensure proper reporting and reconciliation.'),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->helperText('The registered fan user who placed this order. The user must be a fan of the selected celebrity. This links the order to the user\'s purchase history and dashboard.'),
                        TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->helperText('The total order amount charged to the fan, in USD. Enter a numeric value (e.g. 29.99, 150.00). Must match the Stripe Payment Intent amount if processed via Stripe. This is the final amount after any discounts or adjustments.'),
                        TextInput::make('currency')
                            ->required()
                            ->default('USD')
                            ->helperText('The ISO 4217 three-letter currency code for this order (e.g. USD, EUR, GBP). Defaults to USD. Must match the currency used in Stripe if processed via Stripe. All pricing across the platform is typically in USD unless configured otherwise.'),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                                'refunded' => 'Refunded',
                            ])
                            ->required()
                            ->default('pending')
                            ->helperText('Workflow: Pending (awaiting payment confirmation) → Confirmed (payment received, processing) → Completed (service delivered/fulfilled) → Cancelled (order voided before fulfillment) or Refunded (payment returned to the fan). Changing to "refunded" should correspond with processing a refund in Stripe if applicable.'),
                        TextInput::make('stripe_payment_id')
                            ->helperText('The Stripe Payment Intent ID or Charge ID (e.g. pi_3Oq1234ABCD or ch_3Oq1234ABCD). Populated automatically when payment is processed through Stripe. Use this to look up the transaction in the Stripe dashboard for refunds or dispute resolution.'),
                        TextInput::make('payment_method')
                            ->helperText('The payment method used (e.g. "stripe", "wallet", "bank_transfer", "manual"). Populated automatically when processed via Stripe. For manual orders (e.g. cash, bank transfer), enter the method manually. This helps track payment channel usage and reconciliation.'),
                        TextInput::make('payment_ref')
                            ->helperText('The payment reference or transaction ID from the payment provider (e.g. Stripe charge ID, PayPal transaction ID, bank reference number). Used for financial reconciliation and customer support inquiries.'),
                        Textarea::make('description')
                            ->columnSpanFull()
                            ->helperText('Describe what this order covers — e.g. "Monthly membership — Gold Tier", "Meet & Greet ticket — July 2026", "Private meetup — 60 min session". This helps identify the order at a glance and links the payment to the specific product or service purchased.'),
                        TextInput::make('metadata')
                            ->helperText('Optional JSON-encoded metadata for this order — e.g. {"tier": "gold", "billing_period": "monthly", "coupon": "WELCOME10"}. Used for advanced reporting, webhook handling, and integration with external systems. Leave blank if not needed.'),
                    ]),
            ]);
    }
}
