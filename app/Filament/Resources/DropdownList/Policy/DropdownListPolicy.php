<?php

namespace App\Filament\Resources\DropdownList\Policy;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DropdownListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_dropdown::list::dropdown::list');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DropdownList $dropdownList): bool
    {
        return $user->can('view_dropdown::list::dropdown::list');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_dropdown::list::dropdown::list');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DropdownList $dropdownList): bool
    {
        return $user->can('update_dropdown::list::dropdown::list');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DropdownList $dropdownList): bool
    {
        return $user->can('delete_dropdown::list::dropdown::list');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_dropdown::list::dropdown::list');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, DropdownList $dropdownList): bool
    {
        return $user->can('force_delete_dropdown::list::dropdown::list');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_dropdown::list::dropdown::list');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, DropdownList $dropdownList): bool
    {
        return $user->can('restore_dropdown::list::dropdown::list');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_dropdown::list::dropdown::list');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, DropdownList $dropdownList): bool
    {
        return $user->can('replicate_dropdown::list::dropdown::list');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_dropdown::list::dropdown::list');
    }
}
