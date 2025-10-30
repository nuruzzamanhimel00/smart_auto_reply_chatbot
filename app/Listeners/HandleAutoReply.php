<?php

namespace App\Listeners;

use App\Jobs\ProcessAutoReply;
use App\Events\MessageReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleAutoReply
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
    public function handle(MessageReceived $event): void
    {
        $message = $event->message;
        $chat = $message->chat;

        // Only trigger if guest message and auto-reply enabled
        if ($message->isFromGuest() && $chat->shouldAutoReply()) {
            ProcessAutoReply::dispatch($message);
            // logger()->info('Auto-reply triggered for message ID: ' . $message->id);
        }
    }
}
