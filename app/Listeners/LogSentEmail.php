<?php

namespace App\Listeners;

use App\Models\SentEmail;
use Illuminate\Mail\Events\MessageSent;

class LogSentEmail
{
    public function handle(MessageSent $event): void
    {
        $to = '';
        foreach ($event->message->getTo() ?? [] as $addr) {
            $to .= $addr->toString().', ';
        }
        $to = rtrim($to, ', ');

        SentEmail::create([
            'to' => $to,
            'subject' => $event->message->getSubject() ?? '(no subject)',
            'body' => $event->message->getTextBody() ?? $event->message->getHtmlBody() ?? '',
            'headers' => json_encode($event->message->getHeaders()->toArray()),
            'sent_at' => now(),
        ]);
    }
}
