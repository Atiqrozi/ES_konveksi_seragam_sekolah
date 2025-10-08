<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Kegiatan;
use Illuminate\Auth\Access\HandlesAuthorization;

class KegiatanPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list kegiatan');
    }

    public function view(User $user, Kegiatan $model): bool
    {
        return $user->hasPermissionTo('view kegiatan');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create kegiatan');
    }

    public function update(User $user, Kegiatan $model): bool
    {
        return $user->hasPermissionTo('update kegiatan');
    }

    public function selesaikan_kegiatan(User $user, Kegiatan $model): bool
    {
        return $user->hasPermissionTo('selesaikan kegiatan');
    }

    public function delete(User $user, Kegiatan $model): bool
    {
        return $user->hasPermissionTo('delete kegiatan');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete kegiatan');
    }

    public function restore(User $user, Kegiatan $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Kegiatan $model): bool
    {
        return false;
    }



    public function list_riwayat_kegiatan_pegawai(User $user): bool
    {
        return $user->hasPermissionTo('list riwayat kegiatan pegawai');
    }

    public function view_riwayat_kegiatan_pegawai(User $user, Kegiatan $model): bool
    {
        return $user->hasPermissionTo('view riwayat kegiatan pegawai');
    }

    public function list_riwayat_kegiatan_admin(User $user): bool
    {
        return $user->hasPermissionTo('list riwayat kegiatan admin');
    }

    public function view_riwayat_kegiatan_admin(User $user, Kegiatan $model): bool
    {
        return $user->hasPermissionTo('view riwayat kegiatan admin');
    }
}
