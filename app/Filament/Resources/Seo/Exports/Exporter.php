<?php

namespace App\Filament\Resources\Seo\Exports;

use App\Filament\Exports\BaseExporter;
use App\Filament\Resources\Seo\Model\Seo;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class Exporter extends BaseExporter
{
    protected static ?string $model = Seo::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('path'),
            ExportColumn::make('robots'),

            ExportColumn::make('title:en'),
            ExportColumn::make('title:ar'),

            ExportColumn::make('description:en'),
            ExportColumn::make('description:ar'),

            ExportColumn::make('author:en'),
            ExportColumn::make('author:ar'),

            ExportColumn::make('keywords:en'),
            ExportColumn::make('keywords:ar'),

            ExportColumn::make('model_type'),
            ExportColumn::make('model_id'),

            ExportColumn::make('status')
                ->formatStateUsing(fn ($record) =>  ($record->status)? $record->status . '- yes' : $record->status . '- no'),


        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your Seo export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
