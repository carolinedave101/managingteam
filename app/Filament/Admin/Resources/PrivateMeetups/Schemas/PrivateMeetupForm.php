<?php

namespace App\Filament\Admin\Resources\PrivateMeetups\Schemas;

use App\Models\Celebrity;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class PrivateMeetupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Meetup Details')
                    ->description('Manage one-on-one private meetup requests from fans. Workflow: A fan requests a meetup (pending) → Admin reviews and confirms a date/time (confirmed) → Meetup occurs (completed) or is cancelled (cancelled). Use the Notes field to record internal observations throughout the process. Payment fields should be filled when the fan has paid.')
                    ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                    ->schema([
                        Select::make('celebrity_id')
                            ->options(fn () => Celebrity::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->helperText('Choose the celebrity whose portal this meetup belongs to. This links the meetup to the correct subdomain and ensures only fans of this celebrity can view or book it.'),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->helperText('The fan user who requested this meetup. This must be a registered user who is already a fan of the selected celebrity (linked via celebrity_fan pivot).'),
                        TextInput::make('title')
                            ->required()
                            ->helperText('A short, descriptive title for the meetup (e.g. "Coffee Chat" or "VIP Photo Session"). This is displayed on the fan\'s dashboard and admin panel. Keep it clear and concise.'),
                        Textarea::make('description')
                            ->columnSpanFull()
                            ->helperText('Provide a full description of what the meetup entails — what the fan can expect, any special requests, or arrangements. This is shared with the fan so be professional and clear.'),
                        DateTimePicker::make('date')
                            ->required()
                            ->helperText('The scheduled date and time for the meetup. When confirming a request, set this to the agreed time. The fan will see this on their dashboard. All times are in UTC — convert to your local timezone when coordinating.'),
                        TextInput::make('duration')
                            ->required()
                            ->numeric()
                            ->default(60)
                            ->helperText('How long the meetup will last, in minutes. Default is 60 minutes. Common values: 30 (short), 60 (standard), 90 (extended), 120 (premium). This is displayed to the fan for scheduling purposes.'),
                        TextInput::make('location')
                            ->helperText('The physical venue address (e.g. "123 Main St, Suite 4B") or a virtual meeting link (e.g. Zoom, Google Meet URL). The fan will see this location in their confirmation details. Leave blank if not yet determined.'),
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->helperText('The total price charged to the fan for this meetup, in USD. Enter a numeric value (e.g. 150.00). This amount is processed through Stripe or the wallet system. Must match the agreed price from the membership tier or custom arrangement.'),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('pending')
                            ->helperText('Workflow: Pending (awaiting admin confirmation) → Confirmed (date/time finalized, fan notified) → Completed (meetup occurred successfully) or Cancelled (meetup called off, refund may be due). Changing to "confirmed" triggers a notification to the fan.'),
                        Textarea::make('notes')
                            ->columnSpanFull()
                            ->helperText('Internal admin notes visible only in the admin panel. Use this to record special arrangements, fan preferences, follow-up items, or any issues that arose. Not visible to the fan.'),
                        TextInput::make('payment_method')
                            ->helperText('The payment method used by the fan (e.g. "stripe", "wallet", "bank_transfer"). Populated automatically if processed through Stripe. Manually enter if payment was received outside the system.'),
                        TextInput::make('payment_ref')
                            ->helperText('The transaction reference ID from the payment processor (e.g. Stripe charge ID, PayPal transaction ID, or bank transfer reference). Used for reconciliation and refund processing.'),
                        Placeholder::make('payment_proof')
                            ->label('Payment Proof')
                            ->content(fn ($record) => $record?->payment_proof
                                ? ($record->payment_proof === 'wallet'
                                    ? '✅ Paid via Wallet'
                                    : '<a href="'.Storage::url($record->payment_proof).'" target="_blank" class="text-primary-600 underline">📎 View Proof File</a>')
                                : 'N/A')
                            ->helperText('Displays the uploaded proof of payment (e.g. screenshot, receipt PDF). Shows "Paid via Wallet" if the fan used wallet credits, or a clickable link to the uploaded file. Read-only — to replace, re-upload from the fan-facing form.'),
                        TextInput::make('stripe_payment_id')
                            ->helperText('The Stripe Payment Intent ID or Charge ID (e.g. pi_3Oq1234ABCD or ch_3Oq1234ABCD). Populated automatically when payment is processed via Stripe. Useful for manual refunds or dispute tracking in the Stripe dashboard.'),
                    ]),
            ]);
    }
}
