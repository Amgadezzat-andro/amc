<?php

namespace App\Filament\Resources\News\ResourcePages;

use App\Filament\Resources\BaseResource\Pages\CreateBase;
use App\Filament\Resources\City\CityResource;
use App\Filament\Resources\News\NewsResource;

class Create extends CreateBase
{
    protected static string $resource = NewsResource::class;
}
