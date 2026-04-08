<?php

namespace App\Filament\Resources\DropdownList\Imports;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer as ImportsImporter;
use Filament\Actions\Imports\Models\Import;

class Importer extends ImportsImporter
{
    protected static ?string $model = DropdownList::class;

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


            ImportColumn::make('brief:en')
                ->requiredMapping()
                ->rules(['nullable', 'max:1000'])
                ->examples(['test1 brief', 'test2 brief']),

            ImportColumn::make('brief:ar')
                ->requiredMapping()
                ->rules(['nullable', 'max:1000'])
                ->examples(['تجربه brief', 'تجربه brief 2']),

            ImportColumn::make('content:en')
                ->requiredMapping()
                ->rules(['nullable', 'max:1000'])
                ->examples(['test1 content', 'test2 content']),

            ImportColumn::make('content:ar')
                ->requiredMapping()
                ->rules(['nullable', 'max:1000'])
                ->examples(['تجربه content', 'تجربه content 2']),



            ImportColumn::make('status')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->examples(['1-yes', '0-no']),

            ImportColumn::make('category')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['Product Category', 'Bms Category']),



            ImportColumn::make('weight_order')
                ->requiredMapping()
                ->integer()
                ->rules(['nullable', 'integer'])
                ->examples(['10', '10']),


        ];
    }

    public function resolveRecord(): ?DropdownList
    {
        // return DropdownList::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new DropdownList();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your dropdown list import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
