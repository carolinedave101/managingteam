<?php

namespace App\Filament\Admin\Resources\EmailCampaigns\Schemas;

use App\Models\Celebrity;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;

class EmailCampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        $operation = $schema->getOperation() ?? 'create';

        if ($operation === 'edit') {
            return self::editSchema($schema);
        }

        return self::createSchema($schema);
    }

    protected static function createSchema(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Wizard\Step::make('Audience')
                        ->description('Who do you want to reach?')
                        ->schema([
                            Section::make('Select Audience')
                                ->description('Choose between sending to existing fans of a celebrity or importing a CSV file with email leads.')
                                ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                                ->schema([
                                    Select::make('celebrity_id')
                                        ->label('Celebrity Portal')
                                        ->options(fn () => Celebrity::pluck('name', 'id'))
                                        ->searchable()
                                        ->required()
                                        ->live()
                                        ->helperText('The campaign will use this celebrity\'s branding (colors, logo, name).'),
                                    Toggle::make('send_to_fans')
                                        ->label('Send to all existing fans')
                                        ->default(true)
                                        ->live()
                                        ->helperText(fn ($get) => $get('celebrity_id')
                                            ? 'This will add all currently approved fans of the selected celebrity to the campaign.'
                                            : 'Select a celebrity first to see fan counts.'),
                                    FileUpload::make('csv_file')
                                        ->label('Import CSV with email leads')
                                        ->acceptedFileTypes(['text/csv', 'text/plain'])
                                        ->maxSize(2048)
                                        ->helperText('Upload a CSV file with columns: email (required), name (optional). Rows without a valid email will be skipped. Max 2MB.'),
                                ]),
                        ]),

                    Wizard\Step::make('Content')
                        ->description('What\'s your message?')
                        ->schema([
                            Section::make('Campaign Content')
                                ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                                ->schema([
                                    TextInput::make('subject')
                                        ->label('Subject Line')
                                        ->required()
                                        ->maxLength(255)
                                        ->placeholder('e.g. Exciting News from Jennie!')
                                        ->helperText('The email subject line. Keep it concise and engaging.'),
                                    RichEditor::make('body')
                                        ->label('Email Body')
                                        ->required()
                                        ->helperText('Write your campaign message. HTML formatting is supported. Include images, links, and anything you need.'),
                                ]),
                        ]),

                    Wizard\Step::make('Review & Launch')
                        ->description('Review and start the campaign')
                        ->schema([
                            Section::make('Campaign Summary')
                                ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                                ->schema([
                                    Placeholder::make('summary_celebrity')
                                        ->label('Celebrity')
                                        ->content(fn ($get) => Celebrity::find($get('celebrity_id'))?->name ?? '—'),
                                    Placeholder::make('summary_subject')
                                        ->label('Subject')
                                        ->content(fn ($get) => $get('subject') ?? '—'),
                                    Placeholder::make('summary_limits')
                                        ->label('Rate Limits')
                                        ->content('50 emails/hour · 1,000 emails/day'),
                                ]),
                        ]),
                ])
                    ->columnSpanFull(),
            ]);
    }

    protected static function editSchema(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Campaign Details')
                    ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                    ->schema([
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'sending' => 'Sending',
                                'completed' => 'Completed',
                                'paused' => 'Paused',
                            ])
                            ->helperText('Current campaign status. Set to "sending" to start or resume processing.'),
                    ]),
            ]);
    }
}