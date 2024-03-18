<?php

use App\Data\CreatePostRequest;
use App\Enums\Post\PostStatusEnum;
use App\Enums\Post\PostTypeEnum;
use App\Models\User;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Services\Post\PostService;
use Illuminate\Foundation\Testing\WithFaker;

use function Pest\Laravel\actingAs;

describe('Post system', function () {
    beforeEach(function () {
        uses(WithFaker::class);

        $this->postService = app(PostService::class);
    });

    it('should be able to create post with different types', function (PostTypeEnum $type) {
        actingAs(User::factory()->create());

        $category = Category::factory()->create();
        $title = fake()->unique()->realText(30);
        $content = implode(fake()->sentences());

        $request = new CreatePostRequest(
            categoryId: $category->getKey(),
            title: $title,
            type: $type->value,
            content: $content
        );

        $post = $this->postService->createPost($request);

        expect($post)->not()->toBeNull();
        expect($post)->toBeInstanceOf(Post::class);
    })->with(PostTypeEnum::cases());

    it('must be able to publish unpublished post', function () {
        /** @var Post $unpublishedPost */
        $unpublishedPost = Post::factory()->unpublished()->create();

        $this->postService->publishPost($unpublishedPost);

        expect($unpublishedPost)->toBeInstanceOf(Post::class);
        expect($unpublishedPost->getStatus())->toBeString(PostStatusEnum::published()->value);
    });
});
