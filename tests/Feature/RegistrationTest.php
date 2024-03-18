<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

uses(WithFaker::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
})->skip(function () {
    return !Features::enabled(Features::registration());
}, 'Registration support is not enabled.');

test('registration screen cannot be rendered if support is disabled', function () {
    $response = $this->get('/register');

    $response->assertStatus(404);
})->skip(function () {
    return Features::enabled(Features::registration());
}, 'Registration support is enabled.');

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => fake()->userName(),
        'email' => fake()->safeEmail(),
        'password' => 'password1234567',
        'password_confirmation' => 'password1234567',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        'g-recaptcha-response' => 'value'
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
})->skip(function () {
    return !Features::enabled(Features::registration());
}, 'Registration support is not enabled.');
