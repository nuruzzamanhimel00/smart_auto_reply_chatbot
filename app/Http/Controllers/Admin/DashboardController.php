<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Services\UserService;
use App\Services\DashboardService;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected $userService;
    protected $RoleService;
    protected $dashboardService;



   public function index()
    {
        setPageMeta('Dashboard ');
        $auth_user = auth()->user();

        $chats = Chat::with(['guest', 'agent', 'latestMessage'])
            ->orderBy('last_activity_at', 'desc')
            ->when($auth_user->type == 'agent', function($query) use($auth_user){
                $query->where('agent_id', $auth_user->id);
            })
            ->paginate(20);

        // dd($chats);

        $agents = User::where('type', 'agent')->where('status', STATUS_ACTIVE)->get();

        $stats = [
            'total_chats' => Chat::query()
             ->when($auth_user->type == 'agent', function($query) use($auth_user){
                $query->where('agent_id', $auth_user->id);
            })
            ->count(),
            'open_chats' => Chat::where('status', 'open')
              ->when($auth_user->type == 'agent', function($query) use($auth_user){
                $query->where('agent_id', $auth_user->id);
            })
            ->count(),
            'assigned_chats' => Chat::whereNotNull('agent_id')
              ->when($auth_user->type == 'agent', function($query) use($auth_user){
                $query->where('agent_id', $auth_user->id);
            })
            ->count(),
            'active_agents' => User::where('type', 'agent')->where('status', STATUS_ACTIVE)
              ->when($auth_user->type == 'agent', function($query) use($auth_user){
                $query->where('id', $auth_user->id);
            })
            ->count(),
        ];

        return view('admin.dashboard', compact('chats', 'agents', 'stats'));
    }

}
