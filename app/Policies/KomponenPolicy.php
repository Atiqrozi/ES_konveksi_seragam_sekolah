<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Komponen;
use Illuminate\Auth\Access\HandlesAuthorization;

class KomponenPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin'); // Hanya Admin yang bisa akses
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Komponen $komponen): bool
    {
        return $user->hasRole('Admin'); // Hanya Admin yang bisa view
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin'); // Hanya Admin yang bisa create
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Komponen $komponen): bool
    {
        return $user->hasRole('Admin'); // Hanya Admin yang bisa update
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Komponen $komponen): bool
    {
        return $user->hasRole('Admin'); // Hanya Admin yang bisa delete
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Komponen $komponen): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Komponen $komponen): bool
    {
        return false;
    }
}