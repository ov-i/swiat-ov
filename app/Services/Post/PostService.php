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
use App\Traits\IntersectsArray;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
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

    public function editPost(Post &$post, array $updateData): bool
    {
        $request =  UpdatePostRequest::from($updateData);
        $requestTitle = $request->title;

        if ($this->postRepository->postExists($requestTitle) && $requestTitle !== $post->getTitle()) {
            throw new PostAlreadyExistsException("Post [{$requestTitle}] already exists.");
        }

        if ($requestTitle !== $post->getTitle()) {
            $newSlug = Str::slug($requestTitle);

            return $this->postRepository->editPost($post, [...$request->toArray(), 'slug' => $newSlug]);
        }

        $this->syncTags($post, $request);
        $this->syncAttachments($post, $request);

        $editedPost = $this->postRepository->editPost($post, $request->toArray());
        $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::updated());

        return $editedPost;
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

    /**
     * Deletes post and saves history.
     */
    public function deletePost(Post &$post, bool $forceDelete = false): bool
    {
        $postExists = $this->postRepository->findBy('title', $post->getTitle());
        if (!filled($postExists)) {
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
     * @param Post $post Referenced post
     * @param array|CreatePostRequest Referenced data object
     */
    private function syncTags(Post &$post, CreatePostRequest|UpdatePostRequest &$data): void
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
    private function syncAttachments(Post &$post, CreatePostRequest|UpdatePostRequest &$data): void
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
