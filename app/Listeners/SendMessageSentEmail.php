<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Mail\FanNotificationMail;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendMessageSentEmail
{
    public function handle(MessageSent $event): void
    {
        $celebrity = Celebrity::find($event->celebrityId);
        $user = User::find($event->receiverId);
        if (! $celebrity || ! $user) {
            return;
        }

        Mail::send(new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: "New message from {$celebrity->name} Team",
            bodyLines: [
                "You've received a new message from the <strong>{$celebrity->name}</strong> team.",
                "<strong>Subject:</strong> {$event->subject}",
                "<em>{$event->message}</em>",
            ],
            actionText: 'View Message',
            actionUrl: $celebrity->getPortalUrl().'/messages',
        ));
    }
}
