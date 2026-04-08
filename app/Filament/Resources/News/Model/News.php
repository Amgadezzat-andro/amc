<?php

namespace App\Filament\Resources\News\Model;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Filament\Resources\SpecializedCenter\Model\SpecializedCenter;
use App\Models\Base\BaseTranslationModel;
use App\Models\Media\Media;
use App\Traits\HasHeaderImage;
use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Scout\Searchable;

class News extends BaseTranslationModel
{
    use HasFactory, HasSeo, Searchable;


    protected $translationForeignKey = 'news_id';

    protected $table = 'news';


    public $translatedAttributes =
        [
            'title',
            'brief',
            'content',
            'image_id'
        ];

    protected $fillable =
        [
            'category_id',
            'slug',
            'status',
            'is_campaign',
            'published_at',
            'revision',
            'changed',
            'reject_note',
            'weight_order',
            'views',
            'video_id',
            'gallery_image_ids',
        ];

    protected $casts = [
        'published_at' => 'date',
        'gallery_image_ids' => 'array',
    ];



    public function category()
    {
        return $this->belongsTo(DropdownList::class, 'category_id', 'id');
    }

    public static function getNewsCategoryList()
    {
        return DropdownList::with('translations')->active()
            ->where('category', DropdownList::NEWS_CATEGORY)
            ->get()
            ->mapWithKeys(fn ($i) => [$i->id => $i->title]);
    }

    public function mainImage()
    {
        $locale = app()->getLocale();

        return $this->hasOneThrough(
            Media::class,
            NewsLang::class,
            'news_id',
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

    // public function servicesCenters()
    // {
    //     return $this->belongsToMany(SpecializedCenter::class, 'news_specialized_center', 'news_id', 'specialized_center_id')
    //         ->active();
    // }
    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load('translations');
    }

    public function toSearchableArray()
    {
        return
            [
                'title' => $this->title,
                'brief' => $this->brief,
            ];
    }

}
