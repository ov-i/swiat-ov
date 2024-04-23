<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use App\Livewire\Admin\Dashboards\Main;
use App\Livewire\Admin\Posts\Attachment;
use App\Livewire\Admin\Posts\AttachmentEdit;
use App\Livewire\Admin\Posts\AttachmentShow;
use App\Livewire\Admin\Posts\Category;
use App\Livewire\Admin\Posts\CategoryShow;
use App\Livewire\Admin\Posts\Comment;
use App\Livewire\Admin\Posts\Create\PostCreate;
use App\Livewire\Admin\Posts\Edit\PostEdit;
use App\Livewire\Admin\Posts\Show\PostShow;
use App\Livewire\Admin\Posts\Tag;
use App\Livewire\Admin\Posts\TagsCreate;
use App\Livewire\Admin\Users\Role;
use App\Livewire\Admin\Users\UserIndex;
use App\Livewire\Admin\Users\UserEdit;
use App\Livewire\Admin\Users\UserShow;
use App\Livewire\Admin\Posts\CategoryCreate;
use App\Livewire\Admin\Posts\Index\PostIndex;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');


// User profile
Route::middleware($profileMiddlewares)->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])
        ->name('profile.show');

    Route::get('/posts', function () {echo 'ddd'; })
        ->name('user.posts')
      ->middleware('can:writePost');
});

Route::middleware($dashboardMiddlewares)->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
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
        Route::get('/comments', Comment::class)->name('admin.comments');
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
