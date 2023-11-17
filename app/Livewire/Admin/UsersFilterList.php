<?php

namespace App\Livewire\Admin;

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\RoleNamesEnum;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use App\Repositories\Eloquent\Auth\AuthRepository;
use App\Services\Auth\UserLockService;
use App\Services\Users\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\WithPagination;

class UsersFilterList extends Component
{
    use WithPagination;

    private UserLockService $userLockService;

    private AuthRepository $authRepository;

    public int $userId;

    public string $duration;

    public function mount(UserLockService $userLockService, AuthRepository $authRepository): void
    {
        $this->userLockService = $userLockService;
        $this->authRepository = $authRepository;
    }

    public function render(
        UserService $userService,
    ): View {
        return view('livewire.admin.users-filter-list', [
            'users' => $userService->getUsersWithRoles(),
            'availableRoles' => RoleNamesEnum::toValues(),
        ]);
    }

    public function lockUser(): RedirectResponse
    {
        /** @var ?User $user */
        $user = $this->authRepository->getModel()->find($this->userId);
        if (null === $user) {
            throw new UserNotFoundException("User with id: {$this->userId} was not found.");
        }
        $banDuration = BanDurationEnum::from($this->duration);

        $this->userLockService->lockUser($user, $banDuration);

        /** @phpstan-ignore-next-line */
        return redirect()->with('blocked', __('auth.blocked', [
            'user' => $user->name,
            'duration' => $this->authRepository->blockedUntil($user),
        ]));
    }
}
