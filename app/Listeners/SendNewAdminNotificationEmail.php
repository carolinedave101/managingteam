<?php

namespace App\Listeners;

use App\Events\NewAdminNotification;
use App\Mail\AdminNotificationMail;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendNewAdminNotificationEmail
{
    public function handle(NewAdminNotification $event): void
    {
        $celebrity = Celebrity::find($event->celebrityId);
        if (! $celebrity) {
            return;
        }

        $admins = User::where('role', 'admin')->get();
        if ($admins->isEmpty()) {
            return;
        }

        $actionLabels = [
            'new_application' => 'New Fan Application',
            'new_membership' => 'New Membership Request',
            'new_card' => 'New Membership Card Order',
            'new_meetgreet' => 'New Meet & Greet Booking',
            'new_private_meetup' => 'New Private Meetup Request',
        ];
        $actionType = $actionLabels[$event->type] ?? 'New Activity';

        foreach ($admins as $admin) {
            try {
                Mail::to($admin->email)->send(new AdminNotificationMail(
                    celebrity: $celebrity,
                    actionType: $actionType,
                    bodyLines: [$event->message],
                    fan: null,
                    actionUrl: $event->link,
                ));
            } catch (\Throwable $e) {
                report($e);
            }
        }
    }
}
