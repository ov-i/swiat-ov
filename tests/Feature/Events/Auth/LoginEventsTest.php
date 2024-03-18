<?php

use App\Listeners\Auth\UpdateLastLoginAt;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

describe('Login Events Test', function () {
    test('The listener UpdateLastLoginAt is listening for the Login event', function () {
        Event::fake();

        $user = User::factory()->create();

        Auth::login($user);

        Event::assertListening(Login::class, UpdateLastLoginAt::class);
    });

    it('Updates last_login_at column for logged in user', function () {
        $user = User::factory()->create(['last_login_at' => null]);

        assert(blank($user->getLastLoginTZ()));

        Auth::login($user);

        assert(filled($user->getLastLoginTZ()));
        expect($user->fresh()->getLastLoginTZ())->not()->toBeNull();
    });
});
