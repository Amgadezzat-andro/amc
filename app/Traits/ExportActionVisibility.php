<?php

namespace App\Traits;

trait ExportActionVisibility
{

    protected static function exportActionVisibility()
    {
        return fn() => auth()->user()->can('export_'. strtolower (preg_replace('/([A-Z])/', '::$1', lcfirst( class_basename(static::$model) ) ) ) ) ;
    }

}

