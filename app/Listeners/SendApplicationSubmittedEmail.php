<?php

namespace App\Listeners;

use App\Events\ApplicationSubmitted;
use App\Mail\FanNotificationMail;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendApplicationSubmittedEmail
{
    public function handle(ApplicationSubmitted $event): void
    {
        $celebrity = Celebrity::find($event->celebrityId);
        $user = User::find($event->userId);
        if (! $celebrity || ! $user) {
            return;
        }

        Mail::send(new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: "Application submitted to {$celebrity->name}",
            bodyLines: [
                "Your fan application for <strong>{$celebrity->name}</strong> has been received!",
                "The {$celebrity->name} Management Team is reviewing your application and you will be notified once it's approved.",
            ],
            actionText: 'Check Status',
            actionUrl: $celebrity->getPortalUrl().'/apply',
        ));
    }
}
