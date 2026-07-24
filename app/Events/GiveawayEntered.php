<?php

namespace App\Events;

use App\Models\GiveawayEntry;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;

class GiveawayEntered
{
    use Dispatchable, InteractsWithSockets;

    public GiveawayEntry $entry;

    public function __construct(GiveawayEntry $entry)
    {
        $this->entry = $entry;
    }
}
