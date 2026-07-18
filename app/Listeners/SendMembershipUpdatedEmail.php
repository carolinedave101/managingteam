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

        $subject = match ($event->action) {
            'approved' => "Membership upgraded to {$event->tier}!",
            'cancelled' => 'Membership cancelled',
            default => "Membership request submitted for {$event->tier}",
        };

        $bodyLines = match ($event->action) {
            'approved' => [
                "Great news! Your membership has been upgraded to <strong>{$event->tier}</strong>.",
                'You now have access to exclusive content, priority meet & greet booking, and more.',
            ],
            'cancelled' => [
                "Your <strong>{$event->tier}</strong> membership has been cancelled.",
                'You can re-subscribe at any time to regain access to exclusive perks.',
            ],
            default => [
                "Your request for the <strong>{$event->tier}</strong> membership has been submitted.",
                'Once your payment is verified, your membership will be activated.',
            ],
        };

        $actionText = $event->action === 'cancelled' ? 'Browse Plans' : 'View Membership';

        Mail::send(new FanNotificationMail(
            celebrity: $celebrity,
            user: $user,
            subject: $subject,
            bodyLines: $bodyLines,
            actionText: $actionText,
            actionUrl: $celebrity->getPortalUrl().'/membership',
        ));
    }
}
