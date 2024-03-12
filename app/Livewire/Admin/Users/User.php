<?php

namespace App\Livewire\Admin\Users;

use App\Repositories\Eloquent\Users\UserRepository;
use App\Services\UserActivity\UserActivityService;
use App\Services\Users\UserService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;

    private UserService $userService;

    private UserRepository $userRepository;

    public function boot(
        UserService $userService,
        UserRepository $userRepository
    ): void {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
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

    #[Layout('layouts.admin')]
    public function render(
        UserActivityService $activityService,
    ) {
        $users = $this->userRepository->all();

        return view('livewire.admin.users.user', [
            'users' => $users,
            'activityService' => $activityService,
        ]);
    }
}
