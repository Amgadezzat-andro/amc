<?php

namespace App\Traits;

trait SelectColumnVisibility
{

    protected static function selectColumnVisibility()
    {
        return fn() => auth()->user()->can('update_'. strtolower (preg_replace('/([A-Z])/', '::$1', lcfirst( class_basename(static::$model) ) ) ) ) ;
    }

}

