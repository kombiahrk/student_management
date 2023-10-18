<?php

namespace App\Policies;

use App\Models\User;

class ActivityLogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        if($user->hasPermissionTo('View ActivityLogs'))
        {
            return true;
        }
        return false;
    }

}
