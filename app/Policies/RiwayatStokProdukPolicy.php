<?php

namespace App\Policies;

use App\Models\RiwayatStokProduk;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RiwayatStokProdukPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list riwayat stok produk');
    }

    public function view(User $user, RiwayatStokProduk $model): bool
    {
        return $user->hasPermissionTo('view riwayat stok produk');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create riwayat stok produk');
    }

    public function restore(User $user, RiwayatStokProduk $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, RiwayatStokProduk $model): bool
    {
        return false;
    }
}
