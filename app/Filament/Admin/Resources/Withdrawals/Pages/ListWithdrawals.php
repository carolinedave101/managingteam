<?php

namespace App\Filament\Admin\Resources\Withdrawals\Pages;

use App\Filament\Admin\Resources\Withdrawals\WithdrawalResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListWithdrawals extends ListRecords
{
    protected static string $resource = WithdrawalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->action(fn () => $this->redirect(WithdrawalResource::getUrl('index'))),
        ];
    }
}
