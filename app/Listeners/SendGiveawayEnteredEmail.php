<?php

namespace App\Listeners;

use App\Events\GiveawayEntered;
use App\Mail\FanNotificationMail;
use Illuminate\Support\Facades\Mail;

class SendGiveawayEnteredEmail
{
    public function handle(GiveawayEntered $event): void
    {
        $entry = $event->entry;
        $celebrity = $entry->celebrity;
        $user = $entry->user;

        if (! $celebrity || ! $user) {
            return;
        }

        $giveaway = $entry->giveaway;

        try {
            Mail::send(new FanNotificationMail(
                celebrity: $celebrity,
                user: $user,
                subject: 'You\'re in! Giveaway entry confirmed',
                bodyLines: [
                    'Your entry for <strong>'.e($giveaway->title).'</strong> has been confirmed.',
                    'Your entry number is <strong>#'.$entry->entry_number.'</strong>.',
                    $giveaway->entry_fee > 0 ? 'Payment status: <strong>'.ucfirst($entry->payment_method ?? 'pending review').'</strong>' : '',
                    'We wish you the best of luck! The winner(s) will be announced by the management team.',
                ],
                actionText: 'View Giveaways',
                actionUrl: $celebrity->getPortalUrl().'/giveaways',
            ));
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
