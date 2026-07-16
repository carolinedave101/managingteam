<?php

namespace App\Listeners;

use App\Events\ApplicationReviewed;
use App\Mail\FanNotificationMail;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendApplicationReviewedEmail
{
    public function handle(ApplicationReviewed $event): void
    {
        $celebrity = Celebrity::find($event->celebrityId);
        $user = User::find($event->userId);
        if (! $celebrity || ! $user) {
            return;
        }

        $approved = $event->status === 'approved';
        $subject = $approved
            ? "Welcome to {$celebrity->name}'s community!"
            : 'Application status update';

        Mail::send(new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: $subject,
            bodyLines: $approved
                ? [
                    "Congratulations! Your application to join <strong>{$celebrity->name}</strong>'s community has been approved!",
                    'You can now explore exclusive content, choose a membership plan, and participate in events.',
                ]
                : [
                    "Your application for <strong>{$celebrity->name}</strong>'s community was <strong>{$event->status}</strong>.",
                    'If you have any questions, please reach out to our support team.',
                ],
            actionText: $approved ? 'Go to Dashboard' : 'Contact Support',
            actionUrl: $approved
                ? $celebrity->getPortalUrl().'/dashboard'
                : $celebrity->getPortalUrl().'/messages/create',
        ));
    }
}
