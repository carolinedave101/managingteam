<?php

namespace App\Listeners;

use App\Events\MembershipUpdated;
use App\Mail\FanNotificationMail;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendMembershipUpdatedEmail
{
    public function handle(MembershipUpdated $event): void
    {
        $celebrity = Celebrity::find($event->celebrityId);
        $user = User::find($event->userId);
        if (! $celebrity || ! $user) {
            return;
        }

        $isActive = $event->status === 'active';
        $subject = $isActive
            ? "Membership upgraded to {$event->tier}!"
            : 'Membership cancelled';

        Mail::send(new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: $subject,
            bodyLines: $isActive
                ? [
                    "Great news! Your membership has been upgraded to <strong>{$event->tier}</strong>.",
                    'You now have access to exclusive content, priority meet & greet booking, and more.',
                ]
                : [
                    "Your <strong>{$event->tier}</strong> membership has been cancelled.",
                    'You can re-subscribe at any time to regain access to exclusive perks.',
                ],
            actionText: $isActive ? 'View Membership' : 'Browse Plans',
            actionUrl: $celebrity->getPortalUrl().'/membership',
        ));
    }
}
