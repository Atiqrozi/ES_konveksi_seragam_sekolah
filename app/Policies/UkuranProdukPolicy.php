<?php

namespace App\Policies;

use App\Models\UkuranProduk;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UkuranProdukPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list ukuran produk');
    }

    public function view(User $user, UkuranProduk $model): bool
    {
        return $user->hasPermissionTo('view ukuran produk');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create ukuran produk');
    }

    public function update(User $user, UkuranProduk $model): bool
    {
        return $user->hasPermissionTo('update ukuran produk');
    }

    public function delete(User $user, UkuranProduk $model): bool
    {
        return $user->hasPermissionTo('delete ukuran produk');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete ukuran produk');
    }

    public function restore(User $user, UkuranProduk $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, UkuranProduk $model): bool
    {
        return false;
    }
}
