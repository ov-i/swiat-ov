<?php

use App\Data\PostData;
use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Jobs\PublishPost;
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

    it('should be able to create post with different types', function (PostType $type) {
        actingAs(User::factory()->create());

        $category = Category::factory()->create();
        $title = fake()->unique()->realText(30);
        $content = implode(fake()->sentences());

        $request = new PostData(
            category_id: $category->getKey(),
            title: $title,
            type: $type,
            content: $content
        );

        $post = $this->postService->createPost($request);

        expect($post)->not()->toBeNull();
        expect($post)->toBeInstanceOf(Post::class);
    })->with(PostType::cases());

    it('must be able to publish unpublished post', function () {
        /** @var Post $unpublishedPost */
        $unpublishedPost = Post::factory()
            ->for(User::factory())
            ->for(Category::factory())
            ->unpublished()
            ->create();

        $this->postService->publishPost($unpublishedPost);

        expect($unpublishedPost)->toBeInstanceOf(Post::class);
        expect($unpublishedPost->getStatus())->toEqual(PostStatus::Published);
    });
});
