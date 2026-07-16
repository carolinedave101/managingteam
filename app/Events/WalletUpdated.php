<?php

namespace App\Events;

use App\Models\Wallet;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class WalletUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public int $celebrityId;

    public int $userId;

    public float $balance;

    public string $type;

    public float $amount;

    public function __construct(Wallet $wallet, string $type = 'credit', float $amount = 0)
    {
        $this->celebrityId = $wallet->celebrity_id;
        $this->userId = $wallet->user_id;
        $this->balance = $wallet->balance;
        $this->type = $type;
        $this->amount = $amount;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("celebrity.{$this->celebrityId}.fan.{$this->userId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'wallet.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'balance' => $this->balance,
            'type' => $this->type,
            'amount' => $this->amount,
        ];
    }
}
