<?php

namespace App\Events;

use App\Models\Membership;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class MembershipUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public int $celebrityId;

    public int $userId;

    public string $tier;

    public string $status;

    public function __construct(Membership $membership)
    {
        $this->celebrityId = $membership->celebrity_id;
        $this->userId = $membership->user_id;
        $this->tier = $membership->tier;
        $this->status = $membership->is_active ? 'active' : 'inactive';
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("celebrity.{$this->celebrityId}.fan.{$this->userId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'membership.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'tier' => $this->tier,
            'status' => $this->status,
        ];
    }
}
