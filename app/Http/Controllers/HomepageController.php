<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index(Request $request)
    {
        setPageMeta('Welcome');
        $ip_address = $request->ip();

        $chats = Chat::query()
        ->whereHas('guest',function($query) use ($ip_address){
            $query->where('ip_address', $ip_address);
        })
        ->with(['agent'])
        ->latest()->paginate(10);

        return view('welcome', compact('chats'));
    }
}
