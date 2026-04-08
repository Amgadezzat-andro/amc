<?php

namespace App\Filament\Resources\QuoteWebform\ResourcePages;

use App\Filament\Resources\QuoteWebform\QuoteWebformResource;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
    protected static string $resource = QuoteWebformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
