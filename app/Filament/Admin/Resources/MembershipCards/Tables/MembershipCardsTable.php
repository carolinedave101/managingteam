<?php

namespace App\Filament\Admin\Resources\MembershipCards\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class MembershipCardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('celebrity.name')
                    ->label('Celebrity')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Fan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('card_number')
                    ->searchable(),
                TextColumn::make('tier')
                    ->searchable(),
                TextColumn::make('price')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('issued_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('payment_method')
                    ->searchable(),
                TextColumn::make('payment_ref')
                    ->searchable(),
                TextColumn::make('payment_proof')
                    ->label('Proof')
                    ->formatStateUsing(fn ($state) => $state === 'wallet' ? '✅ Wallet' : ($state ? '<a href="'.Storage::url($state).'" target="_blank">📎 View</a>' : '—'))
                    ->html(),
                TextColumn::make('stripe_payment_id')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->tooltip('Manage membership card, update tier or active status.'),
            ])
            ->headerActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
