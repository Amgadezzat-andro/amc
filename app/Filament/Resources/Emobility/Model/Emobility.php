<?php

namespace App\Filament\Resources\Emobility\Model;

use App\Models\Base\BaseTranslationModel;
use App\Models\Media\Media;
use App\Traits\HasHeaderImage;
use App\Traits\HasSeo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Emobility extends BaseTranslationModel
{
    use HasFactory, HasSeo;

    protected $translationForeignKey = 'emobility_id';
    protected $table = 'emobility';
    protected $dateFormat = 'Y-m-d H:i:s';

    public $translatedAttributes = ['title', 'brief', 'content', 'image_id'];

    protected $fillable = [
        'slug',
        'status',
        'published_at',
        'weight_order',
        'features',
        'specifications',
        'gallery_image_ids',
    ];

    protected $casts = [
        'published_at' => 'date',
        'features' => 'array',
        'specifications' => 'array',
        'gallery_image_ids' => 'array',
    ];

    public function setPublishedAtAttribute($value): void
    {
        $this->attributes['published_at'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function mainImage()
    {
        $locale = app()->getLocale();
        return $this->hasOneThrough(
            Media::class,
            EmobilityLang::class,
            'emobility_id',
            'id',
            'id',
            'image_id'
        )->where('language', $locale);
    }

    public function galleryMedia()
    {
        $ids = $this->gallery_image_ids ?? [];
        if (empty($ids)) {
            return collect();
        }
        $ordered = implode(',', array_map('intval', $ids));
        return Media::whereIn('id', $ids)->orderByRaw('FIELD(id, ' . $ordered . ')')->get();
    }
}
