<?php

declare(strict_types=1);

namespace App\Services\Post;

use App\Data\CreatePostRequest;
use App\Data\UpdatePostRequest;
use App\Enums\Post\PostHistoryActionEnum;
use App\Enums\Post\PostStatusEnum;
use App\Exceptions\PostAlreadyExistsException;
use App\Jobs\PublishPost;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\AttachmentRepository;
use App\Repositories\Eloquent\Posts\PostHistoryRepository;
use App\Repositories\Eloquent\Posts\PostRepository;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class PostService
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly AttachmentRepository $attachmentRepository,
        private readonly AttachmentService $attachmentService,
        private readonly PostHistoryRepository $postHistoryRepository,
    ) {
    }

    /**
     * @param CreatePostRequest $request Referenced data object
     */
    public function createPost(CreatePostRequest $request): Post
    {
        throw_if($this->postRepository->postExists($request->title), PostAlreadyExistsException::class);

        $post = $this->postRepository->createPost($request->toArray());
        $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::created());

        $this->syncTags($post, $request);
        $this->syncAttachments($post, $request);

        return $post;
    }

    public function publishPost(Post &$post): void
    {
        abort_if(true === $post->isPublished(), Response::HTTP_BAD_REQUEST);

        if($post->isEvent() && $this->postRepository->isAnyEventPublished()) {
            return;
        } // only one event per time.

        if (blank($post->getPublishableDate())) {
            $this->postRepository->setStatus($post, PostStatusEnum::published());
            $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::published());
        } else {
            $this->postRepository->setStatus($post, PostStatusEnum::delayed());
            $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::delayed());

            $delayDiff = Carbon::parse($post->getPublishableDate(), config('app.timezone'))->diffInSeconds();

            PublishPost::dispatch($post)->delay($delayDiff);
        }
    }

    public function closePost(Post &$post): void
    {
        abort_if(true === $post->isClosed(), Response::HTTP_BAD_REQUEST);

        $this->postRepository->setStatus($post, PostStatusEnum::closed());
        $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::closed());
    }

    public function editPost(Post &$post, UpdatePostRequest $updateData): bool
    {
        abort_if($post->isClosed(), Response::HTTP_BAD_REQUEST, __("Post [{$post->getKey()}] is closed and cannot be edited."));

        if (null !== $updateData->type) {
            return $this->postRepository->editPost(
                $post,
                $updateData->exceptWhen('thumbnail_path', !empty($post->getThumbnailPath))->toArray()
            );
        }

        $editedPost = $this->postRepository->editPost($post, $updateData->toArray());
        $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::updated());

        return $editedPost;
    }

    /**
     * Deletes post by using eather soft delete or by using force delete.
     */
    public function deletePost(Post &$post, bool $softDelete = true): bool
    {
        $postExists = $this->postRepository->findBy('title', $post->getSlug());
        if (!filled($postExists)) {
            return false;
        }

        $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::deleted());
        return true === $softDelete ? $post->delete() : $post->forceDelete();
    }

    /**
     * Checks if tags property exist in request. If so, syncs'em with post
     *
     * @param Post $post Referenced post
     * @param array|CreatePostRequest Referenced data object
     */
    private function syncTags(Post &$post, CreatePostRequest &$data): void
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
     * @param Post $post Referenced post
     * @param CreatePostRequest Referenced data object
     */
    private function syncAttachments(Post &$post, CreatePostRequest &$data): void
    {
        /** @var UploadedFile[]|null $attachments */
        $attachments = $data->attachments;
        if (blank($attachments)) {
            return;
        }

        foreach ($attachments as $attachment) {
            $file = $this->attachmentService->setFile($attachment);
            $existingAttachment = $this->attachmentRepository->findAttachmentViaChecksum($file->getChecksum());

            if (!blank($existingAttachment)) {
                $post->attachments()->syncWithoutDetaching($existingAttachment->getKey());
            } else {
                $fileName = $file->getFileName();
                abort(Response::HTTP_BAD_REQUEST, "Attachment {$fileName} was not found");
            }
        }
    }
}
