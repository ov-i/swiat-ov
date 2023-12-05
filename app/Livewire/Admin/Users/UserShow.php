<?php

namespace App\Livewire\Admin\Users;

use App\Exceptions\UserNotFoundException;
use App\Models\User;
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

    public function mount(): void
    {
        $this->userId = request('user');
    }

    #[Computed]
    public function user(): User
    {
        /** @var ?User $user */
        $user = User::query()->find($this->userId);

        if (null === $user) {
            throw new UserNotFoundException("User with id o {$this->userId} was not found");
        }

        return $user;
    }

    #[Layout('layouts.admin')]
    public function render(): View
    {
        return view('livewire.admin.users.user-show');
    }
}
