<?php

namespace App\Policies;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProdukPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list produk');
    }

    public function view(User $user, Produk $model): bool
    {
        return $user->hasPermissionTo('view produk');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create produk');
    }

    public function update(User $user, Produk $model): bool
    {
        return $user->hasPermissionTo('update produk');
    }

    public function delete(User $user, Produk $model): bool
    {
        return $user->hasPermissionTo('delete produk');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete produk');
    }

    public function restore(User $user, Produk $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Produk $model): bool
    {
        return false;
    }
}
