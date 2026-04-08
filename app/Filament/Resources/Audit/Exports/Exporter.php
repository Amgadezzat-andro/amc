<?php

namespace App\Filament\Resources\Audit\Exports;

use App\Filament\Exports\BaseExporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;
use OwenIt\Auditing\Models\Audit;

class Exporter extends BaseExporter
{
    protected static ?string $model = Audit::class;

    public static function getColumns(): array
    {
        return [

            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('user_id')
            ->formatStateUsing(fn ($record) =>  ($record->user_id)? $record->user->username : '')
            ->label('User'),
            ExportColumn::make('event'),
            ExportColumn::make('auditable_type')->label('Model'),
            ExportColumn::make('auditable_id')->label('Model ID'),
            ExportColumn::make('old_values'),
            ExportColumn::make('new_values'),
            ExportColumn::make('url'),
            ExportColumn::make('ip_address'),
            ExportColumn::make('user_agent'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),


        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your audit export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
