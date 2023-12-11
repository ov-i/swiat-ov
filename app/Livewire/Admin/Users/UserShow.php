<?php

namespace App\Livewire\Admin\Users;

use App\Events\User\UserProfileImageDeleted;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
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
            abort(Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    public function deleteImage(): void
    {
        /** @var User $user */
        $user = $this->user;

        $user->deleteProfilePhoto();

        session()->flash('User image has been deleted');

        event(new UserProfileImageDeleted($user));
    }

    #[Layout('layouts.admin-view')]
    public function render(): View
    {
        return view('livewire.admin.users.user-show');
    }
}
