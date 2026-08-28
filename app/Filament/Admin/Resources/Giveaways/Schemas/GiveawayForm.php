<?php

namespace App\Filament\Admin\Resources\Giveaways\Schemas;

use App\Models\Celebrity;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GiveawayForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Giveaway Details')
                    ->description('Create and manage a giveaway contest for a celebrity portal. Fans can enter for free or with a fee, and winners receive a wallet credit prize. After creating, set status to "active" and the giveaway will appear on the fan portal.')
                    ->columns(['default' => 1])
                    ->schema([
                        Select::make('celebrity_id')
                            ->options(fn () => Celebrity::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->live()
                            ->helperText('The celebrity whose fans will see and enter this giveaway.'),
                        Select::make('fan_id')
                            ->label('Target Fan (optional)')
                            ->placeholder('All Fans')
                            ->options(fn (callable $get) => $get('celebrity_id')
                                ? User::whereHas('celebrities', fn ($q) => $q->where('celebrities.id', $get('celebrity_id')))->pluck('name', 'id')
                                : [])
                            ->searchable()
                            ->nullable()
                            ->helperText('Leave empty to make this giveaway available to all fans. Select a specific fan to target only them.'),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Public giveaway title shown to fans — e.g. "Summer Autograph Giveaway"'),
                        RichEditor::make('description')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Full description of the giveaway. Include what fans need to know, how to enter, and any rules.'),
                        TextInput::make('prize_description')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Short description of the prize — e.g. "Signed Poster + Merch Bundle"'),
                        TextInput::make('prize_amount')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->helperText('Amount credited to the winner\'s wallet when you mark them as a winner.'),
                        TextInput::make('prize_image_url')
                            ->url()
                            ->helperText('URL to an image showing the prize (optional).'),
                        TextInput::make('entry_fee')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->default(0)
                            ->helperText('Entry fee fans must pay. Set to 0 for free entry.'),
                        TextInput::make('winner_count')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->helperText('How many winners to select. You manually pick winners from the entries list.'),
                        TextInput::make('max_entries_per_fan')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->helperText('Maximum entries each fan can submit (e.g. 1 = one entry per fan, 7 = daily entry for a week).'),
                        DateTimePicker::make('starts_at')
                            ->helperText('When the giveaway opens. Leave blank to start immediately.'),
                        DateTimePicker::make('ends_at')
                            ->helperText('When the giveaway closes. After this date, fans cannot enter.'),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Active',
                                'ended' => 'Ended',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('draft')
                            ->helperText('Draft = hidden. Active = visible to fans. Ended = closed for entries. Cancelled = removed.'),
                        Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->helperText('Master toggle. When off, the giveaway is hidden regardless of status.'),
                    ]),
            ]);
    }
}
