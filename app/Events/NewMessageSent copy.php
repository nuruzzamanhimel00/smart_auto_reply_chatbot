<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   public function __construct(public Message $message)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('chat.' . $this->message->chat_id);
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'chat_id' => $this->message->chat_id,
            'sender_type' => $this->message->sender_type,
            'senderable_type' => $this->message->senderable_type,
            'senderable_id' => $this->message->senderable_id,
            'senderable' => $this->message->senderable,
            'content' => $this->message->content,
            'is_auto_reply' => $this->message->is_auto_reply,
            'created_at' => $this->message->created_at->toISOString(),
        ];
    }

}
