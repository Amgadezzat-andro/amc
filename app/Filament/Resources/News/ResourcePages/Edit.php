<?php

namespace App\Filament\Resources\News\ResourcePages;

use App\Filament\Resources\BaseResource\Pages\EditBase;
use App\Filament\Resources\City\CityResource;
use App\Filament\Resources\News\NewsResource;

class Edit extends EditBase
{
    protected static string $resource = NewsResource::class;

}
