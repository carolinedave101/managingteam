<?php

namespace App\Filament\Admin\Resources\EmailCampaigns\Pages;

use App\Filament\Admin\Resources\EmailCampaigns\EmailCampaignResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmailCampaigns extends ListRecords
{
    protected static string $resource = EmailCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Campaign'),
        ];
    }
}