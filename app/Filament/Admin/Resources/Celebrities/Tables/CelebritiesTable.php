<?php

namespace App\Filament\Admin\Resources\Celebrities\Tables;

use App\Models\Celebrity;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CelebritiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->colors([
                        'primary' => 'general',
                        'indigo' => 'movie_star',
                        'warning' => 'country_singer',
                        'danger' => 'musician',
                        'purple' => 'adult_star',
                    ])
                    ->sortable(),
                TextColumn::make('gender')
                    ->badge()
                    ->colors([
                        'info' => 'male',
                        'pink' => 'female',
                    ])
                    ->sortable(),
                TextColumn::make('country')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Subdomain slug copied!')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('portal_url')
                    ->label('Portal URL')
                    ->state(fn (Celebrity $record) => $record->getPortalUrl())
                    ->url(fn (Celebrity $record) => $record->getPortalUrl(), shouldOpenInNewTab: true)
                    ->copyable()
                    ->copyMessage('Portal URL copied to clipboard!')
                    ->icon('heroicon-o-link')
                    ->extraAttributes(['class' => 'font-mono text-xs']),
                TextColumn::make('fans_count')
                    ->label('Fans')
                    ->counts('fans')
                    ->sortable(),
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
                    ->tooltip('Configure this celebrity portal — profile, theme, tiers, payments, pricing, and features.'),
            ])
            ->headerActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
