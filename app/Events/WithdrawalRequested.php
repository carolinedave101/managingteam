<?php

namespace App\Events;

use App\Models\Withdrawal;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class WithdrawalRequested implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public int $celebrityId;

    public int $userId;

    public string $message;

    public float $amount;

    public string $fanName;

    public function __construct(Withdrawal $withdrawal)
    {
        $this->celebrityId = $withdrawal->celebrity_id;
        $this->userId = $withdrawal->user_id;
        $this->amount = (float) $withdrawal->amount;
        $this->fanName = $withdrawal->user->name;
        $this->message = "{$this->fanName} requested a \${$this->amount} withdrawal";
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
            'type' => 'withdrawal_requested',
            'message' => $this->message,
            'link' => url('/admin/withdrawals'),
        ];
    }
}
