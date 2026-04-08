<?php

namespace App\Filament\Resources\Bms\Imports;

use App\Filament\Resources\Bms\Model\Bms;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use Filament\Actions\Imports\Importer as ImportsImporter;


class Importer extends ImportsImporter
{
    protected static ?string $model = Bms::class;

    public static function getColumns(): array
    {
        return [


            ImportColumn::make('title:en')
                ->rules(['required', 'max:255'])
                ->examples(['test1 title', 'test2 title']),

            ImportColumn::make('title:ar')
                ->rules(['required', 'max:255'])
                ->examples(['تجربه العنوان', 'تجربه العنوان 2']),

            ImportColumn::make('second_title:en')
                ->rules(['nullable', 'max:255'])
                ->examples(['test1 second title', 'test2 second title']),

            ImportColumn::make('second_title:ar')
                ->rules(['nullable', 'max:255'])
                ->examples(['تجربه العنوان الثاني', 'تجربه العنوان الثاني 2']),

            ImportColumn::make('brief:en')
                ->rules(['nullable', 'max:1000'])
                ->examples(['test1 second brief', 'test2 second brief']),

            ImportColumn::make('brief:ar')
                ->rules(['nullable', 'max:1000'])
                ->examples(['تجربه مختصر ', 'تجربه مختصر  2']),

            ImportColumn::make('content:en')
                ->rules(['nullable'])
                ->examples(['test1 second brief', 'test2 second brief']),

            ImportColumn::make('content:ar')
                ->rules(['nullable'])
                ->examples(['تجربه مختصر ', 'تجربه مختصر  2']),

            ImportColumn::make('url:en')
                ->rules(['nullable', 'max:255'])
                ->examples(['https://google.com', '/news']),

            ImportColumn::make('url:ar')
                ->rules(['nullable', 'max:255'])
                ->examples(['https://google.com', '/news']),

            ImportColumn::make('module_class')
                ->rules(['nullable', 'max:255'])
                ->examples(['App\Filament\Resources\Page\Model\Page', 'App\Filament\Resources\Page\Model\Page']),

            ImportColumn::make('module_id')
                ->rules(['nullable', 'max:255'])
                ->examples(['1', '2']),


            ImportColumn::make('status')
                ->boolean()
                ->rules(['required', 'boolean'])
                ->examples(['1-yes', '0-no']),

            ImportColumn::make('category')
                ->rules(['required', 'max:255'])
                ->examples(['home-page-first-section', 'home-page-first-section']),

            ImportColumn::make('weight_order')
                ->numeric()
                ->rules(['nullable', 'integer'])
                ->examples(['10', '10']),


        ];
    }

    public function resolveRecord(): ?Bms
    {
        // return Bms::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Bms();


    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your bms import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

}
