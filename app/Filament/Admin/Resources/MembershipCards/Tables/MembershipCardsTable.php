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
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '<span class="text-gray-400">—</span>';
                        if ($state === 'wallet') return '<span class="text-emerald-600 font-medium">✅ Wallet</span>';
                        $url = \Illuminate\Support\Facades\Storage::disk('public')->url($state);
                        $ext = strtolower(pathinfo($state, PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                            return '<img src="'.$url.'" class="proof-preview-trigger object-cover rounded border cursor-pointer hover:opacity-75 transition" style="width:48px;height:48px;min-width:48px" data-src="'.$url.'" title="Click to view full size">';
                        }
                        return '<a href="'.$url.'" target="_blank" class="text-primary-600 underline text-xs">📎 View</a>';
                    })
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
