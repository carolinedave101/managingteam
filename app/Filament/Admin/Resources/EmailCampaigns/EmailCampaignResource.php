<?php

namespace App\Filament\Admin\Resources\EmailCampaigns;

use App\Filament\Admin\Resources\EmailCampaigns\Pages\CreateEmailCampaign;
use App\Filament\Admin\Resources\EmailCampaigns\Pages\EditEmailCampaign;
use App\Filament\Admin\Resources\EmailCampaigns\Pages\ListEmailCampaigns;
use App\Filament\Admin\Resources\EmailCampaigns\Schemas\EmailCampaignForm;
use App\Filament\Admin\Resources\EmailCampaigns\Tables\EmailCampaignsTable;
use App\Models\EmailCampaign;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EmailCampaignResource extends Resource
{
    protected static ?string $model = EmailCampaign::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'Email Marketing';
    }

    public static function getNavigationLabel(): string
    {
        return 'Email Campaigns';
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'sending')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function form(Schema $schema): Schema
    {
        return EmailCampaignForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmailCampaignsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmailCampaigns::route('/'),
            'create' => CreateEmailCampaign::route('/create'),
            'edit' => EditEmailCampaign::route('/{record}/edit'),
        ];
    }
}