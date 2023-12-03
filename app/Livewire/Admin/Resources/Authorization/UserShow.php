<?php

namespace App\Livewire\Admin\Resources\Authorization;

use App\Enums\Auth\UserStatusEnum;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;

class UserShow extends Component
{
    #[Locked, Url]
    public int $user_id = 0;

    public function mount()
    {
        $this->user_id = request('user');
    }

    #[Computed(persist: true)]
    public function user()
    {
        $user = User::query()->find($this->user_id);

        return Cache::remember($user->id, 3600, fn() => $user);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.resources.authorization.user-show');
    }
}
