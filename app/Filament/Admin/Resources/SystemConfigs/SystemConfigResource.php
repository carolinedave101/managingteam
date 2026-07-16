<?php

namespace App\Filament\Admin\Resources\SystemConfigs;

use App\Filament\Admin\Resources\SystemConfigs\Pages\CreateSystemConfig;
use App\Filament\Admin\Resources\SystemConfigs\Pages\EditSystemConfig;
use App\Filament\Admin\Resources\SystemConfigs\Pages\ListSystemConfigs;
use App\Filament\Admin\Resources\SystemConfigs\Schemas\SystemConfigForm;
use App\Filament\Admin\Resources\SystemConfigs\Tables\SystemConfigsTable;
use App\Models\SystemConfig;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SystemConfigResource extends Resource
{
    protected static ?string $model = SystemConfig::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }

    public static function getNavigationLabel(): string
    {
        return 'Global Settings';
    }

    public static function form(Schema $schema): Schema
    {
        return SystemConfigForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SystemConfigsTable::configure($table);
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
            'index' => ListSystemConfigs::route('/'),
            'create' => CreateSystemConfig::route('/create'),
            'edit' => EditSystemConfig::route('/{record}/edit'),
        ];
    }
}
