<?php

namespace App\Filament\Resources\Button\Imports;
use App\Filament\Resources\Button\Model\Button;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer as ImportsImporter;
use Filament\Actions\Imports\Models\Import;

class Importer extends ImportsImporter
{

    
    protected static ?string $model = Button::class;

    public static function getColumns(): array
    {
        return [


            ImportColumn::make('url:en')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['https://www.google.com', '/members']),

            ImportColumn::make('url:ar')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['https://www.google.com', '/members']),

            ImportColumn::make('label:en')
                ->requiredMapping()
                ->rules(['nullable', 'max:1000'])
                ->examples(['View More', 'Submit']),

            ImportColumn::make('label:ar')
                ->requiredMapping()
                ->rules(['nullable', 'max:1000'])
                ->examples(['اعرف اكثر', 'حفظ']),



            ImportColumn::make('status')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->examples(['1-yes', '0-no']),

            ImportColumn::make('category_slug')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['home-page-first-section', 'home-page-first-section']),

            ImportColumn::make('weight_order')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer'])
                ->examples(['10', '10']),


        ];
    }

    public function resolveRecord(): ?Button
    {
        // return Button::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Button();


    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your button import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    
}
