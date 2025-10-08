<?php

namespace App\Policies;

use App\Models\JenisPengeluaran;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JenisPengeluaranPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list jenis pengeluaran');
    }

    public function view(User $user, JenisPengeluaran $model): bool
    {
        return $user->hasPermissionTo('view jenis pengeluaran');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create jenis pengeluaran');
    }

    public function update(User $user, JenisPengeluaran $model): bool
    {
        return $user->hasPermissionTo('update jenis pengeluaran');
    }

    public function delete(User $user, JenisPengeluaran $model): bool
    {
        return $user->hasPermissionTo('delete jenis pengeluaran');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete jenis pengeluaran');
    }

    public function restore(User $user, JenisPengeluaran $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, JenisPengeluaran $model): bool
    {
        return false;
    }
}
