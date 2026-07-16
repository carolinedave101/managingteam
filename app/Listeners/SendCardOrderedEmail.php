<?php

namespace App\Listeners;

use App\Events\CardOrdered;
use App\Mail\FanNotificationMail;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendCardOrderedEmail
{
    public function handle(CardOrdered $event): void
    {
        $celebrity = Celebrity::find($event->celebrityId);
        $user = User::find($event->userId);
        if (! $celebrity || ! $user) {
            return;
        }

        Mail::send(new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: 'Membership card ordered!',
            bodyLines: [
                "Your <strong>{$event->tier}</strong> membership card has been ordered!",
                "Card number: <strong>{$event->cardNumber}</strong>",
                'Once your payment is verified, your digital card will be available in your dashboard.',
            ],
            actionText: 'View Card',
            actionUrl: $celebrity->getPortalUrl().'/membership-card',
        ));
    }
}
