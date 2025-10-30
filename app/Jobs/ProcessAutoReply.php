<?php

namespace App\Jobs;

use App\Models\Message;
use App\Services\AutoReplyService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessAutoReply implements ShouldQueue
{
    use Queueable;
    // use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Message $message)
    {
    }

    public function handle(AutoReplyService $autoReplyService): void
    {
        $reply = $autoReplyService->generateReply($this->message->content);

        if ($reply) {
            Message::create([
                'chat_id' => $this->message->chat_id,
                'sender_type' => 'system',
                'senderable_type' => null,
                'senderable_id' => null,
                'content' => $reply,
                'is_auto_reply' => true
            ]);

            // Update chat last activity
            $this->message->chat->update([
                'last_activity_at' => now()
            ]);
        }
    }
}
