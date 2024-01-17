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

    public bool $userLockModalOpened = false;

    public const REASON_MIN_CHARS = 50;

    public LockForm $lockForm;

    protected UserLockService $userLockService;

    public function boot(
        UserLockService $userLockService
    ): void {
        $this->authorize('viewAdmin', $this->user);

        $this->userLockService = $userLockService;
    }

    public function openLockingModal(): void
    {
        if (true === $this->userLockModalOpened) {
            $this->userLockModalOpened = false;
            return;
        }

        $this->userLockModalOpened = true;
    }

    public function closeLockingModal(): void
    {
        $this->userLockModalOpened = false;
    }

    public function lockUser(): void
    {
        $this->lockForm->validate();

        /** @var User $user */
        $user = $this->user;

        $reasonLength = strlen($this->lockForm->reason);

        if (self::REASON_MIN_CHARS > $reasonLength) {
            session()->flash('notEnoughCars', __('Please provide min. 50 chars'));
            return;
        }

        $lockDuration = BanDurationEnum::from($this->lockForm->lockDuration);
        $reason = $this->lockForm->reason;

        $this->userLockService->lockUser($user, new LockOption(lockDuration: $lockDuration, reason: $reason));

        session()->flash('userLocked', __("User [{$user->name}] has been locked successfully"));

        $this->closeLockingModal();

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
