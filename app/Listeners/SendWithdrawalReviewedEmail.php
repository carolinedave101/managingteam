<?php

namespace App\Listeners;

use App\Events\WithdrawalReviewed;
use App\Mail\FanNotificationMail;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendWithdrawalReviewedEmail
{
    public function handle(WithdrawalReviewed $event): void
    {
        $celebrity = Celebrity::find($event->celebrityId);
        $user = User::find($event->userId);
        if (! $celebrity || ! $user) {
            return;
        }

        $isApproved = $event->status === 'approved';
        $subject = $isApproved
            ? 'Withdrawal of $'.number_format($event->amount, 2).' approved'
            : 'Withdrawal of $'.number_format($event->amount, 2).' not approved';

        $mail = new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: $subject,
            bodyLines: $isApproved
                ? [
                    "Your withdrawal request has been reviewed and <strong>approved</strong> by the {$celebrity->name} Management Team.",
                    "Amount: <strong>\${$event->amount}</strong>",
                    'The funds are being processed to your selected account. Please allow 3-5 business days for the transfer to complete.',
                ]
                : [
                    'Your withdrawal request has been reviewed and was <strong>not approved</strong>.',
                    "Amount: <strong>\${$event->amount}</strong>",
                    "If you have any questions, please contact the {$celebrity->name} Management Team via the Messages page.",
                ],
            actionText: 'View Wallet',
            actionUrl: $celebrity->getPortalUrl().'/wallet',
        );

        // This is a fan notification but we send via the system
        // Use Mail facade directly
        Mail::send($mail);
    }
}
