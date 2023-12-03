<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;

Route::middleware($dashboardMiddlewares)->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware($profileMiddlewares)->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])
        ->name('profile.show');

    Route::get('/posts', function() {echo 'ddd'; })
        ->name('user.posts')
      ->middleware('can:writePost');
});
