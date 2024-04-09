<?php

namespace App\Policies;

use App\Enums\Auth\PermissionsEnum;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionsEnum::postCategoryIndex()->value);
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
        return Gate::allows('viewAdmin') || $user->can(PermissionsEnum::postCategoryWrite()->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return Gate::allows('viewAdmin') || $user->can(PermissionsEnum::postCategoryUpdate()->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        return Gate::allows('viewAdmin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(): bool
    {
        return Gate::allows('viewAdmin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(): bool
    {
        return Gate::allows('viewAdmin');
    }
}
