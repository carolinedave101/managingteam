<?php

namespace App\Filament\Admin\Resources\RedirectLinks;

use App\Filament\Admin\Resources\RedirectLinks\Pages\CreateRedirectLink;
use App\Filament\Admin\Resources\RedirectLinks\Pages\EditRedirectLink;
use App\Filament\Admin\Resources\RedirectLinks\Pages\ListRedirectLinks;
use App\Filament\Admin\Resources\RedirectLinks\Schemas\RedirectLinkForm;
use App\Filament\Admin\Resources\RedirectLinks\Tables\RedirectLinksTable;
use App\Models\RedirectLink;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RedirectLinkResource extends Resource
{
    protected static ?string $model = RedirectLink::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLink;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'Celebrity Management';
    }

    public static function getNavigationLabel(): string
    {
        return 'Redirect Links';
    }

    public static function form(Schema $schema): Schema
    {
        return RedirectLinkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RedirectLinksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRedirectLinks::route('/'),
            'create' => CreateRedirectLink::route('/create'),
            'edit' => EditRedirectLink::route('/{record}/edit'),
        ];
    }
}
