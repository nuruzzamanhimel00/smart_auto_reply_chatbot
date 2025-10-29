<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Services\AgentService;
use App\Services\AutoReplyService;
use App\Http\Requests\AutoReplyRulesRequest;
use App\Services\RestaurantService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\DataTables\AutoReplyRulesDataTable;
use App\Services\AdministrationService;
use App\Services\AutoReplyRulesService;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;



class AutoReplyRulesController extends Controller
{
    protected $autoReplyRulesService;


    public function __construct(AutoReplyRulesService $autoReplyRulesService)
    {
        $this->autoReplyRulesService = $autoReplyRulesService;

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



    public function index(AutoReplyRulesDataTable $dataTable)
    {
        setPageMeta('Auto Reply Rule  List');

        setCreateRoute(route('auto-reply-rules.create'),'route');

        return $dataTable->render('admin.auto-reply-rules.index');
    }

    /**
     * create
     *
     * @return void
     */
    public function create(): \Illuminate\View\View
    {
        checkPermission('Add Auto Reply Rules');

        setCreateRoute(null);
        setPageMeta(__('Add Auto Reply Rules'));
        return view('admin.auto-reply-rules.create');
    }

    public function store(AutoReplyRulesRequest $request) : \Illuminate\Http\RedirectResponse
    {
        checkPermission('Add Auto Reply Rules');
        $data = $request->validated();

        try {
            $this->autoReplyRulesService->createOrUpdate($request);

            sendFlash('Successfully created', 'success');
            return redirect()->route('auto-reply-rules.index');
        } catch (\Exception $e) {
            sendFlash($e->getMessage(), 'error');
            return back();
        }
    }

    public function edit($id) : \Illuminate\View\View
    {
        checkPermission('Edit Auto Reply Rules');
        setPageMeta('Edit Auto Reply Rules');
        setCreateRoute(null);

        $data = $this->autoReplyRulesService->get($id);

        return view('admin.auto-reply-rules.edit', compact('data'));
    }



    public function update(AutoReplyRulesRequest $request, $id): RedirectResponse
    {
        checkPermission('Edit Auto Reply Rules');
        $data = $request->validated();

        try {
            $this->autoReplyRulesService->createOrUpdate($request, $id);

            sendFlash('Successfully Updated');
            return redirect()->route('auto-reply-rules.index');
        } catch (\Exception $e) {
            sendFlash($e->getMessage(), 'error');
            return back();
        }
    }

    public function destroy($id) : RedirectResponse
    {
        checkPermission('Delete Auto Reply Rules');
        try {
            $this->autoReplyRulesService->delete($id);
            sendFlash(__('Successfully Deleted'));
            return back();
        } catch (\Exception $e) {
            sendFlash(__($e->getMessage()), 'error');
            return back();
        }
    }


    public function statusUpdate(Request $request, $id){
        $user = User::find($id);
        $user->status = $request->status;
        if($user->save()){
            return response()->json(true);
        }else{

            return response()->json(true);
        }
    }



}
