<?php

namespace App\Filament\Resources\ContactUsWebform\Exports;

use App\Filament\Exports\BaseExporter;
use App\Filament\Resources\ContactUsWebform\Model\ContactUsWebform;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class Exporter extends BaseExporter
{
    protected static ?string $model = ContactUsWebform::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('first_name')->label(__('First Name')),
            ExportColumn::make('last_name')->label(__('Last Name')),
            ExportColumn::make('email')->label(__('email')),
            ExportColumn::make('phone')->label(__('phone')),
            ExportColumn::make('company')->label(__('Company')),
            ExportColumn::make('position')->label(__('Position')),
            ExportColumn::make('location')->label(__('Location')),
            ExportColumn::make('subject.title')->label(__('Subject')),
            ExportColumn::make('message')->label(__('message')),
            ExportColumn::make('created_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your Contact Us webform export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
