<?php

namespace App\Filament\Resources\Project\Policy;

use App\Filament\Resources\Project\Model\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_project::project');
    }

    public function view(User $user, Project $project): bool
    {
        return $user->can('view_project::project');
    }

    public function create(User $user): bool
    {
        return $user->can('create_project::project');
    }

    public function update(User $user, Project $project): bool
    {
        return $user->can('update_project::project');
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->can('delete_project::project');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_project::project');
    }

    public function forceDelete(User $user, Project $project): bool
    {
        return $user->can('force_delete_project::project');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_project::project');
    }

    public function restore(User $user, Project $project): bool
    {
        return $user->can('restore_project::project');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_project::project');
    }

    public function replicate(User $user, Project $project): bool
    {
        return $user->can('replicate_project::project');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_project::project');
    }
}
