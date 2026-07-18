<?php

namespace App\Filament\Admin\Resources\SentEmails\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SentEmailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Email Details')
                    ->description('View the full content of this sent email. This is a log of all outgoing emails from the system.')
                    ->schema([
                        Placeholder::make('to')
                            ->label('To')
                            ->content(fn ($record) => $record->to)
                            ->helperText('The recipient of this email.'),
                        Placeholder::make('subject')
                            ->label('Subject')
                            ->content(fn ($record) => $record->subject)
                            ->helperText('The email subject line.'),
                        Placeholder::make('body')
                            ->label('Email Body')
                            ->content(fn ($record) => $record->body)
                            ->helperText('The full content of the email.'),
                        Placeholder::make('sent_at')
                            ->label('Sent At')
                            ->content(fn ($record) => $record->sent_at?->format('M d, Y g:i A'))
                            ->helperText('When this email was sent.'),
                    ]),
            ]);
    }
}
