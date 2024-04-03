<?php

namespace App\Policies;

use App\Enums\Auth\RoleNamesEnum;
use App\Models\Posts\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Gate::allows('viewAdmin', [$user]) || $user->hasRole(RoleNamesEnum::vipMember()->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return Gate::allows('viewAdmin', [$user]) || (
            $user->isPostAuthor($post) &&
            !$post->isEvent()
        );
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return Gate::allows('viewAdmin', [$user]) || $user->isPostAuthor($post);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return Gate::allows('viewAdmin', [$user]) || $user->isPostAuthor($post);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return Gate::allows('viewAdmin', [$user]);
    }
}
