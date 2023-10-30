<?php

use App\Http\Controllers\Admin\UserDashboardController;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Livewire\ApiTokenController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

$authMiddleware = config('jetstream.guard')
    ? 'auth:'.config('jetstream.guard')
    : 'auth';

$authSessionMiddleware = config('jetstream.auth_session', false)
    ? config('jetstream.auth_session')
    : null;

$middlewares = array_filter([$authMiddleware, $authSessionMiddleware]);

Route::middleware($middlewares)->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
});

Route::middleware(['verified', 'can:view-admin-panel'])->prefix('admin')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/api-tokens', [ApiTokenController::class, 'index'])
            ->name('admin.api-tokens.index');

        Route::get('/users', [UserDashboardController::class, 'index'])
            ->name('admin.users.index');
    });
});
