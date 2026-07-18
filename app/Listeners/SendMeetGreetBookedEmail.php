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

        $subject = match ($event->status) {
            'confirmed', 'approved' => "Tickets confirmed for {$event->eventTitle}!",
            'rejected' => "Tickets not approved for {$event->eventTitle}",
            default => "Tickets booked for {$event->eventTitle}!",
        };

        $bodyLines = match ($event->status) {
            'confirmed', 'approved' => [
                "Your tickets for <strong>{$event->eventTitle}</strong> have been confirmed!",
                "Quantity: <strong>{$event->quantity}</strong>",
                'Total: <strong>$'.number_format($event->totalPrice, 2).'</strong>',
            ],
            'rejected' => [
                "Unfortunately, your ticket request for <strong>{$event->eventTitle}</strong> was not approved.",
                "If you have any questions, please reach out to the {$celebrity->name} Management Team.",
            ],
            default => [
                "You've booked <strong>{$event->quantity} ticket(s)</strong> for <strong>{$event->eventTitle}</strong>!",
                'Total: <strong>$'.number_format($event->totalPrice, 2).'</strong>',
                'Your tickets are being processed. You\'ll receive confirmation once the payment is verified.',
            ],
        };

        Mail::send(new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: $subject,
            bodyLines: $bodyLines,
            actionText: 'View Events',
            actionUrl: $celebrity->getPortalUrl().'/meet-greet',
        ));
    }
}
