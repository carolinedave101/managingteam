<?php

namespace App\Filament\Admin\Resources\FanApplications;

use App\Filament\Admin\Resources\FanApplications\Pages\CreateFanApplication;
use App\Filament\Admin\Resources\FanApplications\Pages\EditFanApplication;
use App\Filament\Admin\Resources\FanApplications\Pages\ListFanApplications;
use App\Filament\Admin\Resources\FanApplications\Schemas\FanApplicationForm;
use App\Filament\Admin\Resources\FanApplications\Tables\FanApplicationsTable;
use App\Models\FanApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FanApplicationResource extends Resource
{
    protected static ?string $model = FanApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'Fan Management';
    }

    public static function getNavigationLabel(): string
    {
        return 'Membership Applications';
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'pending')->count();
    }

    public static function form(Schema $schema): Schema
    {
        return FanApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FanApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFanApplications::route('/'),
            'create' => CreateFanApplication::route('/create'),
            'edit' => EditFanApplication::route('/{record}/edit'),
        ];
    }
}
