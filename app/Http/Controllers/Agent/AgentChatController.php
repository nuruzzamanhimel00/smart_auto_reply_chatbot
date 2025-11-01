<?php

namespace App\Http\Controllers\Agent;

use App\Models\Chat;
use App\Models\User;
use App\Models\Order;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\AgentAssigned;
use App\Services\RoleService;
use App\Services\AgentService;
use App\Events\AgentUnassigned;
use App\Services\AutoReplyService;
use App\Services\RestaurantService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\DataTables\AgentChatDataTable;
use App\Services\AdministrationService;
use App\Services\AutoReplyRulesService;
use App\Services\ChatManagementService;
use App\DataTables\AutoReplyRulesDataTable;
use App\DataTables\ChatManagementDataTable;
use App\Http\Requests\AutoReplyRulesRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;



class AgentChatController extends Controller
{
    protected $chatManagementService;


    public function __construct(ChatManagementService $chatManagementService)
    {
        $this->chatManagementService = $chatManagementService;

    }

    /**
     * Define middleware for the controller.
     *
     * @return array
     */
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('List Auto Reply Rules'), only: ['index']),
            new Middleware(PermissionMiddleware::using('Add Auto Reply Rules'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using('Edit Auto Reply Rules'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using('Delete Auto Reply Rules'), only: ['destroy']),

        ];
    }



    public function index(AgentChatDataTable $dataTable)
    {
        setPageMeta('Chat List');

         setCreateRoute(null);

        return $dataTable->render('agent.chat.index');
    }

     public function chatBox($uuid)
    {
        setPageMeta('Chat Box');

        $chat = Chat::where('uuid', $uuid)
        ->with(['guest'])
        ->firstOrFail();

        return view('agent.chat.show', ['chat' => $chat]);

    }

     /**
     * Send message
     */
    public function sendMessage(Request $request)
    {
        // dd('dd');
        $request->validate([
            'message' => 'required|string|max:1000',
            'agent_id' => 'required|exists:users,id',
            'chat_id' => 'required|exists:chats,id',
        ]);

        $agent = User::where('id', $request->agent_id)
        ->firstOrFail();
        $chat = Chat::where('id', $request->chat_id)
        ->firstOrFail();

        // Create message
        $message = Message::create([
            'chat_id' => $request->chat_id,
            'sender_type' => 'agent',
            'senderable_type' => get_class($agent),
            'senderable_id' => $agent->id,
            'content' => $request->message,
            'is_auto_reply' => false
        ]);

        // Update chat activity
        $chat->update(['last_activity_at' => now()]);
        $agent->update(['last_activity_at' => now()]);


        return response()->json([
            'success' => true,
            'message' => $message->load(['senderable'])
        ]);
    }


}
