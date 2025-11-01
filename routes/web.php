<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomepageController;

use App\Http\Controllers\Admin\RoleController;

use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\AgentController;

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Agent\AgentChatController;
use App\Http\Controllers\Admin\AdministrationController;
use App\Http\Controllers\Admin\AutoReplyRulesController;
use App\Http\Controllers\Admin\ChatManagementController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::redirect('/', 'login');

//=============================== Guest Routes =============================//
Route::get('/',[HomepageController::class,'index'] )->name('dashboard');

// ============================== Chart Routes ============================ //
// Route::get('/chat',[ChatController::class,'index'] )->name('chat');
Route::prefix('chat')->name('guest.')->group(function () {
    Route::get('/need-help', [ChatController::class, 'createChat'])->name('need-help');
    Route::get('/{uuid}', [ChatController::class, 'chatBox'])->name('chatBox');
    Route::get('/{chat_id}/messages', [ChatController::class, 'getMessages'])->name('messages');
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send');
});

//=============================== Authenticated Routes =============================//

Route::middleware(['auth', 'verified'])->group(function (){
    //================================ Admin Routes ============================//
    Route::get('/dashboard',[DashboardController::class,'index'] )->name('dashboard');
    Route::resource('administrations',AdministrationController::class);
    Route::resource('roles', RoleController::class);


    Route::resource('agents',AgentController::class);
    Route::resource('auto-reply-rules',AutoReplyRulesController::class);

    // Chat Management
    Route::resource('chat-management',ChatManagementController::class);
    Route::get('/chats/{uuid}/assign', [ChatManagementController::class, 'assignAgent'])->name('chats.assign');
    Route::post('/chats/{uuid}/assign', [ChatManagementController::class, 'assignAgentStore'])->name('chats.assign.store');
    Route::get('/chats/{uuid}/unassign', [ChatManagementController::class, 'unassignAgent'])->name('chats.unassign');
    Route::get('/chats/{uuid}/toggle-auto-reply', [ChatManagementController::class, 'toggleAutoReply'])->name('chats.toggle-auto-reply');
    Route::get('/chats/{uuid}/close', [ChatManagementController::class, 'closeChat'])->name('chats.close');
    Route::get('/admin-chats/{uuid}', [ChatManagementController::class, 'chatBox'])->name('admin.chats.chatBox');

    Route::resource('users',UserController::class);
    Route::get('user-orders/{user}', [UserController::class, 'userOrders'])->name('user.orders');
    Route::resource('settings', SettingController::class)->only(['index', 'store']);

    //==================================== Agent Routes ============================//
    Route::prefix('agent/chats')->name('agent.chat.')->group(function () {
        Route::get('/', [AgentChatController::class, 'index'])->name('index');
        Route::post('/send-message', [AgentChatController::class, 'sendMessage'])->name('send');
        Route::get('/{uuid}', [AgentChatController::class, 'chatBox'])->name('chatBox');
        // Route::get('/{chat_id}/messages', [ChatController::class, 'getMessages'])->name('messages');
    });



});




//SYSTEM LOG
Route::get('app-logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

require __DIR__.'/auth.php';
