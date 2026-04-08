<?php

namespace App\Filament\Resources\Page\Imports;

use App\Filament\Resources\Page\Model\Page;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer as ImportsImporter;
use Filament\Actions\Imports\Models\Import;

class Importer extends ImportsImporter
{
    protected static ?string $model = Page::class;

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
                ->rules(['required', 'max:1000'])
                ->examples(['test1 brief', 'test2 brief']),

            ImportColumn::make('brief:ar')
                ->requiredMapping()
                ->rules(['required', 'max:1000'])
                ->examples(['تجربه العنوان', 'تجربه العنوان 2']),

            ImportColumn::make('content:en')
                ->requiredMapping()
                ->rules(['required', 'max:1000'])
                ->examples(['test1 content', 'test2 content']),

            ImportColumn::make('content:ar')
                ->requiredMapping()
                ->rules(['required', 'max:1000'])
                ->examples(['تجربه العنوان', 'تجربه العنوان 2']),

            ImportColumn::make('footer_content:en')
                ->requiredMapping()
                ->rules(['required', 'max:1000'])
                ->examples(['test1 footer_content', 'test2 footer_content']),

            ImportColumn::make('footer_content:ar')
                ->requiredMapping()
                ->rules(['required', 'max:1000'])
                ->examples(['تجربه العنوان', 'تجربه العنوان 2']),

            ImportColumn::make('header_image_title_color:en')
                ->requiredMapping()
                ->rules(['required', 'max:30'])
                ->examples(['red', 'green']),

            ImportColumn::make('header_image_title_color:ar')
                ->requiredMapping()
                ->rules(['required', 'max:30'])
                ->examples(['red', 'green']),

            ImportColumn::make('header_image_title:en')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['تجربه header_image_brief', 'تجربه header_image_brief 2']),

            ImportColumn::make('header_image_title:ar')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['تجربه header_image_brief', 'تجربه header_image_brief 2']),



            ImportColumn::make('status')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->examples(['1-yes', '0-no']),



            ImportColumn::make('weight_order')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer'])
                ->examples(['10', '10']),

        ];
    }

    public function resolveRecord(): ?Page
    {
        // return Page::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Page();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your page import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
