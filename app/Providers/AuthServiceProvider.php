<?php

namespace App\Providers;

use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Policies\ApiTokenPolicy;
use App\Policies\TicketPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('create-token', [ApiTokenPolicy::class, 'create']);

        Gate::define('view-admin-panel', fn (User $user) => $user->isAdmin() || $user->isModerator());

        Gate::define('read-ticket', function (User $user, Ticket $ticket) {
            return $user->isAdmin() ||
                $ticket->assigned_to === $user->id ||
                $ticket->user_id === $user->id;
        });

        Gate::define('create-ticket', [TicketPolicy::class, 'create']);
    }
}
