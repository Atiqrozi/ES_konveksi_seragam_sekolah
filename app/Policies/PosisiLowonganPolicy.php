<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PosisiLowongan;
use Illuminate\Auth\Access\HandlesAuthorization;

class PosisiLowonganPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list posisi lowongan');
    }

    public function view(User $user, PosisiLowongan $model): bool
    {
        return $user->hasPermissionTo('view posisi lowongan');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create posisi lowongan');
    }

    public function update(User $user, PosisiLowongan $model): bool
    {
        return $user->hasPermissionTo('update posisi lowongan');
    }

    public function delete(User $user, PosisiLowongan $model): bool
    {
        return $user->hasPermissionTo('delete posisi lowongan');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete posisi lowongan');
    }

    public function restore(User $user, PosisiLowongan $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, PosisiLowongan $model): bool
    {
        return false;
    }
}
