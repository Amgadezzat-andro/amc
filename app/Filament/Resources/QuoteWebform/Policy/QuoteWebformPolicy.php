<?php

namespace App\Filament\Resources\QuoteWebform\Policy;

use App\Filament\Resources\QuoteWebform\Model\QuoteWebform;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuoteWebformPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_quote::webform::quote::webform');
    }

    public function view(User $user, QuoteWebform $quoteWebform): bool
    {
        return $user->can('view_quote::webform::quote::webform');
    }

    public function create(User $user): bool
    {
        return $user->can('create_quote::webform::quote::webform');
    }

    public function update(User $user, QuoteWebform $quoteWebform): bool
    {
        return $user->can('update_quote::webform::quote::webform');
    }

    public function delete(User $user, QuoteWebform $quoteWebform): bool
    {
        return $user->can('delete_quote::webform::quote::webform');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_quote::webform::quote::webform');
    }

    public function forceDelete(User $user, QuoteWebform $quoteWebform): bool
    {
        return $user->can('force_delete_quote::webform::quote::webform');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_quote::webform::quote::webform');
    }

    public function restore(User $user, QuoteWebform $quoteWebform): bool
    {
        return $user->can('restore_quote::webform::quote::webform');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_quote::webform::quote::webform');
    }

    public function replicate(User $user, QuoteWebform $quoteWebform): bool
    {
        return $user->can('replicate_quote::webform::quote::webform');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_quote::webform::quote::webform');
    }
}
