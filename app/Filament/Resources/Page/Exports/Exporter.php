<?php

namespace App\Filament\Resources\Page\Exports;

use App\Filament\Exports\BaseExporter;
use App\Filament\Resources\Page\Model\Page;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class Exporter extends BaseExporter
{
    protected static ?string $model = Page::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('slug'),

            ExportColumn::make('title:en'),
            ExportColumn::make('title:ar'),

            ExportColumn::make('brief:en'),
            ExportColumn::make('brief:ar'),

            ExportColumn::make('content:en'),
            ExportColumn::make('content:ar'),

            ExportColumn::make('footer_content:en'),
            ExportColumn::make('footer_content:ar'),

            ExportColumn::make('header_image_title_color:en'),
            ExportColumn::make('header_image_title_color:ar'),

            ExportColumn::make('header_image_title:en'),
            ExportColumn::make('header_image_title:ar'),


            ExportColumn::make('status')
                ->formatStateUsing(fn ($record) =>  ($record->status)? $record->status . '- yes' : $record->status . '- no'),

            ExportColumn::make('weight_order'),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your page export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
