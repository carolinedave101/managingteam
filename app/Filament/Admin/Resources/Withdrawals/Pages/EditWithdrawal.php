<?php

namespace App\Filament\Admin\Resources\Withdrawals\Pages;

use App\Events\WithdrawalReviewed;
use App\Filament\Admin\Resources\Withdrawals\WithdrawalResource;
use App\Models\Withdrawal;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditWithdrawal extends EditRecord
{
    protected static string $resource = WithdrawalResource::class;

    public Withdrawal $withdrawal;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label('Approve Withdrawal')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Approve Withdrawal Request')
                ->modalDescription('By approving, the requested amount will be deducted from the fan\'s wallet. The fan will be notified that their withdrawal has been approved and is being processed. This action cannot be undone.')
                ->modalSubmitActionLabel('Yes, Approve & Deduct')
                ->action(function () {
                    $wd = $this->record;

                    if ($wd->status !== 'pending') {
                        Notification::make()
                            ->title('Already Reviewed')
                            ->body('This withdrawal has already been '.$wd->status.'.')
                            ->warning()
                            ->send();

                        return;
                    }

                    if ($wd->wallet->balance < $wd->amount) {
                        Notification::make()
                            ->title('Insufficient Balance')
                            ->body('The fan\'s wallet balance ($'.number_format($wd->wallet->balance, 2).') is not enough to cover this withdrawal ($'.number_format($wd->amount, 2).').')
                            ->danger()
                            ->send();

                        return;
                    }

                    $wd->wallet->decrement('balance', $wd->amount);

                    $wd->update([
                        'status' => 'approved',
                        'reviewed_at' => now(),
                        'reviewed_by' => auth()->id(),
                    ]);

                    safe_event(new WithdrawalReviewed($wd));

                    Notification::make()
                        ->title('Withdrawal Approved')
                        ->body('$'.number_format($wd->amount, 2).' deducted from '.$wd->user->name.'\'s wallet.')
                        ->success()
                        ->send();

                    $this->redirect(WithdrawalResource::getUrl('index'));
                }),

            Action::make('reject')
                ->label('Reject Withdrawal')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->form([
                    Textarea::make('admin_notes')
                        ->label('Reason for Rejection (optional)')
                        ->placeholder('Let the fan know why their withdrawal request was rejected...'),
                ])
                ->modalHeading('Reject Withdrawal Request')
                ->modalDescription('This will mark the withdrawal as rejected. The fan will be notified and the funds will remain in their wallet. You can optionally provide a reason so the fan understands why.')
                ->modalSubmitActionLabel('Yes, Reject Request')
                ->action(function (array $data) {
                    $wd = $this->record;

                    if ($wd->status !== 'pending') {
                        Notification::make()
                            ->title('Already Reviewed')
                            ->body('This withdrawal has already been '.$wd->status.'.')
                            ->warning()
                            ->send();

                        return;
                    }

                    $wd->update([
                        'status' => 'rejected',
                        'admin_notes' => $data['admin_notes'] ?? null,
                        'reviewed_at' => now(),
                        'reviewed_by' => auth()->id(),
                    ]);

                    safe_event(new WithdrawalReviewed($wd));

                    Notification::make()
                        ->title('Withdrawal Rejected')
                        ->body('The withdrawal request from '.$wd->user->name.' has been rejected.')
                        ->danger()
                        ->send();

                    $this->redirect(WithdrawalResource::getUrl('index'));
                }),

            Action::make('back')
                ->label('Back to List')
                ->url(WithdrawalResource::getUrl('index')),
        ];
    }
}
