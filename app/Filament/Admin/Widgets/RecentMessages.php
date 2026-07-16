<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Message;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentMessages extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Message::query()->with(['sender:id,name', 'celebrity:id,name'])->whereNull('parent_id')->latest()->limit(10))
            ->columns([
                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('sender.name')
                    ->label('From')
                    ->searchable(),
                TextColumn::make('celebrity.name')
                    ->label('Celebrity'),
                IconColumn::make('is_read')
                    ->label('Read')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime(),
            ]);
    }
}
