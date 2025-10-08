<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Kriteria;
use Illuminate\Auth\Access\HandlesAuthorization;

class KriteriaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list kriteria');
    }

    public function view(User $user, Kriteria $model): bool
    {
        return $user->hasPermissionTo('view kriteria');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create kriteria');
    }

    public function update(User $user, Kriteria $model): bool
    {
        return $user->hasPermissionTo('update kriteria');
    }

    public function delete(User $user, Kriteria $model): bool
    {
        return $user->hasPermissionTo('delete kriteria');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete kriteria');
    }

    public function restore(User $user, Kriteria $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Kriteria $model): bool
    {
        return false;
    }
}
