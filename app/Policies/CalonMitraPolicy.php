<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CalonMitra;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalonMitraPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list calon mitra');
    }

    public function view(User $user, CalonMitra $model): bool
    {
        return $user->hasPermissionTo('view calon mitra');
    }
}
