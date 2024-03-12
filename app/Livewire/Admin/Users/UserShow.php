<?php

namespace App\Livewire\Admin\Users;

use App\Events\User\UserProfileImageDeleted;
use App\Models\User;
use App\Repositories\Eloquent\Users\UserRepository;
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
    public int $userId;

    private UserRepository $userRepository;

    public function boot(
        UserRepository $userRepository
    ): void {
        $this->userRepository = $userRepository;

        $this->userId = request('user');
    }

    #[Computed]
    public function user(): User
    {
        $user = $this->userRepository->findUserById($this->userId);

        abort_if(blank($user), Response::HTTP_NOT_FOUND);

        return $user;
    }

    public function deleteImage(): void
    {
        $user = $this->user();

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
