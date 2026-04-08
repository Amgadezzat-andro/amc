<?php

namespace App\Filament\Resources\Country\Exports;

use App\Filament\Exports\BaseExporter;
use App\Filament\Resources\Country\Model\Country;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class Exporter extends BaseExporter
{
    protected static ?string $model = Country::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('slug'),

            ExportColumn::make('title:en'),
            ExportColumn::make('title:ar'),

            ExportColumn::make('status')
                ->formatStateUsing(fn ($record) =>  ($record->status)? $record->status . '- yes' : $record->status . '- no'),

            ExportColumn::make('weight_order'),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your country export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
