<?php

namespace App\Listeners;

use App\Events\WalletUpdated;
use App\Mail\FanNotificationMail;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendWalletUpdatedEmail
{
    public function handle(WalletUpdated $event): void
    {
        $celebrity = Celebrity::find($event->celebrityId);
        $user = User::find($event->userId);
        if (! $celebrity || ! $user) {
            return;
        }

        $isCredit = $event->type === 'credit';
        $subject = $isCredit
            ? '$'.number_format($event->amount, 2).' added to your wallet'
            : '$'.number_format($event->amount, 2).' spent from your wallet';

        Mail::send(new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: $subject,
            bodyLines: $isCredit
                ? [
                    "<strong>\${$event->amount}</strong> has been added to your {$celebrity->name} wallet.",
                    'Your new balance is <strong>$'.number_format($event->balance, 2).'</strong>.',
                ]
                : [
                    "<strong>\${$event->amount}</strong> has been deducted from your {$celebrity->name} wallet.",
                    'Your remaining balance is <strong>$'.number_format($event->balance, 2).'</strong>.',
                    $event->balance < 10 ? 'Your balance is running low — top up to keep enjoying seamless payments.' : '',
                ],
            actionText: 'View Wallet',
            actionUrl: $celebrity->getPortalUrl().'/wallet',
        ));
    }
}
