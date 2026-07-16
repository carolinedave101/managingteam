<?php

namespace App\Listeners;

use App\Events\PrivateMeetupBooked;
use App\Mail\FanNotificationMail;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendPrivateMeetupBookedEmail
{
    public function handle(PrivateMeetupBooked $event): void
    {
        $celebrity = Celebrity::find($event->celebrityId);
        $user = User::find($event->userId);
        if (! $celebrity || ! $user) {
            return;
        }

        Mail::send(new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: "Private meetup booked with {$celebrity->name}!",
            bodyLines: [
                "Your private meetup request <strong>{$event->title}</strong> has been submitted!",
                "Status: <strong>{$event->status}</strong>",
                'The team will review your request and confirm the details soon.',
            ],
            actionText: 'View Details',
            actionUrl: $celebrity->getPortalUrl().'/private-meetup',
        ));
    }
}
