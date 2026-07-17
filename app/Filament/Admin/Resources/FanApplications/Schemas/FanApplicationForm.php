<?php

namespace App\Filament\Admin\Resources\FanApplications\Schemas;

use App\Models\Celebrity;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class FanApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Application Details')
                    ->description('Review fan membership applications and approve or reject them. Workflow: A fan submits an application (pending) → Admin reviews the bio, reason, and social links → Admin checks payment proof → Admin either approves (fan gains access) or rejects (fan is denied) → Record who reviewed it and any notes. Only approved fans appear in the celebrity\'s fan list and can access gated content.')
                    ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                    ->schema([
                        Select::make('celebrity_id')
                            ->options(fn () => Celebrity::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->helperText('The celebrity portal this application targets. Each celebrity has its own fan base and application process. Select the correct one — this determines which celebrity\'s content the fan will access upon approval.'),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->helperText('The registered user who submitted this application. Only existing users can apply. The user must not already be an approved fan of this celebrity (duplicate applications should be flagged manually).'),
                        Textarea::make('bio')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('The fan\'s self-written biography or introduction. Review this to gauge their genuine interest and suitability. Look for completeness, authenticity, and alignment with the celebrity\'s community guidelines. This is visible to admins only.'),
                        Textarea::make('reason')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('The fan\'s stated reason for wanting to join this celebrity\'s portal. Use this to assess motivation — genuine fans typically provide specific, thoughtful reasons. Generic or empty responses may indicate low engagement.'),
                        Textarea::make('social_links')
                            ->columnSpanFull()
                            ->helperText('Social media URLs provided by the fan (e.g. Instagram, Twitter, TikTok profiles). Use these to verify the fan\'s identity and genuine interest. Enter one URL per line. Optional but recommended for verification.'),
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('$')
                            ->helperText('The application fee paid by the fan, in USD. Set to 0 if no fee is required. Verify that payment_proof exists (or wallet credit was used) before approving. Common values: 0 (free), 9.99, 19.99, 49.99 depending on the tier.'),
                        TextInput::make('payment_method')
                            ->helperText('The payment method the fan used for the application fee (e.g. "stripe", "wallet", "bank_transfer"). Populated automatically if processed online. This helps track which payment channels are being used.'),
                        Placeholder::make('payment_proof')
                            ->label('Payment Proof')
                            ->content(function ($record) {
                                $path = $record?->payment_proof;
                                if (!$path) return '<span class="text-gray-400">—</span>';
                                if ($path === 'wallet') return '<span class="text-emerald-600 font-medium">✅ Paid via Wallet</span>';
                                $url = \Illuminate\Support\Facades\Storage::disk('public')->url($path);
                                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                    return '<img src="'.$url.'" class="proof-preview-trigger max-w-xs max-h-48 rounded-lg border shadow-sm cursor-pointer hover:opacity-90 transition" data-src="'.$url.'" title="Click to view full size">';
                                }
                                return '<a href="'.$url.'" target="_blank" class="text-primary-600 underline font-medium">📎 View Proof File</a>';
                            })
                            ->helperText('Displays the uploaded payment proof (e.g. receipt screenshot, bank transfer confirmation). Shows "Paid via Wallet" if the fan used wallet credits, or a clickable link to view the uploaded file. Read-only — verify before approving the application.'),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->default('pending')
                            ->live()
                            ->helperText('Workflow: Pending (awaiting review) → Approved (fan gains access to the celebrity portal and gated content) or Rejected (fan is denied entry, optionally with notes explaining why). Once approved, the fan appears in the celebrity_fan pivot table and can access exclusive features. Changing from approved back to pending will revoke access.'),
                        Textarea::make('rejection_reason')
                            ->label('Rejection Reason (optional)')
                            ->placeholder('Provide a clear reason for rejection so the fan understands why...')
                            ->visible(fn ($get) => $get('status') === 'rejected')
                            ->columnSpanFull(),
                        TextInput::make('reviewed_by')
                            ->helperText('Enter your name or admin username to record who reviewed this application. Useful for audit trails and accountability. This field is manually entered (not auto-populated) so fill it in when you perform the review.'),
                        Textarea::make('notes')
                            ->columnSpanFull()
                            ->helperText('Private admin notes about this application. Use this to record why you approved or rejected, any concerns, follow-up actions needed, or special arrangements. Not visible to the fan. Reference the reason for rejection if applicable.'),
                    ]),
            ]);
    }
}
