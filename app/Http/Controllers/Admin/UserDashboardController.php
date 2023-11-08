<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\Users\UserRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $users = $this->userRepository->getAllUsers();

        return view('admin.users.index', compact('users'));
    }
}
