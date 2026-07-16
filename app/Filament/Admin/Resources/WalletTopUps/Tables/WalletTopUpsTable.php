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
                    ->formatStateUsing(fn ($state) => $state ? '<a href="'.Storage::url($state).'" target="_blank" class="text-primary-600 underline">📎 View Proof</a>' : '—')
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
