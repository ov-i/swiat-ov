<?php

namespace App\Livewire\Admin\Users;

use App\Livewire\Contracts\Filterable;
use App\Livewire\SearchableResource;
use App\Repositories\Eloquent\Users\UserRepository;
use App\Services\Users\UserService;

class User extends SearchableResource implements Filterable
{
    protected $repository = UserRepository::class;

    public bool $withTrashed = true;

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
}
