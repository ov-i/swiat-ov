<?php

namespace App\Livewire\Admin\Users;

use App\Enums\ItemsPerPageEnum;
use App\Models\User as UserModel;
use App\Services\Users\UserService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UserIndex extends Component
{
    private UserService $userService;

    public function boot(
        UserService $userService,
    ): void {
        $this->userService = $userService;
    }

    public function mount(): void
    {
        $this->authorize('viewAny', auth()->user());
    }

    #[Layout('layouts.admin')]
    public function render(): View
    {
        return view('livewire.admin.users.user', [
            'users' => UserModel::paginate(ItemsPerPageEnum::DEFAULT),
        ]);
    }

    public function delete(UserModel $user): void
    {
        $this->authorize('delete', $user);

        if (blank($user) || ($user->isAdmin() || $user->isModerator())) {
            return;
        }

        $this->userService->deleteUser($user);

    }
}
