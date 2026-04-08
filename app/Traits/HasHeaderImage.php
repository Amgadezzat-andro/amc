<?php

namespace App\Traits;

use App\Filament\Resources\HeaderImage\Model\HeaderImage;

trait HasHeaderImage
{
    // public function addHeaderImage(): static
    // {
    //     $this->headerImage()->create();

    //     return $this;
    // }

    // protected static function bootHasHeaderImage(): void
    // {
    //     static::created(fn (self $model): self => $model->addHeaderImage());
    // }

    public function headerImage()
    {
        return $this->morphOne(HeaderImage::class, 'model')->withDefault();
        //return $this->belongsTo(HeaderImage::class, 'image_id');
    }
}
