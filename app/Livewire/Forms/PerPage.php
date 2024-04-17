<?php

namespace App\Livewire\Forms;

use App\Enums\ItemsPerPage;
use Livewire\Attributes\Url;
use Livewire\Form;

class PerPage extends Form
{
    #[Url]
    public ItemsPerPage $slice = ItemsPerPage::Default;
}
