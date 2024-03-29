<?php

namespace App\Providers;

use App\Contracts\Followable;
use App\Enums\Post\PostStatusEnum;
use App\Models\Posts\Post;
use App\Models\User;
use App\Policies\ApiTokenPolicy;
use App\Policies\AttachmentPolicy;
use App\Policies\PostPolicy;
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
        Attachment::class => AttachmentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('create-token', [ApiTokenPolicy::class, 'create']);

        Gate::define('create-attachment', [AttachmentPolicy::class, 'create']);

        Gate::define('viewAdmin', fn (User $user) => $user->isAdmin() || $user->isModerator());

        Gate::define('writePost', [PostPolicy::class, 'create']);

        Gate::define('canEditPost', [PostPolicy::class, 'update']);

        Gate::define('can-follow', function (User $user, Followable $followable) {
            if (!Auth::check() || $user->isBlocked()) {
                return false;
            }

            $isPost = true === $followable instanceof Post;

            if ($isPost && (
                $followable->getStatus() !== PostStatusEnum::published()->value &&
                !Gate::allows('viewAdmin', [$user])
            )) {
                return false;
            }

            return true;
        });
    }
}
