<?php

namespace App\Events;

use App\Models\Withdrawal;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class WithdrawalReviewed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public int $celebrityId;

    public int $userId;

    public float $amount;

    public string $status;

    public string $message;

    public function __construct(Withdrawal $withdrawal)
    {
        $this->celebrityId = $withdrawal->celebrity_id;
        $this->userId = $withdrawal->user_id;
        $this->amount = (float) $withdrawal->amount;
        $this->status = $withdrawal->status;
        $this->message = $withdrawal->status === 'approved'
            ? 'Your withdrawal of $'.number_format($withdrawal->amount, 2).' has been approved and is being processed.'
            : 'Your withdrawal of $'.number_format($withdrawal->amount, 2).' was not approved.';
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("celebrity.{$this->celebrityId}.fan.{$this->userId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'withdrawal.reviewed';
    }

    public function broadcastWith(): array
    {
        return [
            'amount' => $this->amount,
            'status' => $this->status,
            'message' => $this->message,
        ];
    }
}
