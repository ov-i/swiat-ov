<?php

namespace App\Livewire\Admin\Posts;

use App\Livewire\Resource;
use App\Repositories\Eloquent\Posts\TagRepository;

class Tag extends Resource
{
    protected $repository = TagRepository::class;

    protected function getView(): string
    {
        return 'posts.tag';
    }
}
