<?php

namespace App\Policies;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KategoriPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list kategori');
    }

    public function view(User $user, Kategori $model): bool
    {
        return $user->hasPermissionTo('view kategori');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create kategori');
    }

    public function update(User $user, Kategori $model): bool
    {
        return $user->hasPermissionTo('update kategori');
    }

    public function delete(User $user, Kategori $model): bool
    {
        return $user->hasPermissionTo('delete kategori');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete kategori');
    }

    public function restore(User $user, Kategori $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Kategori $model): bool
    {
        return false;
    }
}
