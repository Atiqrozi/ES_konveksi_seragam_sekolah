<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GajiPegawai;
use Illuminate\Auth\Access\HandlesAuthorization;

class GajiPegawaiPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list gaji semua pegawai');
    }

    public function view(User $user, GajiPegawai $model): bool
    {
        return $user->hasPermissionTo('view gaji semua pegawai');
    }
}
