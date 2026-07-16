<?php

namespace App\Events;

use App\Models\PrivateMeetup;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class PrivateMeetupBooked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public int $celebrityId;

    public int $userId;

    public string $title;

    public string $status;

    public function __construct(PrivateMeetup $meetup)
    {
        $this->celebrityId = $meetup->celebrity_id;
        $this->userId = $meetup->user_id;
        $this->title = $meetup->title;
        $this->status = $meetup->status;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("celebrity.{$this->celebrityId}.fan.{$this->userId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'private.meetup.booked';
    }

    public function broadcastWith(): array
    {
        return [
            'title' => $this->title,
            'status' => $this->status,
        ];
    }
}
