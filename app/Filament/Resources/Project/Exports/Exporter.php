<?php

namespace App\Filament\Resources\Project\Exports;

use App\Filament\Exports\BaseExporter;
use App\Filament\Resources\Project\Model\Project;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class Exporter extends BaseExporter
{
    protected static ?string $model = Project::class;

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
        $body = 'Project export completed. ' . number_format($export->successful_rows) . ' row(s) exported.';
        if ($export->getFailedRowsCount()) {
            $body .= ' ' . number_format($export->getFailedRowsCount()) . ' failed.';
        }
        return $body;
    }
}
