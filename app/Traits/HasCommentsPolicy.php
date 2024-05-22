<?php

namespace App\Traits;

trait HasCommentsPolicy
{
    public function isCommentable(): bool
    {
        return
            $this->isPublished()
            && !$this->isArchived()
            && !$this->isDelayed()
            && !$this->isClosed()
            && !$this->isEvent();
    }
}
