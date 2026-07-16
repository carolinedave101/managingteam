<?php

namespace App\Filament\Admin\Resources\RedirectLinks\Pages;

use App\Filament\Admin\Resources\RedirectLinks\RedirectLinkResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRedirectLink extends CreateRecord
{
    protected static string $resource = RedirectLinkResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
