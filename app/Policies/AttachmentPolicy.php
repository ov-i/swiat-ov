<?php

namespace App\Policies;

use App\Enums\Auth\PermissionsEnum;
use App\Models\Posts\Attachment;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AttachmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Gate::allows('viewAdmin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Attachment $attachment): bool
    {
        return $user->can(PermissionsEnum::postAttachmentRead()->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(PermissionsEnum::postAttachmentAdd()->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attachment $attachment): bool
    {
        return 
            $attachment->user()->getParentKey() === $user->getKey() &&
            $user->can(PermissionsEnum::postAttachmentUpdate()->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attachment $attachment): bool
    {
        return 
            $user->can(PermissionsEnum::postAttachmentDelete()->value) &&
            $attachment->user()->getParentKey() === $user->getKey();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Attachment $attachment): bool
    {
        return $user->can(PermissionsEnum::postAttachmentRestore()->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attachment $attachment): bool
    {
        return $attachment->user()->getParentKey() === $user->getKey();
    }
}
