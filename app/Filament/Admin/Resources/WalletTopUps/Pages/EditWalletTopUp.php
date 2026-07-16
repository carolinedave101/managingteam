<?php

namespace App\Filament\Admin\Resources\WalletTopUps\Pages;

use App\Events\WalletUpdated;
use App\Filament\Admin\Resources\WalletTopUps\WalletTopUpResource;
use App\Models\WalletTransaction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditWalletTopUp extends EditRecord
{
    protected static string $resource = WalletTopUpResource::class;

    public WalletTransaction $topUp;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label('Approve Top-Up')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Approve Top-Up Request')
                ->modalDescription('By approving, the requested amount will be credited to the fan\'s wallet immediately. The fan will see the updated balance on their end. Only approve if you have verified that the fan\'s payment proof is valid.')
                ->modalSubmitActionLabel('Yes, Approve & Credit Wallet')
                ->action(function () {
                    $txn = $this->record;

                    $txn->wallet->increment('balance', $txn->amount);

                    $txn->update(['status' => 'completed']);

                    safe_event(new WalletUpdated($txn->wallet, 'credit', (float) $txn->amount));

                    Notification::make()
                        ->title('Top-Up Approved')
                        ->body('$'.number_format($txn->amount, 2).' credited to '.$txn->wallet->user->name.'\'s wallet.')
                        ->success()
                        ->send();

                    $this->redirect(WalletTopUpResource::getUrl('index'));
                }),

            Action::make('reject')
                ->label('Reject Top-Up')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Reject Top-Up Request')
                ->modalDescription('This will mark the request as rejected. The fan\'s payment proof will be disregarded and no funds will be credited. Use this if the proof is invalid, the payment didn\'t go through, or the request is suspicious.')
                ->modalSubmitActionLabel('Yes, Reject Request')
                ->action(function () {
                    $txn = $this->record;

                    $txn->update(['status' => 'rejected']);

                    Notification::make()
                        ->title('Top-Up Rejected')
                        ->body('The top-up request from '.$txn->wallet->user->name.' has been rejected.')
                        ->danger()
                        ->send();

                    $this->redirect(WalletTopUpResource::getUrl('index'));
                }),

            Action::make('back')
                ->label('Back to List')
                ->url(WalletTopUpResource::getUrl('index')),
        ];
    }
}
