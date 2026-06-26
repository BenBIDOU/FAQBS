<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MasterPolicy
{
    use HandlesAuthorization;

    public function isMaster(User $user)
    {
        return $user->is_master;
    }
}
