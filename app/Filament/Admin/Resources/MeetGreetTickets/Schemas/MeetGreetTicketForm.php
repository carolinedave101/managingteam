<?php

namespace App\Filament\Admin\Resources\MeetGreetTickets\Schemas;

use App\Models\Celebrity;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class MeetGreetTicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ticket Details')
                    ->description('Track and manage ticket purchases for meet & greet events here. Steps: (1) Select the celebrity portal and event. (2) Choose the fan purchaser and set ticket quantity. (3) Enter the total price paid. (4) Set the ticket status (Pending → Confirmed → Completed / Cancelled / Refunded). (5) Record payment details and link the Stripe payment ID if applicable. Save when done.')
                    ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                    ->schema([
                        Select::make('celebrity_id')
                            ->options(fn () => Celebrity::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->helperText('Required. Choose the celebrity portal hosting the meet & greet event. This ensures the ticket is linked to the correct fan community. Only celebrities with active portals appear in the dropdown.'),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->helperText('Required. Select the fan who purchased the ticket(s). The fan must already be registered. Search by name to find the correct buyer. One ticket record = one fan purchaser, even if buying multiple tickets.'),
                        Select::make('event_id')
                            ->relationship('event', 'title')
                            ->searchable()
                            ->required()
                            ->helperText('Required. Choose the specific meet & greet event this ticket grants access to. Only events under the selected celebrity are shown. The event date, location, and time slot details are inherited from the event configuration.'),
                        TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->helperText('Required. Number of tickets (admissions) the fan is purchasing for this event. Minimum is 1. Affects total_price calculation and event capacity tracking. For example, a fan buying 3 tickets for themselves and 2 guests would enter 3 here.'),
                        TextInput::make('total_price')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->helperText('Required. The total amount paid by the fan in USD for all tickets combined. This is quantity × unit price. Use numeric values only (e.g. 149.97). This drives revenue reporting and payment reconciliation.'),
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
                            ->helperText('Required. Current lifecycle status of the ticket: Pending = awaiting payment/approval, Confirmed = payment received and access granted, Completed = event has passed and ticket was used, Cancelled = ticket voided before use, Refunded = payment returned to fan. Use the workflow: Pending → Confirmed → Completed. Cancelled/Refunded can be applied at any point.'),
                        TextInput::make('payment_method')
                            ->helperText('Optional but recommended. Record the payment method used (e.g. "stripe", "credit_card", "wallet", "paypal", "bank_transfer", "cash"). Consistent naming is important for accurate payment reporting. This field supports free-text entry.'),
                        TextInput::make('payment_ref')
                            ->helperText('Optional. The external payment reference or transaction ID (e.g. Stripe charge ID, PayPal transaction ID, or bank reference number). Use this to trace the payment in the gateway\'s dashboard for refunds or disputes.'),
                        Placeholder::make('payment_proof')
                            ->label('Payment Proof')
                            ->content(fn ($record) => $record?->payment_proof
                                ? ($record->payment_proof === 'wallet'
                                    ? '✅ Paid via Wallet'
                                    : '<a href="'.Storage::url($record->payment_proof).'" target="_blank" class="text-primary-600 underline">📎 View Proof File</a>')
                                : 'N/A')
                            ->helperText('Displays the uploaded payment receipt/evidence or a wallet payment indicator. "Paid via Wallet" means the fan used their internal wallet balance. Otherwise a clickable link to the uploaded proof file is shown. This is a read-only display field populated by the payment workflow.'),
                        TextInput::make('stripe_payment_id')
                            ->helperText('Optional. The Stripe PaymentIntent ID (e.g. "pi_abc123...") for Stripe-processed payments. Links this ticket purchase to a specific Stripe transaction, enabling automated refunds, receipt generation, and webhook synchronization. Leave blank for non-Stripe payments.'),
                    ]),
            ]);
    }
}
