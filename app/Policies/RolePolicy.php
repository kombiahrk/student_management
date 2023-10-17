<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        if($user->hasPermissionTo('List Role'))
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
        if($user->hasPermissionTo('View Role'))
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
        if($user->hasPermissionTo('Create Role'))
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
        if($user->hasPermissionTo('Update Role'))
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
        if($user->hasPermissionTo('Delete Role'))
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
        if($user->hasPermissionTo('BulkDelete Role'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user)
    {
        if($user->hasPermissionTo('Restore Role'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can bulk restore the model.
     */
    public function restoreAny(User $user)
    {
        if($user->hasPermissionTo('BulkRestore Role'))
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
        if($user->hasPermissionTo('ForceDelete Role'))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently bulk forcedelete the model.
     */
    public function forceDeleteAny(User $user)
    {
        if($user->hasPermissionTo('BulkForceDelete Role'))
        {
            return true;
        }
        return false;
    }
}
