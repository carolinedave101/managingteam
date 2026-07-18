<?php

namespace App\Filament\Admin\Resources\WalletTopUps\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class WalletTopUpsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('wallet.celebrity.name')
                    ->label('Celebrity')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('wallet.user.name')
                    ->label('Fan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('reference_id')
                    ->label('Proof')
                    ->formatStateUsing(function ($state) {
                        if (! $state) {
                            return '<span class="text-gray-400">—</span>';
                        }
                        if ($state === 'wallet') {
                            return '<span class="text-emerald-600 font-medium">✅ Wallet</span>';
                        }
                        $url = Storage::disk('public')->url($state);
                        $ext = strtolower(pathinfo($state, PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                            return '<img src="'.$url.'" class="proof-preview-trigger object-cover rounded border cursor-pointer hover:opacity-75 transition" style="width:48px;height:48px;min-width:48px" data-src="'.$url.'" title="Click to view full size">';
                        }

                        return '<a href="'.$url.'" target="_blank" class="text-primary-600 underline text-xs">📎 View</a>';
                    })
                    ->html(),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                EditAction::make()
                    ->label('Review')
                    ->tooltip('Click to review the fan\'s top-up request, view their payment proof, and approve or reject.'),
            ]);
    }
}
