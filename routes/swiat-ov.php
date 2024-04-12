<?php

use App\Livewire\Admin\Dashboards\Main;
use App\Livewire\Admin\Posts\Attachment;
use App\Livewire\Admin\Posts\AttachmentEdit;
use App\Livewire\Admin\Posts\AttachmentShow;
use App\Livewire\Admin\Posts\Category;
use App\Livewire\Admin\Posts\CategoryShow;
use App\Livewire\Admin\Posts\Comment;
use App\Livewire\Admin\Posts\PostCreate;
use App\Livewire\Admin\Posts\PostEdit;
use App\Livewire\Admin\Posts\PostShow;
use App\Livewire\Admin\Posts\Tag;
use App\Livewire\Admin\Posts\TagsCreate;
use App\Livewire\Admin\Users\Role;
use App\Livewire\Admin\Users\User;
use App\Livewire\Admin\Users\UserEdit;
use App\Livewire\Admin\Users\UserShow;
use App\Livewire\Admin\Posts\CategoryCreate;
use App\Livewire\Admin\Posts\Index\Page;

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

    Route::prefix('resource/posts')->group(function () {
        Route::get('/', Page::class)->name('admin.posts');
        Route::get('/create', PostCreate::class)->name('admin.posts.create');
        Route::get('/edit/{post:slug}', PostEdit::class)->name('admin.posts.edit');
        Route::get('/show/{post:slug}', PostShow::class)->name('admin.posts.show');
        Route::get('/categories', Category::class)->name('admin.posts.categories');
        Route::get('/categories/create', CategoryCreate::class)->name('admin.categories.create');
        Route::get('categories/show/{category}', CategoryShow::class)->name('admin.posts.categories.show');
        Route::get('/comments', Comment::class)->name('admin.comments');
        Route::get('/tags', Tag::class)->name('admin.posts.tags');
        Route::get('/tags/create', TagsCreate::class)->name('admin.posts.tags.create');
        Route::get('/attachments', Attachment::class)->name('admin.attachments');
        Route::get('/attachments/show/{attachment:checksum}', AttachmentShow::class)->name('admin.attachments.show');
        Route::get('/attachments/edit/{attachment:checksum}', AttachmentEdit::class)->name('admin.attachments.edit');
    });

    Route::prefix('resource/support')->group(function () {
        Route::get('/users', User::class)->name('admin.users');
        Route::get('/users/edit/{user}', UserEdit::class)
            ->name('admin.users.edit')
            ->withTrashed();
        Route::get('/users/show/{user}', UserShow::class)
            ->name('admin.users.show')
            ->withTrashed();
        Route::get('/roles', Role::class)->name('admin.roles');
    });
});
