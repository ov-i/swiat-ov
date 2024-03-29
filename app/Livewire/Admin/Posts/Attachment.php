<?php

namespace App\Livewire\Admin\Posts;

use App\Livewire\Resource;
use App\Repositories\Eloquent\Posts\AttachmentRepository;


class Attachment extends Resource
{
    /** @var AttachmentRepository $repository */
    protected $repository = AttachmentRepository::class;

    protected function getView(): string
    {
        return 'posts.attachment';
    }
}
