<?php

namespace App\Traits;

use App\Filament\Resources\Seo\Model\Seo;

trait HasSeo
{

    public function seo()
    {
        return $this->morphOne(Seo::class, 'model')->withDefault();
    }
}
