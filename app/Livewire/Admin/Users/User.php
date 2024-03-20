<?php

namespace App\Livewire\Admin\Users;

use App\Livewire\Contracts\Filterable;
use App\Livewire\SearchableComponent;
use App\Repositories\Eloquent\Users\UserRepository;
use App\Services\UserActivity\UserActivityService;
use App\Services\Users\UserService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class User extends SearchableComponent implements Filterable
{
    use WithPagination;

    protected $repository = UserRepository::class;

    private UserService $userService;

    private UserActivityService $userActivityService;

    public function boot(
        UserService $userService,
        UserActivityService $userActivityService,
    ): void {
        $this->userService = $userService;
        $this->userActivityService = $userActivityService;
    }

    #[Layout('layouts.admin')]
    public function render(): View
    {
        $users = $this->search();
        return view('livewire.admin.users.user', [
            'users' => $users,
            'activityService' => $this->userActivityService,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function filters(): array
    {
        return [];
    }

    public function delete(int $userId): void
    {
        $user = $this->repository->find($userId);

        $this->authorize('delete', $user);

        if (blank($user) || ($user->isAdmin() || $user->isModerator())) {
            return;
        }

        $this->userService->deleteUser($user);

        session()->flash('user-deleted', "User with id [{$userId}] has been deleted.");
    }
}
