<?php

namespace App\Filament\Resources\ContactUsWebform\ResourcePages;

use App\Filament\Resources\ContactUsWebform\ContactUsWebformResource;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
    protected static string $resource = ContactUsWebformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }


}
