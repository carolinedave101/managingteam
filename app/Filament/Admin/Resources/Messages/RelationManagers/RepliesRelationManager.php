<?php

namespace App\Filament\Admin\Resources\Messages\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RepliesRelationManager extends RelationManager
{
    protected static string $relationship = 'replies';

    protected static ?string $title = 'Message Thread';

    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sender.name')
                    ->label('From')
                    ->badge()
                    ->color(fn ($state) => $state === 'Admin' ? 'warning' : 'gray'),
                TextColumn::make('content')
                    ->label('Message')
                    ->limit(80)
                    ->searchable(),
                IconColumn::make('is_read')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Sent')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->defaultSort('created_at', 'asc')
            ->paginated(false);
    }
}
