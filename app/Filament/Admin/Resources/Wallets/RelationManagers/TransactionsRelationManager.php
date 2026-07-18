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
                    ->formatStateUsing(function ($state) {
                        if (! $state || str_starts_with($state, 'admin_')) {
                            return '—';
                        }
                        $url = Storage::disk('public')->url($state);
                        $ext = strtolower(pathinfo($state, PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                            return '<img src="'.$url.'" class="proof-preview-trigger object-cover rounded border cursor-pointer hover:opacity-75 transition" style="width:48px;height:48px;min-width:48px" data-src="'.$url.'" title="Click to view full size">';
                        }

                        return '<a href="'.$url.'" target="_blank" class="text-primary-600 underline text-xs">📎 View</a>';
                    })
                    ->html(),
                TextColumn::make('creator.name')
                    ->label('By'),
            ])
            ->filters([])
            ->defaultSort('created_at', 'desc');
    }
}
