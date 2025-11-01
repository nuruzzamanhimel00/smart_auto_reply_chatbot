<?php

namespace App\Console\Commands;

use App\Models\Chat;
use Illuminate\Console\Command;


class ReactivateIdleChats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'received:idle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         // Find chats that have been idle for more than 30 minutes
        $idleChats = Chat::whereNotNull('agent_id')
            ->where('last_activity_at', '<', now()->subMinutes(30))
            ->get();

        $count = 0;

        foreach ($idleChats as $chat) {
            $chat->update([
                'auto_reply_enabled' => true,
                'status' => 'open',
                'agent_id' => null
            ]);
            $count++;
        }

        $this->info("Reactivated {$count} idle chats.");

        return Command::SUCCESS;
    }
}
