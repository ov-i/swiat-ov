<?php

namespace App\Livewire\Admin\Posts;

use App\Data\PostData;
use App\Livewire\Concerns\PostCreateActionState;
use App\Livewire\Forms\PostForm;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\Posts\Tag;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Services\Post\PostService;
use App\Services\Post\ThumbnailService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class PostCreate extends Component
{
    public PostForm $postForm;

    public PostCreateActionState $postCreateState;

    public bool $modalOpen = false;

    public bool $attachmentsModal = false;

    /** @var PostRepository $repository */
    private PostRepository $repository;

    private ThumbnailService $thumbnailService;

    private PostService $postService;

    public function mount(): void
    {
        $this->postCreateState = new PostCreateActionState();
    }

    public function boot(
        PostRepository $postRepository,
        ThumbnailService $thumbnailService,
        PostService $postService,
    ) {
        $this->repository = $postRepository;
        $this->thumbnailService = $thumbnailService;
        $this->postService = $postService;
    }

    #[Layout('layouts.admin')]
    public function render(): View
    {
        return view('livewire.admin.posts.post-create', [
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    public function openModal(): void
    {
        $this->modalOpen = true;
    }

    public function closeModal(): void
    {
        $this->modalOpen = false;
    }

    public function save(): void
    {
        $this->authorize('write-post');

        $post = $this->savePost();

        $this->saveThumbnailFile($post);

        $this->postForm->reset();

        $this->redirectRoute('admin.posts.edit', ['post' => $post], navigate: true);
    }

    #[On('attachments-sync')]
    public function updateAttachmentsRequest(array $ids): void
    {
        $this->postForm->attachments = [...$ids];
    }

    public function resetForm(): void
    {
        if (filled($this->postForm->all())) {
            $this->postForm->reset();
        }
    }

    public function cantBePublished(): bool
    {
        return $this->postForm->isEvent() && $this->repository->isAnyEventPublished();
    }

    public function getSaveButtonState(): string
    {
        return Str::ucfirst($this->bindSaveButtonState());
    }

    private function bindSaveButtonState(): string
    {
        if ($this->cantBePublished()) {
            $this->postCreateState->saveButtonContent = 'create';
        } elseif (!$this->cantBePublished() && filled($this->postForm->should_be_published_at)) {
            $this->postCreateState->saveButtonContent = 'delay';
        } else {
            $this->postCreateState->saveButtonContent = 'publish';
        }

        return $this->postCreateState->saveButtonContent;
    }

    private function saveThumbnailFile(Post &$post): void
    {
        $thumbnail = $this->postForm->thumbnail_path;

        if(blank($thumbnail)) {
            return;
        }

        $thumbnailFile = $this->thumbnailService->setFile($thumbnail);

        /** @var ThumbnailService $thumbnailFile */
        $thumbnailFile->setPost($post);

        $thumbnailFile->storeOnDisk();

        $this->repository->updateThumbnailPath($post, path: $thumbnailFile->getPublicUrl());
    }

    private function savePost(): Post
    {
        $formContent = $this->postForm->validate();

        $request = PostData::from($formContent);

        if ($this->cantBePublished()) {
            return $this->postService->createPost($request);
        }

        $post = $this->postService->createPost($request);

        $this->postService->publishPost($post);

        return $post;
    }
}
