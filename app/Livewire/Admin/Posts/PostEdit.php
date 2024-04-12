<?php

namespace App\Livewire\Admin\Posts;

use App\Data\PostData;
use App\Livewire\Forms\PostForm;
use App\Models\Posts\Post;
use App\Traits\IntersectsArray;
use App\Repositories\Eloquent\Posts\CategoryRepository;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Repositories\Eloquent\Posts\TagRepository;
use App\Services\Post\PostService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PostEdit extends Component
{
    use IntersectsArray;

    public Post $post;

    public PostForm $postForm;

    public bool $edited = false;

    public bool $attachmentsModal = false;

    private PostRepository $postRepository;

    private PostService $postService;

    private CategoryRepository $categoryRepository;

    private TagRepository $tagRepository;

    public function mount(): void
    {
        $this->postForm->fill([
            'title' => $this->post->getTitle(),
            'excerpt' => $this->post->getExcerpt(),
            'content' => $this->post->getContent(),
            'category_id' => $this->post->category()->getParentKey(),
            'should_be_published_at' => $this->post->getPublishableDate(),
        ]);

        $this->postForm->setPost($this->post);
        $this->postForm->type = $this->post->getType();

        abort_if(blank($this->post) || $this->post->isClosed(), Response::HTTP_NOT_FOUND);

    }

    public function boot(
        PostRepository $postRepository,
        PostService $postService,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
    ): void {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->postService = $postService;
    }

    #[Layout('layouts.admin')]
    public function render(): View
    {
        $categories = $this->categoryRepository->all(paginate: false);
        $tags = $this->tagRepository->all(paginate: false);

        return view('livewire.admin.posts.post-edit', ['categories' => $categories, 'tags' => $tags]);
    }

    public function edit(): void
    {
        $post = $this->post;

        $this->authorize('can-edit-post', $post);

        $validated = $this->postForm->validate();

        if ($this->postRepository->postExists($validated['title'] && $this->isTitleChanged())) {
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
