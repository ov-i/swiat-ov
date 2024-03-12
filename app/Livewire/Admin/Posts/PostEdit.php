<?php

namespace App\Livewire\Admin\Posts;

use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use App\Traits\IntersectsArray;
use App\Enums\Post\PostTypeEnum;
use App\Livewire\Forms\UpdatePostForm;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\CategoryRepository;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Repositories\Eloquent\Posts\TagRepository;
use App\Services\Post\PostService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;

class PostEdit extends Component
{
    use IntersectsArray;

    #[Locked, Url]
    public string $post;

    public UpdatePostForm $updatePostForm;

    private PostRepository $postRepository;

    private PostService $postService;

    private CategoryRepository $categoryRepository;

    private TagRepository $tagRepository;

    public function mount(): void
    {
        $this->post = request('post');

        $this->updatePostForm->fill($this->getPostWithRelations());
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

        $post = $this->post();
        abort_if(blank($post) || $post->isClosed(), Response::HTTP_NOT_FOUND);
    }

    #[Computed(cache: true, seconds: 60)]
    public function post(): ?Post
    {
        $post = $this->postRepository->findBy('slug', $this->post);

        return $post;
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
        $post = $this->post();

        $this->authorize('canEditPost', $post);

        if ($this->isFormUnTouched()) {
            return;
        }

        if (!$this->isTitleChanged()) {
            $this->updateWithoutTitle($post);

            return;
        }

        $validated = $this->updatePostForm->validate();

        if ($this->postRepository->postExists($validated['title'])) {
            $this->updatePostForm->addError('title', __('The title has already been taken.'));

            return;
        }

        $edited = $this->postService->editPost($post, $validated);

        $edited ? $this->redirectRoute('admin.posts.edit', ['post' => $post]) : null;
    }

    public function publish(): void
    {
    }

    public function isEvent(): bool
    {
        return PostTypeEnum::event()->value === $this->updatePostForm->type;
    }

    public function isFormUnTouched(): bool
    {
        $formData = $this->updatePostForm->all();

        $withRelations = $this->getPostWithRelations();

        return $this->intersectSame($withRelations, $formData);
    }

    #[Computed]
    public function getPostPublicUri(): string
    {
        $host = config('app.url');

        if (!$this->isTitleChanged() && blank($this->updatePostForm->title)) {
            return sprintf('%s/%s', $host, $this->post()->getSlug());
        }

        return sprintf('%s/%s', $host, Str::slug($this->updatePostForm->title));
    }

    #[Computed]
    public function getStatus(): string
    {
        return $this->post()->getStatus();
    }

    #[Computed]
    public function getCategory(): Category
    {
        return $this->post()->category()->first();
    }

    #[Computed]
    public function postContainsTag(string $tag): bool
    {
        $tags = collect($this->post()->tags()->pluck('name')->toArray());
        return $tags->contains($tag);
    }

    #[Computed]
    public function isPublishable(): bool
    {
        return !$this->post()->isEvent() || ($this->post()->isEvent() && !$this->postRepository->isAnyEventPublished());
    }

    #[Computed]
    public function getAcceptedMimeTypes(): array
    {
        return AttachmentAllowedMimeTypesEnum::toValues();
    }

    private function isTitleChanged(): bool
    {
        return $this->updatePostForm->title !== $this->post()->getTitle();
    }

    private function updateWithoutTitle(Post &$post): bool
    {
        $exceptTitle = $this->updatePostForm->except(['title']);
        $request = $this->updatePostForm->validate(attributes: $exceptTitle);

        return $this->postService->editPost($post, $request);
    }

    private function getPostWithRelations(): array
    {
        $post = $this->post();
        return collect($post->toArray())
            ->merge([
                'tags' => $post->tags()->pluck('name')->toArray(),
                'attachments' => $post->attachments()->get()->toArray()
            ])->toArray();
    }
}
