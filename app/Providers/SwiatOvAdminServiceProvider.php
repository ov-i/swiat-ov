<?php

namespace App\Providers;

use App\Lib\SwiatOv\RouteCreator;
use App\Livewire\Admin\Dashboards\Main;
use App\Livewire\Admin\Resources\Authorization\RolesList;
use App\Livewire\Admin\Resources\Authorization\RoleView;
use App\Livewire\Admin\Resources\Authorization\UsersList;
use App\Livewire\Admin\Resources\Authorization\UserView;
use App\Livewire\Admin\Resources\Posts\AttachmentsList;
use App\Livewire\Admin\Resources\Posts\CategoriesList;
use App\Livewire\Admin\Resources\Posts\CategoryView;
use App\Livewire\Admin\Resources\Posts\CommentsList;
use App\Livewire\Admin\Resources\Posts\CommentView;
use App\Livewire\Admin\Resources\Posts\PostsList;
use App\Livewire\Admin\Resources\Posts\PostView;
use App\Livewire\Admin\Resources\Posts\TagsList;
use App\Livewire\Admin\Resources\Posts\TagView;
use App\Models\User;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SwiatOvAdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->gate();
        $this->routes();
    }

    public function gate(): void
    {
        Gate::define('viewAdmin', function(User $user) {
            return $user->isAdmin() || $user->isModerator();
        });
    }

    public function routes(): void
    {
        Route::namespace('App\Livewire')
            ->domain(config('swiatov.domain', null))
            ->middleware(['auth:sanctum', 'verified', 'can:viewAdmin'])
            ->prefix('swiat-ov/admin')
            ->group(function (Router $router) {
                $router->prefix('dashboard')->group(function() use ($router) {
                    $router->get('/main', Main::class)->name('swiat-ov.home');
                });
                
                $router->prefix('resources/authorization')->group(function() use ($router) {
                    $router->get('/users', UsersList::class)->name('swiat-ov.auth.users');
                    $router->get('/users/{user}', UserView::class)->name('swiat-ov.auth.user.view');
                    $router->get('/roles', RolesList::class)->name('swiat-ov.auth.roles');
                    $router->get('/roles/{role}', RoleView::class)->name('swiat-ov.auth.role.view');
                });

                
                RouteCreator::group('posts', function(RouteCreator $resource) {
                    $resource->make(PostsList::class);
                    $resource->make(PostView::class);
                    $resource->make(CommentsList::class);
                    $resource->make(CommentView::class);
                    $resource->make(CategoriesList::class);
                    $resource->make(CategoryView::class);
                    $resource->make(TagsList::class);
                    $resource->make(TagView::class);
                    $resource->make(AttachmentsList::class);
                });

                // Resource::make(PostsList::class, 'posts');
                // $router->prefix('resources/posts')->group(function() use ($router) {

                //     // $router->get('/posts', PostsList::class)->name('swiat-ov.posts.posts');
                //     // $router->get('/posts/{post}', PostView::class)->name('swiat-ov.posts.post.view');

                //     $router->get('/comments', CommentsList::class)->name('swiat-ov.posts.comments');
                //     $router->get('/comments/{comment}', CommentView::class)->name('swiat-ov.posts.comment.view');

                //     $router->get('/categories', CategoriesList::class)->name('swiat-ov.posts.categories');
                //     $router->get('/categories/{category}', CategoryView::class)->name('swiat-ov.posts.category.view');

                //     $router->get('/tags', TagsList::class)->name('swiat-ov.posts.tags');
                //     $router->get('/tags/{tag}', TagView::class)->name('swiat-ov.posts.category.view');

                //     $router->get('/attachments', AttachmentsList::class)->name('swiat-ov.posts.attachments');
                //     $router->get('/attachments', AttachmentsList::class)->name('swiat-ov.posts.attachment.view');
                // });

            });
    }
}
