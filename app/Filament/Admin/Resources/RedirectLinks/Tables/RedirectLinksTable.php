<?php

namespace App\Filament\Admin\Resources\RedirectLinks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RedirectLinksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Short code copied!')
                    ->icon('heroicon-o-link')
                    ->extraAttributes(['class' => 'font-mono text-xs']),
                TextColumn::make('short_url')
                    ->label('Short URL')
                    ->state(fn ($record) => url('/r/'.$record->code))
                    ->url(fn ($record) => url('/r/'.$record->code), shouldOpenInNewTab: true)
                    ->copyable()
                    ->copyMessage('Short URL copied to clipboard!')
                    ->icon('heroicon-o-clipboard')
                    ->extraAttributes(['class' => 'font-mono text-xs']),
                TextColumn::make('celebrity.name')
                    ->label('Celebrity')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('target_url')
                    ->label('Target URL')
                    ->limit(40)
                    ->url(fn ($record) => $record->target_url, shouldOpenInNewTab: true)
                    ->copyable()
                    ->extraAttributes(['class' => 'font-mono text-xs']),
                TextColumn::make('clicks')
                    ->sortable()
                    ->numeric()
                    ->icon('heroicon-o-eye'),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                EditAction::make()
                    ->tooltip('Edit redirect link, update target URL, toggle active status.'),
            ])
            ->headerActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
