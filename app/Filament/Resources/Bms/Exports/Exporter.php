<?php

namespace App\Filament\Resources\Bms\Exports;

use App\Filament\Exports\BaseExporter;
use App\Filament\Resources\Bms\Model\Bms;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class Exporter extends BaseExporter
{
    protected static ?string $model = Bms::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('slug'),
            ExportColumn::make('title:en'),
            ExportColumn::make('title:ar'),
            ExportColumn::make('second_title:en'),
            ExportColumn::make('second_title:ar'),
            ExportColumn::make('brief:en'),
            ExportColumn::make('brief:ar'),
            ExportColumn::make('url:en'),
            ExportColumn::make('url:ar'),
            ExportColumn::make('button_text_1:en'),
            ExportColumn::make('button_text_1:ar'),
            ExportColumn::make('url_1:en'),
            ExportColumn::make('url_1:ar'),
            ExportColumn::make('button_2_text:en'),
            ExportColumn::make('button_2_text:ar'),
            ExportColumn::make('url_2:en'),
            ExportColumn::make('url_2:ar'),
            ExportColumn::make('button_text_3:en'),
            ExportColumn::make('button_text_3:ar'),
            ExportColumn::make('url_3:en'),
            ExportColumn::make('url_3:ar'),
            ExportColumn::make('status'),
            ExportColumn::make('category_slug'),
            ExportColumn::make('is_video'),
            ExportColumn::make('weight_order'),


        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your bms export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
