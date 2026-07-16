<?php

namespace App\Listeners;

use App\Events\MeetGreetBooked;
use App\Mail\FanNotificationMail;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendMeetGreetBookedEmail
{
    public function handle(MeetGreetBooked $event): void
    {
        $celebrity = Celebrity::find($event->celebrityId);
        $user = User::find($event->userId);
        if (! $celebrity || ! $user) {
            return;
        }

        Mail::send(new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: "Tickets booked for {$event->eventTitle}!",
            bodyLines: [
                "You've booked <strong>{$event->quantity} ticket(s)</strong> for <strong>{$event->eventTitle}</strong>!",
                'Total: <strong>$'.number_format($event->totalPrice, 2).'</strong>',
                'Your tickets are being processed. You\'ll receive confirmation once the payment is verified.',
            ],
            actionText: 'View Events',
            actionUrl: $celebrity->getPortalUrl().'/meet-greet',
        ));
    }
}
