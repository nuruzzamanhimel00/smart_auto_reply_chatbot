<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Guest;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\MessageReceived;

class ChatController extends Controller
{
    // public function index()
    // {
    //     return view('chat');
    // }

    public function createChat(Request $request)
    {
        $guest = $this->getOrCreateGuest($request);
        $chat = $this->getOrCreateChat($guest);
        return redirect()->route('guest.chatBox', ['uuid' => $chat->uuid]);
        // $messages = $chat->messages()->orderBy('created_at', 'asc')->get();

    }

    public function chatBox($uuid)
    {
        // $guest = $this->getOrCreateGuest($request);
        // $chat = Chat::where('uuid', $uuid)->firstOrFail();
        $chat = Chat::where('uuid', $uuid)
        ->with(['guest'])
        ->firstOrFail();

        return view('chat', ['chat' => $chat]);

    }

    /**
     * Send message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'guest_id' => 'required|exists:guests,id',
        ]);

        $guest = Guest::where('id', $request->guest_id)->firstOrFail();
        $chat = $guest->activeChat;

        if (!$chat) {
            $chat = $this->getOrCreateChat($guest);
        }

        // Create message
        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_type' => 'guest',
            'senderable_type' => get_class($guest),
            'senderable_id' => $guest->id,
            'content' => $request->message,
            'is_auto_reply' => false
        ]);

        // Update chat activity
        $chat->update(['last_activity_at' => now()]);
        $guest->update(['last_seen_at' => now()]);

        // Trigger event
        event(new MessageReceived($message));

        return response()->json([
            'success' => true,
            'message' => $message->load(['senderable'])
        ]);
    }

    /**
     * Get new messages
     */
    public function getMessages($chat_id)
    {

        $messages = Message::where('chat_id', $chat_id)
            ->orderBy('created_at', 'asc')
            ->with(['senderable'])
            ->get();
        return response()->json([
            'messages' => $messages
        ]);
    }

    /**
     * Get or create guest
     */
    protected function getOrCreateGuest(Request $request)
    {
        $ip_address = $request->ip();

        $guest = Guest::where('ip_address', $ip_address)->first();

        if ($guest) {
            $guest->update([
                'last_seen_at' => now(),
                'user_agent' => $request->userAgent(),
            ]);
            return $guest;
        }

        return Guest::create([
            'session_id' => Str::uuid()->toString(),
            'name' => 'Guest' . Str::random(6),
            'ip_address' => $ip_address,
            'user_agent' => $request->userAgent(),
            'last_seen_at' => now()
        ]);
    }

    /**
     * Get or create chat
     */
    protected function getOrCreateChat(Guest $guest)
    {
        return Chat::firstOrCreate(
            [
                'guest_id' => $guest->id,
                'status' => 'open'
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'auto_reply_enabled' => true,
                'last_activity_at' => now()
            ]
        );
    }
}
