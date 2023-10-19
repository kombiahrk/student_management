<?php

namespace App\Policies;

use App\Models\User;

class CoursePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        if($user->hasPermissionTo('List Course'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user)
    {
        if($user->hasPermissionTo('View Course'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        if($user->hasPermissionTo('Create Course'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {
        if($user->hasPermissionTo('Update Course'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user)
    {
        if($user->hasPermissionTo('Delete Course'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can bulk delete the model.
     */
    public function deleteAny(User $user)
    {
        if($user->hasPermissionTo('BulkDelete Course'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        if($user->hasPermissionTo('Restore Course'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can bulk restore the model.
     */
    public function restoreAny(User $user): bool
    {
        if($user->hasPermissionTo('BulkRestore Course'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user)
    {
        if($user->hasPermissionTo('ForceDelete Course'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDeleteAny(User $user)
    {
        if($user->hasPermissionTo('BulkForceDelete Course'))
        {
            return true;
        }
        return false;
    }
}
