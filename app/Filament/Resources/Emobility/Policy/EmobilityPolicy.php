<?php

namespace App\Filament\Resources\Emobility\Policy;

use App\Filament\Resources\Emobility\Model\Emobility;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmobilityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool { return $user->can('view_any_emobility::emobility'); }
    public function view(User $user, Emobility $emobility): bool { return $user->can('view_emobility::emobility'); }
    public function create(User $user): bool { return $user->can('create_emobility::emobility'); }
    public function update(User $user, Emobility $emobility): bool { return $user->can('update_emobility::emobility'); }
    public function delete(User $user, Emobility $emobility): bool { return $user->can('delete_emobility::emobility'); }
    public function deleteAny(User $user): bool { return $user->can('delete_any_emobility::emobility'); }
    public function forceDelete(User $user, Emobility $emobility): bool { return $user->can('force_delete_emobility::emobility'); }
    public function forceDeleteAny(User $user): bool { return $user->can('force_delete_any_emobility::emobility'); }
    public function restore(User $user, Emobility $emobility): bool { return $user->can('restore_emobility::emobility'); }
    public function restoreAny(User $user): bool { return $user->can('restore_any_emobility::emobility'); }
    public function replicate(User $user, Emobility $emobility): bool { return $user->can('replicate_emobility::emobility'); }
    public function reorder(User $user): bool { return $user->can('reorder_emobility::emobility'); }
}
