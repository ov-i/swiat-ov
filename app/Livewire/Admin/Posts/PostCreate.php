<?php

namespace App\Livewire\Admin\Posts;

use App\Data\CreateAttachmentRequest;
use App\Data\CreatePostRequest;
use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use App\Enums\Post\PostTypeEnum;
use App\Livewire\Concerns\PostCreateActionState;
use App\Livewire\Forms\CreatePostForm;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\CategoryRepository;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Repositories\Eloquent\Posts\TagRepository;
use App\Services\Post\AttachmentService;
use App\Services\Post\PostService;
use App\Services\Post\ThumbnailService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class PostCreate extends Component
{
    use WithFileUploads;

    public CreatePostForm $createPostForm;

    public PostCreateActionState $postCreateState;

    private AttachmentService $attachmentService;

    private ThumbnailService $thumbnailService;

    private PostService $postService;

    private PostRepository $postRepository;

    private CategoryRepository $categoryRepository;

    private TagRepository $tagRepository;

    public function mount(): void
    {
        $this->postCreateState = new PostCreateActionState();
    }

    public function boot(
        AttachmentService $attachmentService,
        ThumbnailService $thumbnailService,
        PostService $postService,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
    ) {
        $this->attachmentService = $attachmentService;
        $this->thumbnailService = $thumbnailService;
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    #[Layout('layouts.admin')]
    public function render(): View
    {
        $categories = $this->categoryRepository->all(paginate: false);
        $tags = $this->tagRepository->all(paginate: false);

        return view('livewire.admin.posts.post-create', ['categories' => $categories, 'tags' => $tags]);
    }

    public function save(): void
    {
        $this->authorize('writePost');

        $validated = $this->createPostForm->validate();
        if ($this->postRepository->postExists($validated['title'])) {
            $this->createPostForm->addError('title', __('The title has already been taken.'));

            return;
        }

        $this->saveAttachments();

        $post = $this->savePost();

        $this->saveThumbnailFile($post);

        $this->createPostForm->reset();

        $this->redirectRoute('admin.posts.edit', ['post' => $post], navigate: true);
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
        return $this->isEvent() && $this->postRepository->isAnyEventPublished();
    }

    public function getSaveButtonState(): string
    {
        return Str::ucfirst($this->bindSaveButtonState());
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

        $this->postRepository->updateThumbnailPath($post, path: $thumbnailFile->getPublicUrl());
    }

    /**
     * Saves the optional attachments from request
     *
     * @return void
     */
    private function saveAttachments(): void
    {
        $files = $this->createPostForm->attachments;

        if (filled($files)) {
            foreach($files as $file) {
                $file = $this->attachmentService->setFile($file);

                $request = new CreateAttachmentRequest(attachment: $file->getContent());

                /** @var AttachmentService $file */
                $file->createAttachment($request);
            }
        }
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
