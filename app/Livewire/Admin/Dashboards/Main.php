<?php

namespace App\Livewire\Admin\Dashboards;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Main extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.dashboards.main');
    }
}
