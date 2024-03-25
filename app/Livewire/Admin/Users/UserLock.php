<?php

namespace App\Livewire\Admin\Users;

use App\Enums\Auth\BanDurationEnum;
use App\Lib\Auth\LockOption;
use App\Livewire\Forms\LockForm;
use App\Models\User;
use App\Services\Auth\UserLockService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UserLock extends Component
{
    public User $user;

    public bool $lockUserConfirmation = false;

    public LockForm $lockForm;

    protected UserLockService $userLockService;

    public function boot(
        UserLockService $userLockService
    ): void {
        $this->authorize('viewAdmin', $this->user);

        $this->userLockService = $userLockService;
    }

    public function lockUser(): void
    {
        $this->lockForm->validate();

        /** @var User $user */
        $user = $this->user;

        $lockDuration = BanDurationEnum::from($this->lockForm->lockDuration);
        $reason = $this->lockForm->reason;

        $this->userLockService->lockUser($user, new LockOption($lockDuration, $reason));

        $this->lockUserConfirmation = false;

        $this->redirectRoute('admin.users.show', ['user' => $user], true, true);
    }

    public function unlockUser(): void
    {
        /** @var User $user */
        $user = $this->user;

        $this->userLockService->unlockUser($user);

        session()->flash('userUnlocked', __("User {$user->name} has been successully unlocked"));

        $this->redirectRoute('admin.users.show', ['user' => $user], true, true);
    }

    public function render(): View
    {
        return view('livewire.admin.users.user-lock', [
            'lockDurations' => BanDurationEnum::cases()
        ]);
    }
}
