<?php

namespace App\Listeners;

use App\Events\WithdrawalRequested;
use App\Mail\AdminNotificationMail;
use App\Mail\FanNotificationMail;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendWithdrawalRequestedEmail
{
    public function handle(WithdrawalRequested $event): void
    {
        $celebrity = Celebrity::find($event->celebrityId);
        if (! $celebrity) {
            return;
        }

        // Notify the fan
        $user = User::find($event->userId);
        if ($user) {
            Mail::send(new FanNotificationMail(
                celebrity: $celebrity,
                user: $user,
                subject: 'Withdrawal request received',
                bodyLines: [
                    "Your withdrawal request of <strong>\${$event->amount}</strong> has been received.",
                    "The {$celebrity->name} Management Team will review your request and update you once a decision has been made.",
                    'You can check the status of your withdrawal anytime in your Wallet.',
                ],
                actionText: 'View Wallet',
                actionUrl: $celebrity->getPortalUrl().'/wallet',
            ));
        }

        // Notify all admins
        $admins = User::where('role', 'admin')->get();
        if ($admins->isEmpty()) {
            return;
        }

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new AdminNotificationMail(
                celebrity: $celebrity,
                actionType: 'Withdrawal Requested',
                bodyLines: [
                    "A fan has requested a withdrawal of <strong>\${$event->amount}</strong>.",
                    "Fan: <strong>{$event->fanName}</strong>",
                    'Review this request in the Withdrawals section of the admin panel.',
                ],
                actionUrl: url('/admin/withdrawals'),
            ));
        }
    }
}
