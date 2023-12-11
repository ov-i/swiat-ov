<?php

use App\Livewire\Admin\Dashboards\Main;
use App\Livewire\Admin\Posts\Attachment;
use App\Livewire\Admin\Posts\Category;
use App\Livewire\Admin\Posts\Comment;
use App\Livewire\Admin\Posts\Post;
use App\Livewire\Admin\Posts\Tag;
use App\Livewire\Admin\Tickets\Message;
use App\Livewire\Admin\Tickets\MessageEdit;
use App\Livewire\Admin\Tickets\MessageShow;
use App\Livewire\Admin\Tickets\TagEdit;
use App\Livewire\Admin\Tickets\TagShow;
use App\Livewire\Admin\Tickets\Ticket;
use App\Livewire\Admin\Users\Role;
use App\Livewire\Admin\Users\User;
use App\Livewire\Admin\Users\UserEdit;
use App\Livewire\Admin\Users\UserShow;

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
        Route::get('/', Post::class)->name('admin.posts');
        Route::get('/categories', Category::class)->name('admin.categories');
        Route::get('/comments', Comment::class)->name('admin.comments');
        Route::get('/tags', Tag::class)->name('admin.tags');
        Route::get('/attachments', Attachment::class)->name('admin.attachments');
    });

    Route::prefix('resource/support')->group(function () {
        Route::get('/users', User::class)->name('admin.users');
        Route::get('/users/edit/{user}', UserEdit::class)->name('admin.users.edit');
        Route::get('/users/show/{user}', UserShow::class)->name('admin.users.show');
        Route::get('/roles', Role::class)->name('admin.roles');
    });

    Route::prefix('resource/tickets')->group(function () {
        Route::get('/', Ticket::class)->name('admin.tickets');
        Route::get('/edit/{ticket}', Ticket::class)->name('admin.tickets.edit');
        Route::get('/show/{ticket}', Ticket::class)->name('admin.tickets.show');
        Route::get('/messages', Message::class)->name('admin.tickets.messages');
        Route::get('/messages/edit/{message}', MessageEdit::class)->name('admin.tickets.messages.edit');
        Route::get('/messages/show/{message}', MessageShow::class)->name('admin.tickets.messages.show');
        Route::get('/tags', TagEdit::class)->name('admin.tickets.tags.edit');
        Route::get('/tags', TagShow::class)->name('admin.tickets.tags.show');
    });
});
