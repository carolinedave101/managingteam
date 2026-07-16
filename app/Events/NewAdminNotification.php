<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class NewAdminNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public string $type;

    public string $message;

    public int $celebrityId;

    public ?string $link;

    public function __construct(string $type, string $message, int $celebrityId, ?string $link = null)
    {
        $this->type = $type;
        $this->message = $message;
        $this->celebrityId = $celebrityId;
        $this->link = $link;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("celebrity.{$this->celebrityId}.admin"),
            new PrivateChannel('admin.global'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'admin.notification';
    }

    public function broadcastWith(): array
    {
        return [
            'type' => $this->type,
            'message' => $this->message,
            'link' => $this->link,
        ];
    }
}
