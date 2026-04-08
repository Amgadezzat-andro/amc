<?php

namespace App\Filament\Resources\MessageCategory\ResourcePages;

use App\Filament\Resources\BaseResource\Pages\ListBase;
use App\Filament\Resources\MessageCategory\MessageCategoryResource;

class ListItems extends ListBase
{
    protected static string $resource = MessageCategoryResource::class;
}
