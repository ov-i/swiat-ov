<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use App\Livewire\Admin\Dashboards\Main;
use App\Livewire\Admin\Posts\Attachment;
use App\Livewire\Admin\Posts\AttachmentEdit;
use App\Livewire\Admin\Posts\AttachmentShow;
use App\Livewire\Admin\Posts\Category;
use App\Livewire\Admin\Posts\CategoryShow;
use App\Livewire\Admin\Posts\CommentIndex;
use App\Livewire\Admin\Posts\Create\PostCreate;
use App\Livewire\Admin\Posts\Edit\PostEdit;
use App\Livewire\Admin\Posts\Show\PostShow;
use App\Livewire\Admin\Posts\Tag;
use App\Livewire\Admin\Posts\TagsCreate;
use App\Livewire\Admin\Users\Role;
use App\Livewire\Admin\Users\Index\UserIndex;
use App\Livewire\Admin\Users\UserEdit;
use App\Livewire\Admin\Users\UserShow;
use App\Livewire\Admin\Posts\CategoryCreate;
use App\Livewire\Admin\Posts\Index\PostIndex;

$authSessionMiddleware = config('jetstream.auth_session', false)
    ? config('jetstream.auth_session')
    : null;

$authMiddleware = config('jetstream.guard')
    ? 'auth:' . config('jetstream.guard')
    : 'auth';

$profileMiddlewares = array_filter([$authMiddleware, $authSessionMiddleware]);

$dashboardMiddlewares = array_filter([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'blocked',
    'verified',
]);

$adminMiddlewares = [
    config('jetstream.auth_session'),
    'auth:sanctum',
    'verified',
    'can:viewAdmin'
];

Route::get('/', [HomeController::class, 'index'])->name('home');

// User routes
Route::group([], function () use (&$dashboardMiddlewares, &$profileMiddlewares) {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware($dashboardMiddlewares)->name('dashboard');

    Route::get('/profile', [UserProfileController::class, 'show'])
        ->name('profile.show')
        ->middleware($profileMiddlewares);

    Route::prefix('wpisy')->group(function () {
        Route::get('/{post:slug}', [PostController::class, 'show'])
            ->name('posts.show');

        Route::post('/{post:slug}/komentarze', [CommentController::class, '__invoke'])
            ->middleware(['throttle:add_comment'])
            ->name('posts.comments.store');
    });
});


// Admin panel
Route::prefix('admin')->middleware($adminMiddlewares)->group(function () {
    Route::prefix('dashboards')->group(function () {
        Route::get('/', Main::class)->name('admin.dashboard');
    });

    Route::prefix('resource/posts')->group(function () {
        Route::get('/', PostIndex::class)->name('admin.posts');
        Route::get('/create', PostCreate::class)->name('admin.posts.create');
        Route::get('/edit/{post:slug}', PostEdit::class)->name('admin.posts.edit');
        Route::get('/show/{post:slug}', PostShow::class)->name('admin.posts.show');
        Route::get('/categories', Category::class)->name('admin.posts.categories');
        Route::get('/categories/create', CategoryCreate::class)->name('admin.categories.create');
        Route::get('categories/show/{category}', CategoryShow::class)->name('admin.posts.categories.show');
        Route::get('/comments', CommentIndex::class)->name('admin.comments');
        Route::get('/tags', Tag::class)->name('admin.posts.tags');
        Route::get('/tags/create', TagsCreate::class)->name('admin.posts.tags.create');
        Route::get('/attachments', Attachment::class)->name('admin.attachments');
        Route::get('/attachments/show/{attachment:checksum}', AttachmentShow::class)->name('admin.attachments.show');
        Route::get('/attachments/edit/{attachment:checksum}', AttachmentEdit::class)->name('admin.attachments.edit');
    });

    Route::prefix('resource/support')->group(function () {
        Route::get('/users', UserIndex::class)->name('admin.users');
        Route::get('/users/edit/{user}', UserEdit::class)
            ->name('admin.users.edit')
            ->withTrashed();
        Route::get('/users/show/{user}', UserShow::class)
            ->name('admin.users.show')
            ->withTrashed();
        Route::get('/roles', Role::class)->name('admin.roles');
    });
});
