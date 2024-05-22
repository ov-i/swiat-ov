<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users\Index;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UserIndex extends Component
{
    public Filters $filters;

    #[Layout('layouts.admin')]
    public function render(): View
    {
        return view('livewire.admin.users.index.user-index');
    }
}
