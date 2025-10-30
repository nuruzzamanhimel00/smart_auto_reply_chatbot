<?php

namespace App\Listeners;

use App\Events\AgentUnassigned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EnableAutoReply
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
    public function handle(AgentUnassigned $event): void
    {
        $event->chat->update([
            'auto_reply_enabled' => true,
            'agent_id' => null
        ]);
    }
}
