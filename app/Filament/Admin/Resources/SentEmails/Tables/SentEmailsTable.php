<?php

namespace App\Filament\Admin\Resources\SentEmails\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SentEmailsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('to')
                    ->label('To')
                    ->searchable()
                    ->sortable()
                    ->tooltip('The recipient email address.'),
                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(60)
                    ->tooltip('The email subject line.'),
                TextColumn::make('sent_at')
                    ->label('Sent At')
                    ->dateTime('M d, Y g:i A')
                    ->sortable()
                    ->tooltip('When this email was sent.'),
            ])
            ->defaultSort('sent_at', 'desc')
            ->actions([
                EditAction::make()
                    ->label('View')
                    ->tooltip('View the full email content.'),
            ]);
    }
}
