<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Mail\AdminNotificationMail;
use App\Mail\FanNotificationMail;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendMessageSentEmail
{
    public function handle(MessageSent $event): void
    {
        $celebrity = Celebrity::find($event->celebrityId);
        if (! $celebrity) {
            return;
        }

        if ($event->receiverId) {
            $user = User::find($event->receiverId);
            if (! $user) {
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

            return;
        }

        // New thread from fan: send confirmation to the sender
        $fan = User::find($event->senderId);
        if ($fan) {
            Mail::send(new FanNotificationMail(
                celebrity: $celebrity,
                user: $fan,
                subject: "Message sent to {$celebrity->name} Management Team",
                bodyLines: [
                    "Your message has been sent to the {$celebrity->name} Management Team.",
                    "<strong>Subject:</strong> {$event->subject}",
                    'You will receive a reply soon.',
                ],
                actionText: 'View Messages',
                actionUrl: $celebrity->getPortalUrl().'/messages',
            ));
        }

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new AdminNotificationMail(
                celebrity: $celebrity,
                actionType: 'New Fan Message',
                bodyLines: [
                    'A fan has sent a new message.',
                    "From: <strong>{$event->senderName}</strong>",
                    "Subject: <strong>{$event->subject}</strong>",
                    "<em>{$event->message}</em>",
                ],
                actionUrl: url('/admin/messages'),
            ));
        }
    }
}
