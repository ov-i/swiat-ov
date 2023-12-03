<?php

use App\Livewire\Admin\Dashboards\Main;
use App\Livewire\Admin\Resources\Authorization\Role;
use App\Livewire\Admin\Resources\Authorization\User;
use App\Livewire\Admin\Resources\Authorization\UserEdit;
use App\Livewire\Admin\Resources\Authorization\UserShow;
use App\Livewire\Admin\Resources\Posts\Attachment;
use App\Livewire\Admin\Resources\Posts\Category;
use App\Livewire\Admin\Resources\Posts\Comment;
use App\Livewire\Admin\Resources\Posts\Post;
use App\Livewire\Admin\Resources\Posts\Tag;

$middlewares = [
    config('jetstream.auth_session'),
    'auth:sanctum',
    'verified',
    'can:viewAdmin'
];

Route::prefix('admin')->middleware($middlewares)->group(function () {
    Route::prefix('dashboards')->group(function () {
        Route::get('/', Main::class)->name('admin.dashboard');
    });

    Route::prefix('resources/posts')->group(function () {
        Route::get('/posts', Post::class)->name('admin.posts');
        Route::get('/categories', Category::class)->name('admin.categories');
        Route::get('/comments', Comment::class)->name('admin.comments');
        Route::get('/tags', Tag::class)->name('admin.tags');
        Route::get('/attachments', Attachment::class)->name('admin.attachments');
    });

    Route::prefix('resources/support')->group(function () {
        Route::get('/users', User::class)->name('admin.users');
        Route::get('/users/edit/{user}', UserEdit::class)->name('admin.users.edit');
        Route::get('/users/show/{user}', UserShow::class)->name('admin.users.show');
        Route::get('/roles', Role::class)->name('admin.roles');
    });
});
