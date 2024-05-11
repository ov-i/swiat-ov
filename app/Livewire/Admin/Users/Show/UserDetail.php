<?php

namespace App\Livewire\Admin\Users\Show;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class UserDetail extends Component
{
    public User $user;

    public function render()
    {
        return view('livewire.admin.users.show.user-detail');
    }
}
