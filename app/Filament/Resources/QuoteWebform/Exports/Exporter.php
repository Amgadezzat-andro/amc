<?php

namespace App\Filament\Resources\QuoteWebform\Exports;

use App\Filament\Exports\BaseExporter;
use App\Filament\Resources\QuoteWebform\Model\QuoteWebform;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class Exporter extends BaseExporter
{
    protected static ?string $model = QuoteWebform::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('full_name')->label(__('Full Name')),
            ExportColumn::make('email')->label(__('Email')),
            ExportColumn::make('phone')->label(__('Phone')),
            ExportColumn::make('site_location')->label(__('Site Location')),
            ExportColumn::make('power_source')->label(__('Power Source')),
            ExportColumn::make('other_power_source')->label(__('Other Power Source')),
            ExportColumn::make('project_type')->label(__('Project Type')),
            ExportColumn::make('residential_roof_space')->label(__('Residential Roof Space')),
            ExportColumn::make('residential_ground_space')->label(__('Residential Ground Space')),
            ExportColumn::make('residential_current_consumption')->label(__('Residential Consumption')),
            ExportColumn::make('residential_peak_load')->label(__('Residential Peak Load')),
            ExportColumn::make('residential_backup_needed')->label(__('Residential Backup Needed')),
            ExportColumn::make('residential_backup_duration')->label(__('Residential Backup Duration')),
            ExportColumn::make('residential_backup_percentage')->label(__('Residential Backup Percentage')),
            ExportColumn::make('commercial_business_name')->label(__('Commercial Business Name')),
            ExportColumn::make('commercial_business_type')->label(__('Commercial Business Type')),
            ExportColumn::make('commercial_roof_space')->label(__('Commercial Roof Space')),
            ExportColumn::make('commercial_ground_space')->label(__('Commercial Ground Space')),
            ExportColumn::make('commercial_consumption')->label(__('Commercial Consumption')),
            ExportColumn::make('commercial_peak_load')->label(__('Commercial Peak Load')),
            ExportColumn::make('commercial_working_hours')->label(__('Commercial Working Hours')),
            ExportColumn::make('commercial_operates_at_night')->label(__('Commercial Night Operations')),
            ExportColumn::make('commercial_night_hours')->label(__('Commercial Night Hours')),
            ExportColumn::make('commercial_backup_needed')->label(__('Commercial Backup Needed')),
            ExportColumn::make('commercial_backup_percentage')->label(__('Commercial Backup Percentage')),
            ExportColumn::make('agricultural_farm_name')->label(__('Agricultural Farm Name')),
            ExportColumn::make('agricultural_activity_type')->label(__('Agricultural Activity Type')),
            ExportColumn::make('agricultural_power_usage')->label(__('Agricultural Power Usage')),
            ExportColumn::make('agricultural_other_power_usage')->label(__('Agricultural Other Power Usage')),
            ExportColumn::make('agricultural_roof_space')->label(__('Agricultural Roof Space')),
            ExportColumn::make('agricultural_ground_space')->label(__('Agricultural Ground Space')),
            ExportColumn::make('agricultural_consumption')->label(__('Agricultural Consumption')),
            ExportColumn::make('agricultural_peak_load')->label(__('Agricultural Peak Load')),
            ExportColumn::make('agricultural_working_hours')->label(__('Agricultural Working Hours')),
            ExportColumn::make('agricultural_operates_at_night')->label(__('Agricultural Night Operations')),
            ExportColumn::make('agricultural_night_hours')->label(__('Agricultural Night Hours')),
            ExportColumn::make('agricultural_backup_needed')->label(__('Agricultural Backup Needed')),
            ExportColumn::make('agricultural_backup_percentage')->label(__('Agricultural Backup Percentage')),
            ExportColumn::make('created_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your Quote webform export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
