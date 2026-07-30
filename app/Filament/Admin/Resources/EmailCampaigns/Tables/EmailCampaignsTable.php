<?php

namespace App\Filament\Admin\Resources\EmailCampaigns\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmailCampaignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('celebrity.name')
                    ->label('Celebrity')
                    ->searchable()
                    ->sortable()
                    ->tooltip('The celebrity portal this campaign is for.'),
                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(50)
                    ->tooltip('Campaign email subject line.'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'draft' => 'gray',
                        'pending' => 'warning',
                        'sending' => 'info',
                        'completed' => 'success',
                        'paused' => 'warning',
                        default => 'gray',
                    })
                    ->tooltip('Current status of the campaign. Sending = actively processing.'),
                TextColumn::make('sent_count')
                    ->label('Sent')
                    ->numeric()
                    ->sortable()
                    ->tooltip('Number of emails successfully sent.'),
                TextColumn::make('failed_count')
                    ->label('Failed')
                    ->numeric()
                    ->sortable()
                    ->tooltip('Number of emails that failed to send.'),
                TextColumn::make('total_recipients')
                    ->label('Total')
                    ->numeric()
                    ->sortable()
                    ->tooltip('Total number of recipients in this campaign.'),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y g:i A')
                    ->sortable()
                    ->tooltip('When the campaign was created.'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                EditAction::make()
                    ->label('View Campaign')
                    ->tooltip('View campaign details and progress.'),
                DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->tooltip('Delete this campaign permanently.'),
            ]);
    }
}