<?php

declare(strict_types=1);

namespace App\Services\Post;

use App\Data\CreatePostRequest;
use App\Data\UpdatePostData;
use App\Enums\Post\PostHistoryActionEnum;
use App\Enums\Post\PostStatusEnum;
use App\Events\PostPublished;
use App\Exceptions\PostAlreadyExistsException;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\AttachmentRepository;
use App\Repositories\Eloquent\Posts\PostHistoryRepository;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Traits\IntersectsArray;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Spatie\LaravelData\Data;

class PostService
{
    use IntersectsArray;

    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly AttachmentRepository $attachmentRepository,
        private readonly AttachmentService $attachmentService,
        private readonly PostHistoryRepository $postHistoryRepository,
    ) {
    }

    /**
     * @throws PostAlreadyExistsException If post with a title already exists.
     */
    public function createPost(CreatePostRequest $request): Post
    {
        throw_if($this->postRepository->postExists($request->title), PostAlreadyExistsException::class);

        $post = $this->postRepository->createPost([
            ...$request->toArray(),
            'user_id' => auth()->id()
        ]);
        $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::created());

        $this->syncTags($post, $request);
        $this->syncAttachments($post, $request);

        return $post;
    }

    /**
     * @throws PostAlreadyExistsException if post with a title or slug already exists
     */
    public function editPost(Post &$post, UpdatePostData $updateData): bool
    {
        $requestTitle = $updateData->title;

        if ($this->postRepository->postExists($requestTitle) && $post->getTitle() !== $requestTitle) {
            throw new PostAlreadyExistsException("Post [{$requestTitle}] already exists.");
        }

        if ($post->getTitle() !== $requestTitle) {
            $newSlug = Str::slug($requestTitle);

            return $this->postRepository->editPost($post, [...$updateData->toArray(), 'slug' => $newSlug]);
        }

        $this->syncTags($post, $updateData);
        $this->syncAttachments($post, $updateData);

        $editedPost = $this->postRepository->editPost($post, $updateData->toArray());
        $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::updated());

        return $editedPost;
    }

    public function publishPost(Post &$post): void
    {
        if($post->isPublished()) {
            return;
        }

        if($post->isEvent() && $this->postRepository->isAnyEventPublished()) {
            return;
        } // only one event per time.

        event(new PostPublished($post));
    }

    public function closePost(Post &$post): void
    {
        if ($post->isClosed()) {
            return;
        }

        $this->postRepository->setStatus($post, PostStatusEnum::closed());
        $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::closed());
    }

    /**
     * Deletes post and saves history.
     */
    public function deletePost(Post &$post, bool $forceDelete = false): bool
    {
        $post = $this->postRepository->findBy('title', $post->getTitle());
        if (!filled($post)) {
            return false;
        }

        $deleted = $this->postRepository->deletePost($post, $forceDelete);
        $historyAction = $forceDelete ?
            PostHistoryActionEnum::forceDeleted() :
            PostHistoryActionEnum::deleted();

        $this->postHistoryRepository->addHistory($post, $historyAction);

        return $deleted;
    }

    /**
     * Checks if tags property exist in request. If so, syncs'em with post
     *
     * @param \App\Models\Posts\Post $post
     * @param \App\Data\CreatePostRequest|\App\Data\UpdatePostData $data
     *
     * @return void
     */
    private function syncTags(Post &$post, Data &$data)
    {
        $tags = $data->tags;

        if (blank($tags)) {
            return;
        }

        $post->tags()->sync($tags);
    }

    /**
     * Checks if attachments are available in request. If so, syncs'em without detaching with post.
     *
     * @param \App\Models\Posts\Post $post
     * @param \App\Data\CreatePostRequest|\App\Data\UpdatePostData $data
     *
     * @return void
     */
    private function syncAttachments(Post &$post, Data &$data)
    {
        /** @var UploadedFile[]|null $attachments */
        $attachments = $data->attachments;
        if (blank($attachments)) {
            return;
        }

        foreach ($attachments as $attachment) {
            $file = $this->attachmentService->setFile($attachment);
            $existingAttachment = $this->attachmentRepository->findAttachmentViaChecksum($file->getChecksum());
            if (blank($existingAttachment)) {
                return;
            }

            $post->attachments()->syncWithoutDetaching($existingAttachment->getKey());
        }
    }
}
