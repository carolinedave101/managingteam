<?php

namespace App\Events;

use App\Models\MembershipCard;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class CardOrdered implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public int $celebrityId;

    public int $userId;

    public string $cardNumber;

    public string $tier;

    public function __construct(MembershipCard $card)
    {
        $this->celebrityId = $card->celebrity_id;
        $this->userId = $card->user_id;
        $this->cardNumber = $card->card_number;
        $this->tier = $card->tier;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("celebrity.{$this->celebrityId}.fan.{$this->userId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'card.ordered';
    }

    public function broadcastWith(): array
    {
        return [
            'card_number' => $this->cardNumber,
            'tier' => $this->tier,
        ];
    }
}
