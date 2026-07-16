<?php

namespace App\Filament\Admin\Resources\PrivateMeetups\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class PrivateMeetupsTable
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
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('duration')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('location')
                    ->searchable(),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
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
                    ->tooltip('Review private meetup request, update status, add internal notes.'),
            ])
            ->headerActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
