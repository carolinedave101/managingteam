<?php

namespace App\Events;

use App\Models\FanApplication;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class ApplicationReviewed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public int $celebrityId;

    public int $userId;

    public string $status;

    public function __construct(FanApplication $application)
    {
        $this->celebrityId = $application->celebrity_id;
        $this->userId = $application->user_id;
        $this->status = $application->status;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("celebrity.{$this->celebrityId}.fan.{$this->userId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'application.reviewed';
    }

    public function broadcastWith(): array
    {
        return [
            'status' => $this->status,
        ];
    }
}
