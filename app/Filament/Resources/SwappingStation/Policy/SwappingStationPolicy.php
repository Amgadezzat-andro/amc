<?php

namespace App\Filament\Resources\SwappingStation\Policy;

use App\Filament\Resources\SwappingStation\Model\SwappingStation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SwappingStationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool { return $user->can('view_any_swapping_station::swapping_station'); }
    public function view(User $user, SwappingStation $record): bool { return $user->can('view_swapping_station::swapping_station'); }
    public function create(User $user): bool { return $user->can('create_swapping_station::swapping_station'); }
    public function update(User $user, SwappingStation $record): bool { return $user->can('update_swapping_station::swapping_station'); }
    public function delete(User $user, SwappingStation $record): bool { return $user->can('delete_swapping_station::swapping_station'); }
    public function deleteAny(User $user): bool { return $user->can('delete_any_swapping_station::swapping_station'); }
    public function forceDelete(User $user, SwappingStation $record): bool { return $user->can('force_delete_swapping_station::swapping_station'); }
    public function forceDeleteAny(User $user): bool { return $user->can('force_delete_any_swapping_station::swapping_station'); }
    public function restore(User $user, SwappingStation $record): bool { return $user->can('restore_swapping_station::swapping_station'); }
    public function restoreAny(User $user): bool { return $user->can('restore_any_swapping_station::swapping_station'); }
    public function replicate(User $user, SwappingStation $record): bool { return $user->can('replicate_swapping_station::swapping_station'); }
    public function reorder(User $user): bool { return $user->can('reorder_swapping_station::swapping_station'); }
}
