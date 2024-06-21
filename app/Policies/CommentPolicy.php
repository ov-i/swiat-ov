<?php

namespace App\Policies;

use App\Enums\Auth\PermissionsEnum;
use App\Models\Posts\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
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
        return $user->can(PermissionsEnum::postCommentWrite()) && !$user->isBlocked();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return
            Gate::allows('viewAdmin', $user) ||
            $user->getKey() === $comment->user()->getParentKey();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return
            Gate::allows('viewAdmin', $user) ||
            $user->getKey() === $comment->user()->getParentKey();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return
            Gate::allows('viewAdmin', $user) || (
                $user->isVip() &&
                $user->getKey() === $comment->user()->getParentKey()
            );
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return Gate::allows('viewAdmin', $user);
    }
}
