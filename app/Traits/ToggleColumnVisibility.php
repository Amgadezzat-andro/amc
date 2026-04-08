<?php

namespace App\Traits;

trait ToggleColumnVisibility
{

    protected static function toggleColumnVisibility()
    {
        return fn() => auth()->user()->can('update_'. strtolower (preg_replace('/([A-Z])/', '::$1', lcfirst( class_basename(static::$model) ) ) ) ) ;
    }

}

