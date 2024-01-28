<?php

namespace App\Providers;

use App\Contracts\Followable;
use App\Enums\Auth\RoleNamesEnum;
use App\Enums\Post\PostStatusEnum;
use App\Models\Posts\Post;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Policies\ApiTokenPolicy;
use App\Policies\PostPolicy;
use App\Policies\TicketPolicy;
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
        Ticket::class => TicketPolicy::class,
        User::class => UserPolicy::class,
        Post::class => PostPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('create-token', [ApiTokenPolicy::class, 'create']);

        Gate::define('viewAdmin', fn (User $user) => $user->isAdmin() || $user->isModerator());

        Gate::define('writePost', [PostPolicy::class, 'create']);

        Gate::define('canEditPost', function (User $user, Post $post) {
            return Gate::allows('viewAdmin', ['user' => $user]) || (
                $user->hasRole(RoleNamesEnum::vipMember()->value) &&
                $user->isPostAuthor($post) &&
                !$post->isEvent()
            );
        });

        Gate::define('read-ticket', function (User $user, Ticket $ticket) {
            return $user->isAdmin() ||
                $ticket->assigned_to === $user->id ||
                $ticket->user_id === $user->id;
        });

        Gate::define('create-ticket', [TicketPolicy::class, 'create']);

        Gate::define('can-follow', function(User $user, Followable $followable) {
            if (false === Auth::check() || $user->isBlocked()) {
                return false;
            }

            $isPost = true === $followable instanceof Post;
            
            if ($isPost && (
                PostStatusEnum::published()->value !== $followable->getStatus() && 
                false === Gate::allows('viewAdmin', [$user])
            )) {
                return false;
            }

            return true;
        });
    }
}
