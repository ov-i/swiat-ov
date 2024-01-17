<?php

use App\Data\CreatePostRequest;
use App\Enums\Post\PostStatusEnum;
use App\Enums\Post\PostTypeEnum;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\AttachmentRepository;
use App\Repositories\Eloquent\Posts\PostHistoryRepository;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Services\Post\AttachmentService;
use App\Services\Post\PostService;
use Illuminate\Foundation\Testing\WithFaker;

uses(WithFaker::class);

describe('Post system', function () {
    beforeEach(function () {
        $postRepository = mock(PostRepository::class);
        $attachmentRepository = mock(AttachmentRepository::class);
        $attachmentService = mock(AttachmentService::class);
        $postHistoryRepository = mock(PostHistoryRepository::class);

        $this->postService = new PostService(
            $postRepository,
            $attachmentRepository,
            $attachmentService,
            $postHistoryRepository
        );

        $postRepository->shouldReceive('findPostViaTitle');
        $postRepository->shouldReceive('createPost');
        $postRepository->shouldReceive('setStatus')
            ->andReturnSelf();
        $postHistoryRepository->shouldReceive('addHistory');
    });

    it('should be able to create post with different types', function (PostTypeEnum $type) {
        $category = Category::factory()->create();

        $request = new CreatePostRequest(
            userId: 1,
            categoryId: $category->getKey(),
            title: fake()->unique()->realText(30),
            type: $type->value,
            content: implode(fake()->sentences())
        );

        $post = $this->postService->createPost($request);

        expect($post)->not()->toBeNull();
        expect($post)->toBeInstanceOf(Post::class);
    })->with(PostTypeEnum::cases());

    it('must be able to publish unpublished post', function () {
        /** @var Post $unpublishedPost */
        $unpublishedPost = Post::factory()->unpublished()->make();

        $this->postService->publishPost($unpublishedPost);

        expect($unpublishedPost)->toBeInstanceOf(Post::class);
        expect($unpublishedPost->getStatus())->toBeString(PostStatusEnum::published()->value);
    });
});
