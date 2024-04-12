<?php

use App\Data\PostData;
use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\Posts\Category;
use App\Models\User;
use App\Models\Posts\Post;
use App\Repositories\Eloquent\Posts\PostRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

describe('Post Repository', function () {
    beforeEach(function () {
        $this->postRepository = new PostRepository();
    });

    it('should be able to create post from paylaod', function (array $payload) {
        actingAs($user = User::factory()->create());

        Category::factory()->create();

        $payload = PostData::from($payload);

        $post = $this->postRepository->createPost([
            ...$payload->toArray(),
            'user_id' => $user->getKey(),
            'status' => PostStatus::Unpublished
        ]);

        expect($post)->toBeInstanceOf(Post::class);
        expect($post->getTitle())->toBeString();
        expect($post->getStatus())->toBe(PostStatus::Unpublished);
    })->with('create-post-payload');

    it('Should be able to check if post with $title already exists', function (Post $post) {
        $exists = $this->postRepository->postExists($post->getTitle());

        expect($exists)->toBeTrue();
    })->with('unpublished-post');

    it('Should be able to select post via it \'s title', function (Post $post) {
        $findPost = $this->postRepository->findPostViaTitle($post->getTitle());

        expect($findPost)->toBeInstanceOf(Post::class);
        expect($findPost->getTitle())->toEqual($post->getTitle());
    })->with('unpublished-post');

    it('should NOT be able to set status with identical post status', function (Post $post) {
        assert($post->getStatus() === PostStatus::Unpublished);

        $this->expectException(\LogicException::class);

        $status = $this->postRepository->setStatus($post, PostStatus::Unpublished);
        expect($status)->toThrow(\LogicException::class);
    })->with('unpublished-post');

    it('should be able to set [published] status', function (Post $post) {
        assert($post->getStatus() === PostStatus::Unpublished);

        $this->postRepository->setStatus($post, PostStatus::Published);

        expect($post->getStatus())->toBe(PostStatus::Published);
        expect($post->getPublishedAt())->toBeInstanceOf(DateTimeInterface::class);
        expect($post->getPublishedAt()->getTimestamp())->toEqual(now()->unix());
        expect($post->isArchived())->toBeFalse();
        expect($post->getArchivedAt())->toBeNull();
    })->with('unpublished-post');

    it('should be able to set [archived] status', function (Post $post) {
        $this->postRepository->setStatus($post, PostStatus::Archived);

        expect($post->getStatus())->toBe(PostStatus::Archived);
        expect($post->isPublished())->toBeFalse();
        expect($post->isArchived())->toBeTrue();
        expect($post->getArchivedAt())->toBeInstanceOf(Date::class);
    })->with('unpublished-post');

    it('should be able to set [delayed] status', function () {
        $post = Post::factory()->unpublished()->create(['should_be_published_at' => now()->addHours(2)]);

        $this->postRepository->setStatus($post, PostStatus::Delayed);

        expect($post->getStatus())->toBe(PostStatus::Delayed);
        expect($post->isDelayed())->toBeTrue();
    });

    it('should be able to set [inTrash] status', function (Post $post) {
        $this->postRepository->deletePost($post, forceDelete: false);

        expect($post->getStatus())->toBe(PostStatus::InTrash);
        expect($post->trashed())->toBeTrue();
    })->with('unpublished-post');

    it('should be able to set [closed] status', function (Post $post) {
        $this->postRepository->setStatus($post, PostStatus::Closed);

        expect($post->getStatus())->toBe(PostStatus::Closed);
        expect($post->isClosed())->toBeTrue();
    })->with('unpublished-post');

    test('isAnyEventPublished method returns true, if there is any published event', function () {
        $post = Post::factory()->published(PostType::Event)->create();

        $isPublished = $this->postRepository->isAnyEventPublished();

        expect($post)->toBeInstanceOf(Post::class);
        expect($post->getStatus())->toBe(PostStatus::Published);
        expect($post->getType())->toBe(PostType::Event);
        expect($isPublished)->toBeTrue();
    });
});
