<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $users = User::with(['blockUsers'])->get();
        return view('admin.users.index', [
            'request' => $request,
            'user' => $request->user(),
            'users' => $users
        ]);
    }
}
