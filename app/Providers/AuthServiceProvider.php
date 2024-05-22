<?php

namespace App\Providers;

use App\Contracts\Followable;
use App\Enums\PostStatus;
use App\Models\Posts\Attachment;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\User;
use App\Policies\ApiTokenPolicy;
use App\Policies\AttachmentPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\PostPolicy;
use App\Policies\TagPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\PersonalAccessToken;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        PersonalAccessToken::class => ApiTokenPolicy::class,
        User::class => UserPolicy::class,
        Post::class => PostPolicy::class,
        Attachment::class => AttachmentPolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('viewAdmin', fn (User $user) => $user->isAdmin() || $user->isModerator());

        Gate::define('create-token', [ApiTokenPolicy::class, 'create']);

        Gate::define('view-attachments', [AttachmentPolicy::class, 'viewAny']);
        Gate::define('view-attachment', [AttachmentPolicy::class, 'view']);
        Gate::define('create-attachment', [AttachmentPolicy::class, 'create']);

        Gate::define('view-users', [UserPolicy::class, 'viewAny']);
        Gate::define('view-user', [UserPolicy::class, 'view']);

        Gate::define('view-posts', [PostPolicy::class, 'viewAny']);
        Gate::define('view-post', [PostPolicy::class, 'view']);
        Gate::define('write-post', [PostPolicy::class, 'create']);
        Gate::define('delete-post', [PostPolicy::class, 'delete']);
        Gate::define('can-edit-post', [PostPolicy::class, 'update']);
        Gate::define('can-close-post', fn () => Gate::allows('viewAdmin'));
        Gate::define('post-sync-attachments', [PostPolicy::class, 'attachAttachments']);

        Gate::define('view-category', [CategoryPolicy::class, 'view']);
        Gate::define('write-category', [CategoryPolicy::class, 'create']);

        Gate::define('view-tags', [TagPolicy::class, 'viewAny']);
        Gate::define('view-tag', [TagPolicy::class, 'view']);
        Gate::define('write-tag', [TagPolicy::class, 'create']);

        // Vip posts access
        Gate::define('view-vip-posts', fn (User $user) => $user->isVip() || $user->isAdmin() || $user->isModerator());

        Gate::define('can-follow', function (User $user, Followable $followable) {
            $canFollow = false;
            if (!Auth::check() || $user->isBlocked()) {
                return false;
            }

            $isPost = false;
            if ($followable instanceof Post) {
                $isPost = $followable->getStatus() === PostStatus::Published;
            }

            return $canFollow === $isPost && Gate::allows('viewAdmin', $user);
        });
    }
}
