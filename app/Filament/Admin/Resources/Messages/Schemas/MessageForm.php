<?php

namespace App\Filament\Admin\Resources\Messages\Schemas;

use App\Models\Celebrity;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Message Details')
                    ->description('Create and manage threaded messages between fans, admins, and celebrities. Messages can be general inquiries, payment-related, or reference-specific (e.g. meet & greet bookings). Use the fields below to set sender, receiver, content, and tracking status.')
                    ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                    ->schema([
                        Select::make('celebrity_id')
                            ->options(fn () => Celebrity::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->helperText('Choose the celebrity portal this message belongs to. All fan queries and admin replies are scoped per celebrity. This field determines which fan base and portal the message context applies to. Required — messages cannot exist without a celebrity association.'),
                        Select::make('sender_id')
                            ->options(fn () => User::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->helperText('Select the user (fan or admin) who sent this message. The sender is the originator of the conversation thread. For fan-initiated messages, this will typically be a fan user; for admin replies, an admin user. Required — every message must have a sender.'),
                        Select::make('receiver_id')
                            ->options(fn () => User::pluck('name', 'id'))
                            ->searchable()
                            ->helperText('Select the intended recipient (fan, admin, or celebrity) for this message. The receiver is the target of the conversation. If empty, this may represent a broadcast or unassigned message. Optional — useful when the message is directed to a specific user rather than a general thread.'),
                        TextInput::make('reference_type')
                            ->required()
                            ->default('general')
                            ->helperText('The category of entity this message is linked to. Common values: "general" (standard inquiry), "meet_greet" (meet & greet booking), "payment" (payment-related), "membership" (subscription/tier), "support" (tech support). The reference type determines how the system processes and displays the message. Defaults to "general". Required — must be a meaningful slug string.'),
                        TextInput::make('reference_id')
                            ->helperText('The database ID of the specific entity this message references (e.g. the meet & greet ID, payment ID, or membership ID). Used in conjunction with reference_type to build a polymorphic link. Leave empty for general messages. Must be a valid numeric ID if filled.'),
                        TextInput::make('subject')
                            ->required()
                            ->helperText('A concise subject line for the message, similar to an email subject. This is displayed in inbox views and thread summaries. Keep it descriptive (e.g. "Question about VIP membership", "Meet & greet on June 15th"). Required — max 255 characters recommended.'),
                        Textarea::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('The full body content of the message. Supports plain text. Use this to write the complete message details, including any context, questions, or responses. Required for all messages. This is what the recipient will read in the messaging interface.'),
                        Toggle::make('is_read')
                            ->required()
                            ->helperText('Track whether the recipient has read this message. When OFF (default for new messages), the message is marked as unread — this affects unread badge counts and notification indicators. Toggle ON to mark the message as read when the recipient has viewed it.'),
                        Toggle::make('payment_complete')
                            ->required()
                            ->helperText('Indicates whether any referenced payment has been completed. Only relevant for messages with reference_type "payment". When ON, the system considers the payment fully resolved. Use in combination with reference_type=payment and reference_id to link to a specific payment record. Leave OFF for non-payment messages.'),
                    ]),
            ]);
    }
}
