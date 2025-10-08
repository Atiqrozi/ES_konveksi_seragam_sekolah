<?php

namespace App\Policies;

use App\Models\Pesanan;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list pesanan');
    }

    public function view(User $user, Invoice $model): bool
    {
        return $user->hasPermissionTo('view pesanan');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create pesanan');
    }

    public function delete(User $user, Invoice $model): bool
    {
        return $user->hasPermissionTo('delete pesanan');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete pesanan');
    }

    public function restore(User $user, Invoice $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Invoice $model): bool
    {
        return false;
    }
}
