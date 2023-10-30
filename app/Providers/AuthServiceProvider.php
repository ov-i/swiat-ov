<?php

namespace App\Providers;

use App\Enums\Auth\RoleNamesEnum;
use App\Models\User;
use App\Policies\ApiTokenPolicy;
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
        PersonalAccessToken::class => ApiTokenPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('create-token', [ApiTokenPolicy::class, 'create']);

        Gate::define('view-admin-panel', function (User $user) {
            return $user->hasRole([RoleNamesEnum::admin()->value, RoleNamesEnum::moderator()->value]);
        });
    }
}
