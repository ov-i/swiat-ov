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
use Illuminate\Support\Str;

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
     * @param array<array-key, mixed> $data Referenced data object
     */
    public function createPost(CreatePostRequest $request): Post
    {
        $existingPost = $this->postRepository->findPostViaTitle($request->title);

        if (null !== $existingPost) {
            throw new PostAlreadyExistsException(__("Post {$request->title} already exists"));
        }

        $post = $this->postRepository->createPost([
            ...$request->toArray(),
            'status' => PostStatusEnum::unpublished(),
            'slug' => Str::slug($request->title)
        ]);

        $this->postHistoryRepository->addHistory($post, PostHistoryActionEnum::created());

        $this->syncTags($post, $request);
        $this->syncAttachments($post, $request);

        return $post;
    }

    public function publishPost(Post &$post): void
    {
        abort_if(true === $post->isPublished(), Response::HTTP_BAD_REQUEST);

        if (null === $post->getPublishableDate()) {
            $this->postRepository->setStatus($post, PostStatusEnum::published());
        } else {
            PublishPost::dispatch($post)->delay($post->getPublishableDate());
        }
    }

    public function closePost(Post &$post): void
    {
        abort_if(true === $post->isClosed(), Response::HTTP_BAD_REQUEST);

        if (true === $post->followedBy()->with('users')->count() > 0) {

        }

        $this->postRepository->setStatus($post, PostStatusEnum::closed());
    }

    public function editPost(Post &$post, UpdatePostRequest $updateData): bool
    {
        abort_if($post->isClosed(), Response::HTTP_BAD_REQUEST, __("Post [{$post->getKey()}] is closed and cannot be edited."));

        if (null !== $updateData->type) {
            return $this->postRepository->editPost($post, $updateData->exceptWhen('thumbnail_path', !empty($post->getThumbnailPath))->toArray());
        }

        return $this->postRepository->editPost($post, $updateData->toArray());
    }

    /**
     * Checks if tags property exist in request. If so, syncs'em with post
     *
     * @param Post $post Referenced post
     * @param CreatePostRequest Referenced data object
     */
    private function syncTags(Post &$post, CreatePostRequest &$data): void
    {
        $tags = $data->tags;

        if (null === $tags || empty($tags)) {
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
        $attachments = $data->attachments;
        if (null === $attachments || empty($attachments)) {
            return;
        }

        foreach ($attachments as $attachment) {
            $file = $this->attachmentService->setFile($attachment->attachment);
            $existingAttachment = $this->attachmentRepository->findAttachmentViaChecksum($file->getChecksum());

            if (null !== $existingAttachment) {
                $post->attachments()->syncWithoutDetaching($existingAttachment->getKey());
            } else {
                $fileName = $file->getFileName();
                abort(Response::HTTP_BAD_REQUEST, "Attachment {$fileName} was not found");
            }
        }
    }
}
