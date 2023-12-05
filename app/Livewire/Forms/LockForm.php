<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class LockForm extends Form
{
    #[Validate('required', 'min:50')]
    public string $reason = '';

    #[Validate('required')]
    public string $lockDuration = '';
}
