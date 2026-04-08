<?php

namespace App\Filament\Resources\Bms\Policy;

use App\Filament\Resources\Bms\Model\Bms;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BmsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_bms::bms');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Bms $bms): bool
    {
        return $user->can('view_bms::bms');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_bms::bms');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Bms $bms): bool
    {
        return $user->can('update_bms::bms');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bms $bms): bool
    {
        return $user->can('delete_bms::bms');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_bms::bms');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Bms $bms): bool
    {
        return $user->can('force_delete_bms::bms');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_bms::bms');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Bms $bms): bool
    {
        return $user->can('restore_bms::bms');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_bms::bms');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Bms $bms): bool
    {
        return $user->can('replicate_bms::bms');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_bms::bms');
    }
}
