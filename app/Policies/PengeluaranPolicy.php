<?php

namespace App\Policies;

use App\Models\Pengeluaran;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PengeluaranPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list pengeluaran');
    }

    public function view(User $user, Pengeluaran $model): bool
    {
        return $user->hasPermissionTo('view pengeluaran');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create pengeluaran');
    }

    public function update(User $user, Pengeluaran $model): bool
    {
        return $user->hasPermissionTo('update pengeluaran');
    }

    public function delete(User $user, Pengeluaran $model): bool
    {
        return $user->hasPermissionTo('delete pengeluaran');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete pengeluaran');
    }

    public function restore(User $user, Pengeluaran $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Pengeluaran $model): bool
    {
        return false;
    }
}
