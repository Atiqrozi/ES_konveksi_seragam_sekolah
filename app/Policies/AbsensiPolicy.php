<?php

namespace App\Policies;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AbsensiPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list absensi');
    }

    public function view(User $user, Absensi $model): bool
    {
        return $user->hasPermissionTo('view absensi');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create absensi');
    }

    public function delete(User $user, Absensi $model): bool
    {
        return $user->hasPermissionTo('delete absensi');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete absensi');
    }

    public function restore(User $user, Absensi $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Absensi $model): bool
    {
        return false;
    }
}
