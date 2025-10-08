<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    // Admin
    public function list_admin(User $admin): bool
    {
        return $admin->hasPermissionTo('list admin');
    }

    public function view_admin(User $admin, User $model): bool
    {
        return $admin->hasPermissionTo('view admin');
    }

    public function create_admin(User $admin): bool
    {
        return $admin->hasPermissionTo('create admin');
    }

    public function update_admin(User $admin, User $model): bool
    {
        return $admin->hasPermissionTo('update admin');
    }

    public function delete_admin(User $admin, User $model): bool
    {
        return $admin->hasPermissionTo('delete admin');
    }

    public function deleteAny_admin(User $admin): bool
    {
        return $admin->hasPermissionTo('delete admin');
    }

    public function restore_admin(User $admin, User $model): bool
    {
        return false;
    }

    public function forceDelete_admin(User $admin, User $model): bool
    {
        return false;
    }


    // Pegawai
    public function list_pegawai(User $pegawai): bool
    {
        return $pegawai->hasPermissionTo('list pegawai');
    }

    public function view_pegawai(User $pegawai, User $model): bool
    {
        return $pegawai->hasPermissionTo('view pegawai');
    }

    public function create_pegawai(User $pegawai): bool
    {
        return $pegawai->hasPermissionTo('create pegawai');
    }

    public function update_pegawai(User $pegawai, User $model): bool
    {
        return $pegawai->hasPermissionTo('update pegawai');
    }

    public function delete_pegawai(User $pegawai, User $model): bool
    {
        return $pegawai->hasPermissionTo('delete pegawai');
    }

    public function deleteAny_pegawai(User $pegawai): bool
    {
        return $pegawai->hasPermissionTo('delete pegawai');
    }

    public function restore_pegawai(User $pegawai, User $model): bool
    {
        return false;
    }

    public function forceDelete_pegawai(User $pegawai, User $model): bool
    {
        return false;
    }


    // Sales
    public function list_sales(User $sales): bool
    {
        return $sales->hasPermissionTo('list sales');
    }

    public function view_sales(User $sales, User $model): bool
    {
        return $sales->hasPermissionTo('view sales');
    }

    public function create_sales(User $sales): bool
    {
        return $sales->hasPermissionTo('create sales');
    }

    public function update_sales(User $sales, User $model): bool
    {
        return $sales->hasPermissionTo('update sales');
    }

    public function delete_sales(User $sales, User $model): bool
    {
        return $sales->hasPermissionTo('delete sales');
    }

    public function deleteAny_sales(User $sales): bool
    {
        return $sales->hasPermissionTo('delete sales');
    }

    public function restore_sales(User $sales, User $model): bool
    {
        return false;
    }

    public function forceDelete_sales(User $sales, User $model): bool
    {
        return false;
    }
}
