<?php

namespace App\Filament\Resources\VideoGallery\ResourcePages;

use App\Filament\Resources\BaseResource\Pages\ListBase;
use App\Filament\Resources\City\CityResource;
use App\Filament\Resources\VideoGallery\Model\VideoGallery;
use App\Filament\Resources\VideoGallery\VideoGalleryResource;

class ListItems extends ListBase
{
    protected static string $resource = VideoGalleryResource::class;
}
