<?php

namespace App\Filament\Resources\News\ResourcePages;

use App\Filament\Resources\BaseResource\Pages\ListBase;
use App\Filament\Resources\News\NewsResource;

class ListItems extends ListBase
{
    protected static string $resource = NewsResource::class;
}
