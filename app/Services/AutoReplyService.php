<?php

namespace App\Services;

use App\Models\AutoReplyRule;
use Illuminate\Support\Str;

class AutoReplyService
{
    /**
     * Generate auto-reply based on message content
     */
    public function generateReply(string $message): ?string
    {
        $message = strtolower($message);

        // Get all active rules ordered by priority
        $rules = AutoReplyRule::where('status', STATUS_ACTIVE)
            ->orderBy('priority', 'desc')
            ->get();

        // Check for keyword matches
        foreach ($rules as $rule) {
            if (Str::contains($message, strtolower($rule->keyword))) {
                return $rule->reply;
            }
        }

        // Default reply if no match found
        return $this->getDefaultReply();
    }

    /**
     * Get default reply when no keyword matches
     */
    protected function getDefaultReply(): string
    {
        //Integrate OpenAI or other AI service here for dynamic replies
        return "Thank you for your message. Our agent will contact you shortly.";
    }

    /**
     * Check if message needs auto-reply
     */
    public function shouldAutoReply($chat): bool
    {
        return $chat->auto_reply_enabled && !$chat->hasAgent();
    }
}
