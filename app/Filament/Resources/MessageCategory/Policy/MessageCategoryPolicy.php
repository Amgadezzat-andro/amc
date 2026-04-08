<?php

namespace App\Filament\Resources\MessageCategory\Policy;

use App\Filament\Resources\MessageCategory\Model\MessageCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessageCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_message::category::message::category');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MessageCategory $messageCategory): bool
    {
        return $user->can('view_message::category::message::category');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_message::category::message::category');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MessageCategory $messageCategory): bool
    {
        return $user->can('update_message::category::message::category');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MessageCategory $messageCategory): bool
    {
        return $user->can('delete_message::category::message::category');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_message::category::message::category');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, MessageCategory $messageCategory): bool
    {
        return $user->can('force_delete_message::category::message::category');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_message::category::message::category');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, MessageCategory $messageCategory): bool
    {
        return $user->can('restore_message::category::message::category');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_message::category::message::category');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, MessageCategory $messageCategory): bool
    {
        return $user->can('replicate_message::category::message::category');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_message::category::message::category');
    }
}
