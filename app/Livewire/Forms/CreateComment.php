<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class CreateComment extends Form
{
    public string $content = '';

    public function rules(): array
    {
        return [
            'content' => 'required|max:120'
        ];
    }
}
