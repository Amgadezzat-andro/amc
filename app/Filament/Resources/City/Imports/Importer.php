<?php

namespace App\Filament\Resources\City\Imports;

use App\Filament\Resources\City\Model\City;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use Filament\Actions\Imports\Importer as ImportsImporter;


class Importer extends ImportsImporter
{
    protected static ?string $model = City::class;

    public static function getColumns(): array
    {
        return [


            ImportColumn::make('title:en')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['test1 title', 'test2 title']),

            ImportColumn::make('title:ar')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['تجربه العنوان', 'تجربه العنوان 2']),

            ImportColumn::make('country_id')
                ->requiredMapping()
                ->integer()
                ->rules(['required', 'integer'])
                ->examples(['40', '40']),

            ImportColumn::make('status')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->examples(['1-yes', '0-no']),


            ImportColumn::make('weight_order')
                ->requiredMapping()
                ->integer()
                ->rules(['required', 'integer'])
                ->examples(['10', '10']),


        ];
    }

    public function resolveRecord(): ?City
    {
        // return City::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new City();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your city import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
