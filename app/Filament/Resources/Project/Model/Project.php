<?php

namespace App\Filament\Resources\Project\Model;

use App\Models\Base\BaseTranslationModel;
use App\Models\Media\Media;
use App\Traits\HasHeaderImage;
use App\Traits\HasSeo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends BaseTranslationModel
{
    use HasFactory, HasSeo;

    protected $translationForeignKey = 'project_id';
    protected $table = 'projects';
    protected $dateFormat = 'Y-m-d H:i:s';

    public $translatedAttributes = ['title', 'brief', 'content', 'image_id'];

    protected $fillable = [
        'slug',
        'status',
        'published_at',
        'weight_order',
        'specifications',
        'benefits',
        'video_id',
        'gallery_image_ids',
    ];

    protected $casts = [
        'published_at' => 'date',
        'specifications' => 'array',
        'benefits' => 'array',
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
            ProjectLang::class,
            'project_id',
            'id',
            'id',
            'image_id'
        )->where('language', $locale);
    }

    public function video()
    {
        return $this->belongsTo(Media::class, 'video_id', 'id');
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
