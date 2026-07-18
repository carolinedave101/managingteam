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

        $subject = match ($event->status) {
            'confirmed', 'approved' => "Private meetup confirmed with {$celebrity->name}!",
            'rejected' => 'Private meetup request not approved',
            default => "Private meetup booked with {$celebrity->name}!",
        };

        $bodyLines = match ($event->status) {
            'confirmed', 'approved' => [
                "Your private meetup <strong>{$event->title}</strong> has been confirmed!",
                "The {$celebrity->name} Management Team will reach out with further details.",
            ],
            'rejected' => [
                "Unfortunately, your private meetup request <strong>{$event->title}</strong> was not approved.",
                "If you have any questions, please reach out to the {$celebrity->name} Management Team.",
            ],
            default => [
                "Your private meetup request <strong>{$event->title}</strong> has been submitted!",
                "The {$celebrity->name} Management Team will review your request and confirm the details soon.",
            ],
        };

        Mail::send(new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: $subject,
            bodyLines: $bodyLines,
            actionText: 'View Details',
            actionUrl: $celebrity->getPortalUrl().'/private-meetup',
        ));
    }
}
