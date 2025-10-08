<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pekerjaan;
use Illuminate\Auth\Access\HandlesAuthorization;

class PekerjaanPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list pekerjaans');
    }

    public function view(User $user, Pekerjaan $model): bool
    {
        return $user->hasPermissionTo('view pekerjaans');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create pekerjaans');
    }

    public function update(User $user, Pekerjaan $model): bool
    {
        return $user->hasPermissionTo('update pekerjaans');
    }

    public function delete(User $user, Pekerjaan $model): bool
    {
        return $user->hasPermissionTo('delete pekerjaans');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete pekerjaans');
    }

    public function restore(User $user, Pekerjaan $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Pekerjaan $model): bool
    {
        return false;
    }
}
