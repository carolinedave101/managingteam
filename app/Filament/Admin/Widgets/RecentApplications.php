<?php

namespace App\Filament\Admin\Widgets;

use App\Models\FanApplication;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentApplications extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => FanApplication::query()->with(['user:id,name', 'celebrity:id,name'])->latest()->limit(10))
            ->columns([
                TextColumn::make('user.name')
                    ->label('Fan')
                    ->searchable(),
                TextColumn::make('celebrity.name')
                    ->label('Celebrity')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'warning',
                    }),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime(),
            ]);
    }
}
