<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HandleIdelScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // This scope doesn't need to modify the initial query
    }

    public function updating(Model $model)
    {
        if ($model->idle == 1) {
            // Set idle to 0 for all other rows
            $model->newQuery()
                ->where('id', '!=', $model->id)
                ->update(['idle' => 0]);
        }
    }
}
