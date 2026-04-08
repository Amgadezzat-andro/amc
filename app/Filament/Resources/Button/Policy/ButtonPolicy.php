<?php

namespace App\Filament\Resources\Button\Policy;

use App\Models\User;
use App\Filament\Resources\Button\Model\Button;
use Illuminate\Auth\Access\HandlesAuthorization;

class ButtonPolicy
{


    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_button::button');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Button $button): bool
    {
        return $user->can('view_button::button');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_button::button');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Button $button): bool
    {
        return $user->can('update_button::button');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Button $button): bool
    {
        return $user->can('delete_button::button');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_button::button');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Button $button): bool
    {
        return $user->can('force_delete_button::button');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_button::button');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Button $button): bool
    {
        return $user->can('restore_button::button');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_button::button');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Button $button): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_button::button');
    }



}
