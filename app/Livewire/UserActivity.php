<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\UserActivity\UserActivityService;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class UserActivity extends Component
{
    #[Modelable]
    public User $user;

    private UserActivityService $userActivityService;

    public function mount(
        UserActivityService $userActivityService,
    ): void {
        $this->userActivityService = $userActivityService;
    }

    public function render()
    {
        $active = $this->userActivityService->getStatus($this->user);

        return view('livewire.user-activity', ['active' => $active]);
    }
}
