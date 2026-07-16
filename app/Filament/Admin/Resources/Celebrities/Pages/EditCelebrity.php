<?php

namespace App\Filament\Admin\Resources\Celebrities\Pages;

use App\Filament\Admin\Resources\Celebrities\CelebrityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCelebrity extends EditRecord
{
    protected static string $resource = CelebrityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
