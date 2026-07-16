<?php

namespace App\Events;

use App\Models\MeetGreetTicket;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class MeetGreetBooked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public int $celebrityId;

    public int $userId;

    public string $eventTitle;

    public int $quantity;

    public float $totalPrice;

    public function __construct(MeetGreetTicket $ticket)
    {
        $this->celebrityId = $ticket->celebrity_id;
        $this->userId = $ticket->user_id;
        $this->eventTitle = $ticket->event->title ?? 'Meet & Greet';
        $this->quantity = $ticket->quantity;
        $this->totalPrice = $ticket->total_price;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("celebrity.{$this->celebrityId}.fan.{$this->userId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'meetgreet.booked';
    }

    public function broadcastWith(): array
    {
        return [
            'event' => $this->eventTitle,
            'quantity' => $this->quantity,
            'total' => $this->totalPrice,
        ];
    }
}
