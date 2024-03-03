<?php

declare(strict_types=1);

namespace App\Services\Post;

use App\Models\Posts\Post;
use App\Services\UploadedFileService;

class ThumbnailService extends UploadedFileService
{
    private Post $post;

    public function __construct()
    {
        parent::__construct();
    }

    public function getResource(): string
    {
        return 'thumbnail';
    }

    public function setPost(Post &$post): self
    {
        $this->post = $post;

        return $this;
    }

    public function storeOnDisk($disk = 'public'): void
    {
        $this->makeUploadDir();

        $uploadDir = $this->post->getSlug();
        $this->setUploadDir($uploadDir);

        parent::storeOnDisk();
    }

    protected function getRelativeLocation(): string
    {
        $resourceDir = parent::getRelativeLocation();
        $post = $this->post;

        throw_if(!filled($post), new \Exception('Post model wasn\'t set. Please call setPost method firstly.'));

        return sprintf('%s/%s', $resourceDir, $post->getSlug());
    }
}
