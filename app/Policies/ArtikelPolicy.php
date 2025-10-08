<?php

namespace App\Policies;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArtikelPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list artikel');
    }

    public function view(User $user, Artikel $model): bool
    {
        return $user->hasPermissionTo('view artikel');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create artikel');
    }

    public function update(User $user, Artikel $model): bool
    {
        return $user->hasPermissionTo('update artikel');
    }

    public function delete(User $user, Artikel $model): bool
    {
        return $user->hasPermissionTo('delete artikel');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete artikel');
    }

    public function restore(User $user, Artikel $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Artikel $model): bool
    {
        return false;
    }
}
