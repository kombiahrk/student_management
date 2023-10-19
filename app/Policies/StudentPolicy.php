<?php

namespace App\Policies;

use App\Models\User;

class StudentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        if($user->hasPermissionTo('List Student'))
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
        if($user->hasPermissionTo('View Student'))
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
        if($user->hasPermissionTo('Create Student'))
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
        if($user->hasPermissionTo('Update Student'))
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
        if($user->hasPermissionTo('Delete Student'))
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
        if($user->hasPermissionTo('BulkDelete Student'))
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
        if($user->hasPermissionTo('Restore Student'))
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
        if($user->hasPermissionTo('BulkRestore Student'))
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
        if($user->hasPermissionTo('ForceDelete Student'))
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
        if($user->hasPermissionTo('BulkForceDelete Student'))
        {
            return true;
        }
        return false;
    }
}
