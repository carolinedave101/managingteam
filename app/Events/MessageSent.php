<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public string $message;

    public string $senderName;

    public string $subject;

    public int $celebrityId;

    public ?int $receiverId;

    public string $adminChannel = 'admin';

    public function __construct(Message $message)
    {
        $this->message = $message->content;
        $this->senderName = $message->sender?->name ?? 'System';
        $this->subject = $message->subject;
        $this->celebrityId = $message->celebrity_id;
        $this->receiverId = $message->receiver_id;
    }

    public function broadcastOn(): array
    {
        if ($this->receiverId) {
            return [
                new PrivateChannel("celebrity.{$this->celebrityId}.fan.{$this->receiverId}"),
            ];
        }

        return [
            new PrivateChannel("celebrity.{$this->celebrityId}.admin"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'from' => $this->senderName,
            'subject' => $this->subject,
            'preview' => mb_substr(strip_tags($this->message), 0, 100),
        ];
    }
}
