<?php

namespace App\Filament\Admin\Resources\Giveaways\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GiveawayTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('celebrity.name')
                    ->label('Celebrity')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('fan.name')
                    ->label('Targeted Fan')
                    ->placeholder('All Fans')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('prize_amount')
                    ->money()
                    ->sortable(),
                TextColumn::make('entry_fee')
                    ->money()
                    ->label('Entry Fee'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'active' => 'success',
                        'draft' => 'gray',
                        'ended' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('entries_count')
                    ->label('Entries')
                    ->counts('entries')
                    ->sortable(),
                TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('ends_at')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                EditAction::make()
                    ->tooltip('Edit giveaway details, entries, and select winners.'),
            ])
            ->headerActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
