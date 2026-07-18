<?php

namespace App\Filament\Admin\Resources\MembershipCards\Pages;

use App\Events\CardOrdered;
use App\Filament\Admin\Resources\MembershipCards\MembershipCardResource;
use App\Models\MembershipCard;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMembershipCard extends EditRecord
{
    protected static string $resource = MembershipCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadPdf')
                ->label('Download Card PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn (MembershipCard $record): string => route('admin.membership-cards.download', $record))
                ->openUrlInNewTab()
                ->visible(fn (MembershipCard $record): bool => (bool) $record->is_active)
                ->color('success'),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;
        $original = $record->getOriginal();

        if ((bool) ($original['is_active'] ?? false) !== (bool) $record->is_active) {
            $action = $record->is_active ? 'approved' : 'cancelled';
            safe_event(new CardOrdered($record, $action));
        }
    }
}
