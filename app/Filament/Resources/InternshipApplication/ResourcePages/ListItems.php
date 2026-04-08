<?php

namespace App\Filament\Resources\InternshipApplication\ResourcePages;

use App\Filament\Resources\InternshipApplication\InternshipApplicationResource;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
    protected static string $resource = InternshipApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
