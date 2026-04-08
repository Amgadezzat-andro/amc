<?php

namespace App\Filament\Resources\Emobility\Exports;

use App\Filament\Exports\BaseExporter;
use App\Filament\Resources\Emobility\Model\Emobility;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class Exporter extends BaseExporter
{
    protected static ?string $model = Emobility::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('slug'),
            ExportColumn::make('title:en'),
            ExportColumn::make('title:ar'),
            ExportColumn::make('status')->formatStateUsing(fn ($record) => $record->status ? 'Published' : 'Pending'),
            ExportColumn::make('weight_order'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return 'E-Mobility export completed. ' . number_format($export->successful_rows) . ' row(s) exported.';
    }
}
