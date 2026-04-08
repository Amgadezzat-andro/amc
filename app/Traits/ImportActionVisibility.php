<?php

namespace App\Traits;

trait ImportActionVisibility
{

    protected static function importActionVisibility()
    {
        return fn() => auth()->user()->can('import_'. strtolower (preg_replace('/([A-Z])/', '::$1', lcfirst( class_basename(static::$model) ) ) ) ) ;
    }

}

