<?php

namespace App\Livewire\Admin\Users;

use App\Repositories\Eloquent\Users\UserRepository;
use App\Services\UserActivity\UserActivityService;
use App\Services\Users\UserService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;

    private UserService $userService;

    private UserRepository $userRepository;

    private UserActivityService $userActivityService;

    public function boot(
        UserService $userService,
        UserRepository $userRepository,
        UserActivityService $userActivityService,
    ): void {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->userActivityService = $userActivityService;
    }

    #[Layout('layouts.admin')]
    public function render(): View
    {
        $users = $this->userRepository->all();

        return view('livewire.admin.users.user', [
            'users' => $users,
            'activityService' => $this->userActivityService,
        ]);
    }

    public function delete(int $userId): void
    {
        $user = $this->userRepository->find($userId);

        $this->authorize('delete', $user);

        if (blank($user) || ($user->isAdmin() || $user->isModerator())) {
            return;
        }

        $this->userService->deleteUser($user);

        session()->flash('user-deleted', "User with id [{$userId}] has been deleted.");
    }
}
