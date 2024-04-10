<?php

declare(strict_types=1);

namespace App\Services\Post;

use App\Data\PostData;
use App\Enums\Post\PostHistoryActionEnum;
use App\Enums\Post\PostStatusEnum;
use App\Events\PostPublished;
use App\Exceptions\PostAlreadyExistsException;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\AttachmentRepository;
use App\Repositories\Eloquent\Posts\PostHistoryRepository;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Traits\IntersectsArray;
use Illuminate\Support\Str;

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
    public function createPost(PostData $request): Post
    {
        throw_if($this->postRepository->postExists($request->title), PostAlreadyExistsException::class);

        $post = $this->postRepository->createPost([
            ...$request->toArray(),
            'user_id' => auth()->id()
        ]);
        $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::created());

        $this->syncTags($post, $request);
        $this->syncAttachments($post, $request->attachments);

        return $post;
    }

    /**
     * @throws PostAlreadyExistsException if post with a title or slug already exists
     */
    public function editPost(Post &$post, PostData $updateData): bool
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
        $this->syncAttachments($post, $updateData->attachments);

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
     */
    private function syncTags(Post &$post, PostData &$data): void
    {
        $tags = $data->tags;

        if (blank($tags)) {
            return;
        }

        $post->tags()->sync($tags);
    }

    /**
     * Checks if there are any attachments that should be synced, syncs
     * them if so.
     *
     * @param array<array-key, \App\Models\Posts\Attachment|int> $attachments
     */
    private function syncAttachments(Post &$post, ?array $attachments): void
    {
        if (!filled($attachments)) {
            return;
        }

        $post->attachments()->sync($attachments);
    }
}
