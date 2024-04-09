<?php

namespace App\Livewire\Admin\Posts;

use App\Data\CreatePostRequest;
use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use App\Enums\Post\PostTypeEnum;
use App\Livewire\Concerns\PostCreateActionState;
use App\Livewire\Forms\CreatePostForm;
use App\Livewire\Resource;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\CategoryRepository;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Repositories\Eloquent\Posts\TagRepository;
use App\Services\Post\PostService;
use App\Services\Post\ThumbnailService;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class PostCreate extends Resource
{
    public CreatePostForm $createPostForm;

    public PostCreateActionState $postCreateState;

    public bool $attachmentsModal = false;

    /** @var PostRepository $repository */
    protected $repository = PostRepository::class;

    private ThumbnailService $thumbnailService;

    private PostService $postService;

    private CategoryRepository $categoryRepository;

    private TagRepository $tagRepository;

    public function mount(): void
    {
        $this->postCreateState = new PostCreateActionState();
    }

    public function boot(
        ThumbnailService $thumbnailService,
        PostService $postService,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
    ) {
        $this->thumbnailService = $thumbnailService;
        $this->postService = $postService;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    public function save(): void
    {
        $this->authorize('write-post');

        $validated = $this->createPostForm->validate();
        if ($this->repository->postExists($validated['title'])) {
            $this->createPostForm->addError('title', __('The title has already been taken.'));

            return;
        }

        $post = $this->savePost();

        $this->saveThumbnailFile($post);

        $this->createPostForm->reset();

        $this->redirectRoute('admin.posts.edit', ['post' => $post], navigate: true);
    }

    #[On('attachments-sync')]
    public function updateAttachmentsRequest(array $ids): void
    {
        $this->createPostForm->attachments = [...$ids];
    }

    public function resetForm(): void
    {
        if (filled($this->createPostForm->all())) {
            $this->createPostForm->reset();
        }
    }

    #[Computed]
    public function isEvent(): bool
    {
        return $this->createPostForm->type === PostTypeEnum::event()->value;
    }

    #[Computed]
    public function getPostPublicUri(): string
    {
        $host = config('app.url');
        $slugableTitle = Str::slug($this->createPostForm->title);

        return sprintf('%s/%s', $host, $slugableTitle);
    }

    #[Computed]
    public function getPostTypesOptions(): array
    {
        return PostTypeEnum::cases();
    }

    #[Computed]
    public function getAcceptedMimeTypes(): array
    {
        return AttachmentAllowedMimeTypesEnum::toValues();
    }

    public function cantBePublished(): bool
    {
        return $this->isEvent() && $this->repository->isAnyEventPublished();
    }

    public function getSaveButtonState(): string
    {
        return Str::ucfirst($this->bindSaveButtonState());
    }

    protected function getView(): string
    {
        return 'posts.post-create';
    }

    /**
     * @inheritDoc
     */
    protected function getViewAttributes(): array
    {
        return [
            'categories' => $this->categoryRepository->all(paginate: false),
            'tags' => $this->tagRepository->all(paginate: false)
        ];
    }

    private function bindSaveButtonState(): string
    {
        if ($this->cantBePublished()) {
            $this->postCreateState->saveButtonContent = 'create';
        } elseif (!$this->cantBePublished() && filled($this->createPostForm->publishableDateTime)) {
            $this->postCreateState->saveButtonContent = 'delay';
        } else {
            $this->postCreateState->saveButtonContent = 'publish';
        }

        return $this->postCreateState->saveButtonContent;
    }

    private function saveThumbnailFile(Post &$post): void
    {
        $thumbnail = $this->createPostForm->thumbnailPath;

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
        $formContent = $this->createPostForm->validate();

        $request = CreatePostRequest::from($formContent);

        if ($this->cantBePublished()) {
            return $this->postService->createPost($request);
        }

        $post = $this->postService->createPost($request);

        $this->postService->publishPost($post);

        return $post;
    }
}
