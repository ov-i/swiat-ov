<?php

namespace App\Livewire\Admin\Resources\Authorization;

use App\Enums\Auth\BanDurationEnum;
use App\Lib\Auth\LockOption;
use App\Models\User;
use App\Services\Auth\UserLockService;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UserShow extends Component
{
    #[Locked, Url]
    public int $userId = 0;

    #[Validate('required')]
    public string $lockDuration = '';

    #[Validate('required', 'min:50')]
    public string $reason = '';

    public const REASON_MIN_CHARS = 50;

    public bool $userLockModalOpened = false;

    private UserLockService $userLockService;

    public function mount(
    ) {
        $this->userId = request('user');
    }

    #[Computed(persist: true)]
    public function user()
    {
        $user = User::query()->find($this->userId);

        return Cache::remember($user->id, 3600, fn () => $user); // TODO: Need to be changed, since after update shows same result
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

    public function lockUser()
    {
        $this->validate();

        /** @var User $user */
        $user = $this->user();

        $reasonLength = strlen($this->reason);

        if (self::REASON_MIN_CHARS > $reasonLength) {
            session()->flash('notEnoughCars', __('Please provide min. 50 chars'));
            return;
        }

        $lockDuration = BanDurationEnum::from($this->lockDuration);

        $this->userLockService = app(UserLockService::class);
        $this->userLockService->lockUser($user, new LockOption(lockDuration: $lockDuration, reason: $this->reason));

        session()->flash('userLocked', __("User [{$user->name}] has been locked successfully"));

        return $this->redirect(route('admin.users.show', ['user' => $user]), true);
    }

    #[Layout('layouts.admin')]
    public function render(
    ) {
        return view('livewire.admin.resources.authorization.user-show');
    }
}
