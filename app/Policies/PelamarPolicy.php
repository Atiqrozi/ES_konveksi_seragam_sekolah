<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pelamar;
use Illuminate\Auth\Access\HandlesAuthorization;

class PelamarPolicy
{
    use HandlesAuthorization;

    // Pelamar
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list pelamar');
    }

    public function view(User $user, Pelamar $model): bool
    {
        return $user->hasPermissionTo('view pelamar');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create pelamar');
    }

    public function update(User $user, Pelamar $model): bool
    {
        return $user->hasPermissionTo('update pelamar');
    }

    public function delete(User $user, Pelamar $model): bool
    {
        return $user->hasPermissionTo('delete pelamar');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete pelamar');
    }

    public function restore(User $user, Pelamar $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Pelamar $model): bool
    {
        return false;
    }


    // Riwayat Pelamar
    public function list_riwayat_pelamar(User $user): bool
    {
        return $user->hasPermissionTo('list riwayat pelamar');
    }

    public function view_riwayat_pelamar(User $user, Pelamar $model): bool
    {
        return $user->hasPermissionTo('view riwayat pelamar');
    }
}
