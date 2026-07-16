<?php

namespace App\Filament\Admin\Resources\Wallets\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    protected static ?string $title = 'Funding History';

    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state) => $state === 'credit' ? 'success' : 'danger'),
                TextColumn::make('amount')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('reference_type')
                    ->label('Source'),
                TextColumn::make('reference_id')
                    ->label('Proof')
                    ->formatStateUsing(fn ($state) => $state && !str_starts_with($state, 'admin_') ? '<a href="'.Storage::url($state).'" target="_blank" class="text-primary-600 underline">📎 View</a>' : '—')
                    ->html(),
                TextColumn::make('creator.name')
                    ->label('By'),
            ])
            ->filters([])
            ->defaultSort('created_at', 'desc');
    }
}
