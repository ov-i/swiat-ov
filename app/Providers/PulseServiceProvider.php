<?php

namespace App\Providers;

use App\Models\User;
use Gate;

class PulseServiceProvider extends \Laravel\Pulse\PulseServiceProvider
{
    public function boot(): void
    {
        Gate::define('viewPulse', function (User &$user) {
            return $user->isAdmin();
        });
    }
}
