<?php

namespace App\Filament\Admin\Resources\Celebrities\Pages;

use App\Filament\Admin\Resources\Celebrities\CelebrityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCelebrity extends CreateRecord
{
    protected static string $resource = CelebrityResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
