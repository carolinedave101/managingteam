<?php

namespace App\Filament\Admin\Resources\Giveaways\RelationManagers;

use App\Models\Giveaway;
use App\Models\GiveawayEntry;
use App\Models\Wallet;
use Filament\Actions\Action;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class GiveawayEntriesRelationManager extends RelationManager
{
    protected static string $relationship = 'entries';

    protected static ?string $title = 'Fan Entries';

    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('entry_number')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Fan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'entered' => 'info',
                        'won' => 'success',
                        'lost' => 'gray',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                IconColumn::make('prize_credited')
                    ->label('Prize Paid')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                TextColumn::make('payment_method')
                    ->label('Payment')
                    ->toggleable(),
                TextColumn::make('claimed_at')
                    ->label('Claimed')
                    ->dateTime()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Entered')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('entry_number')
            ->filters([])
            ->headerActions([])
            ->actions([
                Action::make('Mark as Winner')
                    ->label(fn (GiveawayEntry $record) => $record->status === 'won' ? 'Already Winner' : 'Mark as Winner')
                    ->icon('heroicon-o-trophy')
                    ->color('success')
                    ->size(Size::Small)
                    ->disabled(fn (GiveawayEntry $record) => $record->status === 'won')
                    ->requiresConfirmation()
                    ->modalHeading('Confirm Winner')
                    ->modalDescription(fn (GiveawayEntry $record) => "Credit \${$record->giveaway->prize_amount} to {$record->user->name}'s wallet and mark them as a winner?")
                    ->action(function (GiveawayEntry $record) {
                        $giveaway = $record->giveaway;
                        $wallet = Wallet::findOrCreateForUser($record->user, $giveaway->celebrity);
                        $wallet->credit(
                            (float) $giveaway->prize_amount,
                            "You won the \"{$giveaway->title}\" giveaway! Prize credited to your wallet.",
                            'giveaway',
                            (string) $giveaway->id,
                            Auth::user(),
                        );
                        $record->update([
                            'status' => 'won',
                            'prize_credited' => true,
                            'claimed_at' => now(),
                        ]);
                    }),
            ])
            ->bulkActions([]);
    }
}
