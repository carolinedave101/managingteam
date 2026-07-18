<?php

namespace App\Listeners;

use App\Mail\FanNotificationMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    public function handle(Registered $event): void
    {
        $user = $event->user;
        if ($user->role !== 'fan') {
            return;
        }

        $celebrity = $user->celebrities()->first();
        if (! $celebrity) {
            return;
        }

        Mail::send(new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: "Welcome to {$celebrity->name}'s community!",
            bodyLines: [
                "Welcome to <strong>{$celebrity->name}</strong>'s fan community!",
                'You can now explore exclusive content, apply for membership, and connect with other fans.',
                'Head over to your dashboard to get started.',
            ],
            actionText: 'Go to Dashboard',
            actionUrl: $celebrity->getPortalUrl().'/dashboard',
        ));
    }
}
