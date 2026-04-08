<?php

namespace App\Filament\Resources\Audit\ResourcePages;

use App\Filament\Resources\Audit\AuditResource;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{

    protected static string $resource = AuditResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

}
