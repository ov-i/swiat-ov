<?php

namespace App\Livewire\Admin;

use App\Enums\Auth\RoleNamesEnum;
use App\Services\Users\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class UsersFilterList extends Component
{
    use WithPagination;

    private UserService $userService;

    public function render(
        UserService $userService,
    ): View {
        return view('livewire.admin.users-filter-list', [
            'users' => $userService->getUsersWithRoles(),
            'availableRoles' => RoleNamesEnum::toValues(),
        ]);
    }
}
