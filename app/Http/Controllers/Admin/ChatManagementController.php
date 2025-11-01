<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chat;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Events\AgentAssigned;
use App\Services\RoleService;
use App\Services\AgentService;
use App\Events\AgentUnassigned;
use App\Services\AutoReplyService;
use App\Services\RestaurantService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\AdministrationService;
use App\Services\AutoReplyRulesService;
use App\Services\ChatManagementService;
use App\DataTables\AutoReplyRulesDataTable;
use App\DataTables\ChatManagementDataTable;
use App\Http\Requests\AutoReplyRulesRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;



class ChatManagementController extends Controller
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
            new Middleware(PermissionMiddleware::using('List Chat Management'), only: ['index']),
            new Middleware(PermissionMiddleware::using('Assign Chat Management'), only: ['assignAgent']),
           new Middleware(PermissionMiddleware::using('Unassign Chat Management'), only: ['unassignAgent']),
           new Middleware(PermissionMiddleware::using('Toggle Auto Reply Chat Management'), only: ['toggleAutoReply']),
           new Middleware(PermissionMiddleware::using('Close Chat Management'), only: ['closeChat']),
           new Middleware(PermissionMiddleware::using('Show Chat Management'), only: ['chatBox']),

        ];
    }



    public function index(ChatManagementDataTable $dataTable)
    {
        setPageMeta('Chat Management List');

         setCreateRoute(null);

        return $dataTable->render('admin.chat-management.index');
    }

    public function assignAgent($uuid)
    {
        $chat = Chat::where('uuid', $uuid)
        ->firstOrFail();
        $agents = User::where('type',User::TYPE_AGENT)->get();
       return view('admin.chat-management.assign-chat',compact('chat','agents'));
    }


    public function assignAgentStore(Request $request, $uuid)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id'
        ]);
        $chat = Chat::where('uuid', $uuid)
        ->firstOrFail();
        if(!$chat){
            return back()->with('error', 'Chat not found.');
        }

        $chat->update([
            'agent_id' => $request->agent_id
        ]);

        event(new AgentAssigned($chat));

        return redirect()->route('chat-management.index')->with('success', 'Agent assigned successfully.');
    }

    /**
     * Unassign agent from chat
     */
    public function unassignAgent($uuid)
    {
        $chat = Chat::where('uuid', $uuid)
        ->firstOrFail();
        event(new AgentUnassigned($chat));

        return back()->with('success', 'Agent unassigned successfully.');
    }

    public function toggleAutoReply($uuid)
    {
        $chat = Chat::where('uuid', $uuid)
        ->firstOrFail();
        $chat->update([
            'auto_reply_enabled' => !$chat->auto_reply_enabled
        ]);

        return back()->with('success', 'Auto-reply status updated.');
    }

    /**
     * Close chat
     */
    public function closeChat($uuid)
    {
        $chat = Chat::where('uuid', $uuid)
        ->firstOrFail();
        $chat->update(['status' => 'closed']);

        return back()->with('success', 'Chat closed successfully.');
    }


     public function chatBox($uuid)
    {
        setPageMeta('Admin Chat Box');

        $chat = Chat::where('uuid', $uuid)
        ->with(['guest'])
        ->firstOrFail();

        return view('admin.chat-management.show', ['chat' => $chat]);

    }
}
