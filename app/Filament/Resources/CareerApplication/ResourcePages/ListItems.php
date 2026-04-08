<?php

namespace App\Filament\Resources\CareerApplication\ResourcePages;

use App\Filament\Resources\CareerApplication\CareerApplicationResource;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
    protected static string $resource = CareerApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
