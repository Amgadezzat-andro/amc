<?php

namespace App\Filament\Resources\ConsultationWebform\ResourcePages;

use App\Filament\Resources\ConsultationWebform\ConsultationWebformResource;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
    protected static string $resource = ConsultationWebformResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
