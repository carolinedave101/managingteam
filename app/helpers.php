<?php

use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Support\Facades\Log;

if (! function_exists('safe_event')) {
    function safe_event(...$args)
    {
        try {
            event(...$args);
        } catch (BroadcastException $e) {
            Log::warning('Broadcast failed: '.$e->getMessage());
        }
    }
}
