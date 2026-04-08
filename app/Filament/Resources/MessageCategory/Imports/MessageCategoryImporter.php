<?php

namespace App\Filament\Resources\MessageCategory\Imports;

use App\Filament\Resources\MessageCategory\Model\MessageCategory;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;



class MessageCategoryImporter extends Importer
{
    protected static ?string $model = MessageCategory::class;

    public static function getColumns(): array
    {
        return [


            ImportColumn::make('title')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['site', 'validation']),



            ImportColumn::make('status')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->examples(['1-yes', '0-no']),

        ];
    }

    public function resolveRecord(): ?MessageCategory
    {
        // return Page::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new MessageCategory();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your Message Category import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
