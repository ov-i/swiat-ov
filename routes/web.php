<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


$authSessionMiddleware = config('jetstream.auth_session', false)
    ? config('jetstream.auth_session')
    : null;

$dashboardMiddlewares = array_filter([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'blocked',
    'verified',
]);

$authMiddleware = config('jetstream.guard')
    ? 'auth:' . config('jetstream.guard')
    : 'auth';

$profileMiddlewares = array_filter([$authMiddleware, $authSessionMiddleware]);


Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware($profileMiddlewares)->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])
        ->name('profile.show');

    Route::get('/posts', function () {echo 'ddd'; })
        ->name('user.posts')
      ->middleware('can:writePost');
});


require_once('swiat-ov.php');
require_once('user-profile.php');
