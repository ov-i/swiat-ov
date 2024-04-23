<?php

namespace App\Livewire\Admin\Posts\Edit;

use App\Data\PostData;
use App\Livewire\Forms\PostForm;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\Posts\Tag;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Services\Post\PostService;
use Livewire\Component;

class Form extends Component
{
    public Post $post;

    public PostForm $postForm;

    public bool $edited = false;

    public bool $attachmentsModal = false;

    private PostRepository $postRepository;

    private PostService $postService;

    public function mount(): void
    {
        $this->postForm->init($this->post);
    }

    public function boot(
        PostRepository $postRepository,
        PostService $postService,
    ): void {
        $this->authorize('update', $this->post);

        $this->postRepository = $postRepository;
        $this->postService = $postService;
    }

    public function render()
    {
        return view('livewire.admin.posts.edit.form', [
            'categories' => Category::get(),
            'tags' => Tag::get(),
        ]);
    }

    public function edit(): void
    {
        $post = $this->post;

        $this->authorize('can-edit-post', $post);

        $validated = $this->postForm->validate();

        if ($this->postRepository->postExists($validated['title']) && $this->isTitleChanged()) {
            $this->postForm->addError('title', __('The title has already been taken.'));

            return;
        }

        $this->edited = $this->postService->editPost($post, PostData::from($validated));
    }

    private function isTitleChanged(): bool
    {
        return $this->postForm->title !== $this->post->getTitle();
    }
}
