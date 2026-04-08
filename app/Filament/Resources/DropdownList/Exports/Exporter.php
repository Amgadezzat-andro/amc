<?php

namespace App\Filament\Resources\DropdownList\Exports;

use App\Filament\Exports\BaseExporter;
use App\Filament\Resources\DropdownList\Model\DropdownList;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class Exporter extends BaseExporter
{
    protected static ?string $model = DropdownList::class;

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

            ExportColumn::make('status')
                ->formatStateUsing(fn ($record) =>  ($record->status)? $record->status . '- yes' : $record->status . '- no'),

            ExportColumn::make('category'),

            ExportColumn::make('is_sub'),

            ExportColumn::make('is_flavor_required'),


            ExportColumn::make('self_parent_id'),
            ExportColumn::make('weight_order'),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your dropdown list export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
