<?php

namespace App\Filament\Admin\Resources\SentEmails;

use App\Filament\Admin\Resources\SentEmails\Pages\EditSentEmail;
use App\Filament\Admin\Resources\SentEmails\Pages\ListSentEmails;
use App\Filament\Admin\Resources\SentEmails\Schemas\SentEmailForm;
use App\Filament\Admin\Resources\SentEmails\Tables\SentEmailsTable;
use App\Models\SentEmail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SentEmailResource extends Resource
{
    protected static ?string $model = SentEmail::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }

    public static function getNavigationLabel(): string
    {
        return 'Sent Emails';
    }

    public static function form(Schema $schema): Schema
    {
        return SentEmailForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SentEmailsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSentEmails::route('/'),
            'edit' => EditSentEmail::route('/{record}/edit'),
        ];
    }
}
