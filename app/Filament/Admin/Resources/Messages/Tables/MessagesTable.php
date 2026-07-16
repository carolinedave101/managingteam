<?php

namespace App\Filament\Admin\Resources\Messages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('celebrity.name')
                    ->label('Celebrity')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sender.name')
                    ->label('From')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('receiver.name')
                    ->label('To')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('reference_type')
                    ->searchable(),
                TextColumn::make('reference_id')
                    ->searchable(),
                TextColumn::make('subject')
                    ->searchable(),
                IconColumn::make('is_read')
                    ->boolean(),
                IconColumn::make('payment_complete')
                    ->boolean(),
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
                    ->tooltip('View or reply to this message thread.'),
            ])
            ->headerActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
