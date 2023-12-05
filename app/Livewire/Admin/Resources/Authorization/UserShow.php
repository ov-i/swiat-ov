<?php

namespace App\Livewire\Admin\Resources\Authorization;

use App\Enums\Auth\BanDurationEnum;
use App\Exceptions\UserNotFoundException;
use App\Lib\Auth\LockOption;
use App\Livewire\Forms\LockForm;
use App\Models\User;
use App\Services\Auth\UserLockService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;

class UserShow extends Component
{
    #[Locked, Url]
    public int $userId = 0;

    public const REASON_MIN_CHARS = 50;
    
    public bool $userLockModalOpened = false;
    
    public LockForm $lockForm;

    private UserLockService $userLockService;

    public function mount(): void
    {
        $this->userId = request('user');
    }

    #[Computed(persist: true)]
    public function user(): User
    {
        /** @var ?User $user */
        $user = User::query()->find($this->userId);

        if (null === $user) {
            throw new UserNotFoundException("User with id o {$this->userId} was not found");
        }

        return $user;
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
        $user = $this->user();

        $reasonLength = strlen($this->lockForm->reason);

        if (self::REASON_MIN_CHARS > $reasonLength) {
            session()->flash('notEnoughCars', __('Please provide min. 50 chars'));
            return;
        }

        $lockDuration = BanDurationEnum::from($this->lockForm->lockDuration);
        $reason = $this->lockForm->reason;

        $this->userLockService = app(UserLockService::class);
        $this->userLockService->lockUser($user, new LockOption(lockDuration: $lockDuration, reason: $reason));

        session()->flash('userLocked', __("User [{$user->name}] has been locked successfully"));

        $this->closeLockingModal();

        unset($this->user);
    }

    public function unlockUser(): void
    {
        /** @var User $user */
        $user = $this->user();

        $this->userLockService = app(UserLockService::class);

        $this->userLockService->unlockUser($user);

        session()->flash('userUnlocked', __("User {$user->name} has been successully unlocked"));

        unset($this->user);
    }

    #[Layout('layouts.admin')]
    public function render(): View
    {
        return view('livewire.admin.resources.authorization.user-show');
    }
}
