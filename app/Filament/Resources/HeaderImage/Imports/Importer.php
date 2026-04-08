<?php

namespace App\Filament\Resources\HeaderImage\Imports;

use App\Filament\Resources\HeaderImage\Model\HeaderImage;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use Filament\Actions\Imports\Importer as ImportsImporter;


class Importer extends ImportsImporter
{
    protected static ?string $model = HeaderImage::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('path')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->examples(['/test3', '/test']),

            ImportColumn::make('title:en')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->examples(['1042 kJ', '40g']),

            ImportColumn::make('title:ar')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->examples(['1042 kJ ar', '40g ar']),

            ImportColumn::make('header_image_title_color:en')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->examples(['red', 'green']),

            ImportColumn::make('header_image_title_color:ar')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->examples(['red', 'green']),


                ImportColumn::make('weight_order')
                ->requiredMapping()
                ->integer()
                ->rules(['required', 'integer'])
                ->examples(['10', '10']),

            ImportColumn::make('status')
                ->requiredMapping()
                ->integer()
                ->rules(['integer'])
                ->examples(['1-yes', '0-no'])
                ->ignoreBlankState(),



        ];
    }

    public function resolveRecord(): ?HeaderImage
    {
        // return HeaderImage::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new HeaderImage();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your header image import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
