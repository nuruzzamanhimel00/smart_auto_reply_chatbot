<?php

namespace App\Listeners;

use App\Events\AgentAssigned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DisableAutoReply
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AgentAssigned $event): void
    {
        $event->chat->update([
            'auto_reply_enabled' => false
        ]);
    }
}
