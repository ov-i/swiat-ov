<?php

namespace Tests\Feature\Livewire\Admin\Posts\Index;

use App\Livewire\Admin\Posts\Index\Page;
use Livewire\Livewire;
use Tests\TestCase;

class PageTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Page::class)
            ->assertStatus(200);
    }
}
