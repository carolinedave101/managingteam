<?php

namespace App\Filament\Admin\Resources\WalletTopUps\Pages;

use App\Events\WalletUpdated;
use App\Filament\Admin\Resources\WalletTopUps\WalletTopUpResource;
use App\Mail\FanNotificationMail;
use App\Models\WalletTransaction;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

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
                ->form([
                    Textarea::make('rejection_reason')
                        ->label('Reason for Rejection (optional)')
                        ->placeholder('Let the fan know why their top-up was rejected...'),
                ])
                ->modalHeading('Reject Top-Up Request')
                ->modalDescription('This will mark the request as rejected. The fan\'s payment proof will be disregarded and no funds will be credited. You can optionally provide a reason so the fan understands why.')
                ->modalSubmitActionLabel('Yes, Reject Request')
                ->action(function (array $data) {
                    $txn = $this->record;

                    $txn->update([
                        'status' => 'rejected',
                        'rejection_reason' => $data['rejection_reason'] ?? null,
                    ]);

                    // Notify the fan
                    $fan = $txn->wallet->user;
                    $celebrity = $txn->wallet->celebrity;
                    if ($fan && $celebrity) {
                        Mail::send(new FanNotificationMail(
                            celebrity: $celebrity,
                            user: $fan,
                            subject: 'Top-up request not approved',
                            bodyLines: [
                                'Your top-up request was reviewed but was <strong>not approved</strong>.',
                                'Amount: <strong>$'.number_format($txn->amount, 2).'</strong>',
                                $data['rejection_reason'] ? 'Reason: '.e($data['rejection_reason']) : 'If you have any questions, please contact the team.',
                            ],
                            actionText: 'View Wallet',
                            actionUrl: $celebrity->getPortalUrl().'/wallet',
                        ));
                    }

                    Notification::make()
                        ->title('Top-Up Rejected')
                        ->body('The top-up request from '.$fan->name.' has been rejected.')
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
