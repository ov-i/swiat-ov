<?php

use App\Data\PostData;
use App\Enums\Post\PostStatusEnum;
use App\Enums\Post\PostTypeEnum;
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
            'status' => PostStatusEnum::unpublished()
        ]);

        expect($post)->toBeInstanceOf(Post::class);
        expect($post->getTitle())->toBeString();
        expect($post->getStatus())->toBe(PostStatusEnum::unpublished()->value);
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
        assert($post->getStatus() === PostStatusEnum::unpublished()->value);

        $this->expectException(\LogicException::class);

        $status = $this->postRepository->setStatus($post, PostStatusEnum::unpublished());
        expect($status)->toThrow(\LogicException::class);
    })->with('unpublished-post');

    it('should be able to set [published] status', function (Post $post) {
        assert($post->getStatus() === PostStatusEnum::unpublished()->value);

        $this->postRepository->setStatus($post, PostStatusEnum::published());

        expect($post->getStatus())->toBe(PostStatusEnum::published()->value);
        expect($post->getPublishedAt())->toBeInstanceOf(DateTimeInterface::class);
        expect($post->getPublishedAt()->getTimestamp())->toEqual(now()->unix());
        expect($post->isArchived())->toBeFalse();
        expect($post->getArchivedAt())->toBeNull();
    })->with('unpublished-post');

    it('should be able to set [archived] status', function (Post $post) {
        $this->postRepository->setStatus($post, PostStatusEnum::archived());

        expect($post->getStatus())->toBe(PostStatusEnum::archived()->value);
        expect($post->isPublished())->toBeFalse();
        expect($post->isArchived())->toBeTrue();
        expect($post->getArchivedAt())->toBeInstanceOf(Date::class);
    })->with('unpublished-post');

    it('should be able to set [delayed] status', function () {
        $post = Post::factory()->unpublished()->create(['should_be_published_at' => now()->addHours(2)]);

        $this->postRepository->setStatus($post, PostStatusEnum::delayed());

        expect($post->getStatus())->toBe(PostStatusEnum::delayed()->value);
        expect($post->isDelayed())->toBeTrue();
    });

    it('should be able to set [inTrash] status', function (Post $post) {
        $this->postRepository->deletePost($post, forceDelete: false);

        expect($post->getStatus())->toBe(PostStatusEnum::inTrash()->value);
        expect($post->trashed())->toBeTrue();
    })->with('unpublished-post');

    it('should be able to set [closed] status', function (Post $post) {
        $this->postRepository->setStatus($post, PostStatusEnum::closed());

        expect($post->getStatus())->toBe(PostStatusEnum::closed()->value);
        expect($post->isClosed())->toBeTrue();
    })->with('unpublished-post');

    test('isAnyEventPublished method returns true, if there is any published event', function () {
        $post = Post::factory()->published(PostTypeEnum::event())->create();

        $isPublished = $this->postRepository->isAnyEventPublished();

        expect($post)->toBeInstanceOf(Post::class);
        expect($post->getStatus())->toBe(PostStatusEnum::published()->value);
        expect($post->getType())->toBe(PostTypeEnum::event()->value);
        expect($isPublished)->toBeTrue();
    });
});
