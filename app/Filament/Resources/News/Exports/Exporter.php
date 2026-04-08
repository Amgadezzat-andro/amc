<?php

namespace App\Filament\Resources\News\Exports;

use App\Filament\Exports\BaseExporter;
use App\Filament\Resources\News\Model\News;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class Exporter extends BaseExporter
{
    protected static ?string $model = News::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('slug'),
            ExportColumn::make('title:en')->label(__('Title') . ' (EN)'),
            ExportColumn::make('title:ar')->label(__('Title') . ' (AR)'),
            ExportColumn::make('brief:en')->label(__('Brief') . ' (EN)'),
            ExportColumn::make('brief:ar')->label(__('Brief') . ' (AR)'),
            ExportColumn::make('category.title')->label(__('Category')),
            ExportColumn::make('status'),
            ExportColumn::make('weight_order'),
            ExportColumn::make('published_at'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your News export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
