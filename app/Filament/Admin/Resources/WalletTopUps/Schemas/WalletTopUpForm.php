<?php

namespace App\Filament\Admin\Resources\WalletTopUps\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class WalletTopUpForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Top-Up Request Review')
                    ->description('Review the fan\'s payment proof and details below. To finalize, use the Approve or Reject buttons at the top of the page.')
                    ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                    ->schema([
                        TextInput::make('wallet.user.name')
                            ->label('Fan')
                            ->disabled()
                            ->helperText('The fan who submitted this top-up request.'),
                        TextInput::make('wallet.celebrity.name')
                            ->label('Celebrity Portal')
                            ->disabled()
                            ->helperText('The celebrity portal this top-up belongs to.'),
                        TextInput::make('amount')
                            ->label('Requested Amount')
                            ->prefix('$')
                            ->disabled()
                            ->helperText('The amount the fan wants to add to their wallet.'),
                        TextInput::make('description')
                            ->label('Description')
                            ->disabled()
                            ->helperText('The payment method the fan used to send funds.'),
                        TextInput::make('status')
                            ->label('Current Status')
                            ->disabled()
                            ->helperText('"pending" means this request is awaiting your review.'),
                        Placeholder::make('reference_id')
                            ->label('Payment Proof')
                            ->content(function ($record) {
                                $path = $record?->reference_id;
                                if (!$path) return '<span class="text-gray-400">—</span>';
                                if ($path === 'wallet') return '<span class="text-emerald-600 font-medium">✅ Paid via Wallet</span>';
                                $url = \Illuminate\Support\Facades\Storage::disk('public')->url($path);
                                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                    return '<img src="'.$url.'" class="proof-preview-trigger max-w-xs max-h-48 rounded-lg border shadow-sm cursor-pointer hover:opacity-90 transition" data-src="'.$url.'" title="Click to view full size">';
                                }
                                return '<a href="'.$url.'" target="_blank" class="text-primary-600 underline font-medium">📎 View Proof File</a>';
                            })
                            ->helperText('Click to open the fan\'s uploaded payment proof in a new tab. Verify that the fan actually made the payment before approving.'),
                    ]),
            ]);
    }
}
