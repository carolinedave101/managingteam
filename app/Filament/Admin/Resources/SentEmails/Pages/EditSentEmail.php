<?php

namespace App\Filament\Admin\Resources\SentEmails\Pages;

use App\Filament\Admin\Resources\SentEmails\SentEmailResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditSentEmail extends EditRecord
{
    protected static string $resource = SentEmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to List')
                ->url(SentEmailResource::getUrl('index')),
        ];
    }
}
