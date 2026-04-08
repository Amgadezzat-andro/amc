<?php

namespace App\Filament\Resources\MenuLink\Policy;

use App\Models\User;
use App\Filament\Resources\MenuLink\Model\MenuLink;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuLinkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_menu::link::menu::link');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MenuLink $menuLink): bool
    {
        return $user->can('view_menu::link::menu::link');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_menu::link::menu::link');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MenuLink $menuLink): bool
    {
        return $user->can('update_menu::link::menu::link');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MenuLink $menuLink): bool
    {
        return $user->can('delete_menu::link::menu::link');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_menu::link::menu::link');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, MenuLink $menuLink): bool
    {
        return $user->can('force_delete_menu::link::menu::link');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_menu::link::menu::link');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, MenuLink $menuLink): bool
    {
        return $user->can('restore_menu::link::menu::link');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_menu::link::menu::link');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, MenuLink $menuLink): bool
    {
        return $user->can('replicate_menu::link::menu::link');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_menu::link::menu::link');
    }
}
