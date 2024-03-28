<?php

namespace App\Livewire\Admin\Users;

use App\Livewire\Contracts\Filterable;
use App\Livewire\SearchableResource;
use App\Repositories\Eloquent\Users\UserRepository;
use App\Services\UserActivity\UserActivityService;
use App\Services\Users\UserService;

class User extends SearchableResource implements Filterable
{
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

    protected function getView(): string
    {
        return 'users.user';
    }

    /**
     * @inheritDoc
     */
    protected function getViewAttributes(): array
    {
        return [
            ...parent::getViewAttributes(),
            'activityService' => $this->userActivityService,
        ];
    }
}
