<?php

namespace App\Filament\Exports;

use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class BaseExporter extends Exporter
{
    public static function getColumns(): array
    {
        $model = new static::$model;
        $attributes = [ExportColumn::make('id')->label('ID')];
        foreach($model->translatedAttributes as $translateItem)
        {
            foreach(config("app.locales") as $local)
            {
                array_push($attributes, ExportColumn::make($translateItem.":".$local) );
            }
        }
        foreach($model->getFillable() as $fillableItem)
        {
            array_push($attributes, ExportColumn::make($fillableItem) );
        }

        return $attributes;
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $modelName =  explode("\\", static::$model);
        $modelName = end($modelName);
        $body = "Your {$modelName} export has completed and " . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

}
