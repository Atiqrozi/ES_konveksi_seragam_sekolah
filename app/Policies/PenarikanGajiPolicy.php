<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PenarikanGaji;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenarikanGajiPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list pengajuan penarikan gaji');
    }

    public function view(User $user, PenarikanGaji $model): bool
    {
        return $user->hasPermissionTo('view pengajuan penarikan gaji');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create pengajuan penarikan gaji');
    }

    public function delete(User $user, PenarikanGaji $model): bool
    {
        return $user->hasPermissionTo('delete pengajuan penarikan gaji');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete pengajuan penarikan gaji');
    }

    public function restore(User $user, PenarikanGaji $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, PenarikanGaji $model): bool
    {
        return false;
    }


    public function list_ajuan(User $user): bool
    {
        return $user->hasPermissionTo('list konfirmasi penarikan gaji');
    }

    public function terima_ajuan(User $user, PenarikanGaji $model): bool
    {
        return $user->hasPermissionTo('terima ajuan penarikan gaji');
    }

    public function tolak_ajuan(User $user, PenarikanGaji $model): bool
    {
        return $user->hasPermissionTo('tolak ajuan penarikan gaji');
    }


    public function list_riwayat_semua_ajuan(User $user): bool
    {
        return $user->hasPermissionTo('list riwayat semua ajuan');
    }

    public function view_riwayat_semua_ajuan(User $user, PenarikanGaji $model): bool
    {
        return $user->hasPermissionTo('view riwayat semua ajuan');
    }
}
