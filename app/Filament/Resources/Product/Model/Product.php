<?php

namespace App\Filament\Resources\Product\Model;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Models\Base\BaseTranslationModel;
use App\Models\Media\Media;
use App\Traits\HasHeaderImage;
use App\Traits\HasSeo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseTranslationModel
{
    use HasFactory, HasSeo;

    protected $translationForeignKey = 'product_id';
    protected $table = 'products';
    protected $dateFormat = 'Y-m-d H:i:s';

    public $translatedAttributes = ['title', 'brief', 'image_id'];

    protected $fillable = [
        'category_id',
        'brand_id',
        'slug',
        'status',
        'published_at',
        'weight_order',
        'specifications',
    ];

    protected $casts = [
        'published_at' => 'date',
        'specifications' => 'array',
    ];

    public function setPublishedAtAttribute($value): void
    {
        $this->attributes['published_at'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function category()
    {
        return $this->belongsTo(DropdownList::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(DropdownList::class, 'brand_id', 'id');
    }

    public static function getProductCategoryList()
    {
        return DropdownList::with('translations')->active()
            ->where('category', DropdownList::PRODUCT_CATEGORY)
            ->get()
            ->mapWithKeys(fn ($i) => [$i->id => $i->title]);
    }

    public static function getProductBrandList()
    {
        return DropdownList::with('translations')->active()
            ->where('category', DropdownList::PRODUCT_BRAND)
            ->get()
            ->mapWithKeys(fn ($i) => [$i->id => $i->title]);
    }

    public function mainImage()
    {
        $locale = app()->getLocale();
        return $this->hasOneThrough(
            Media::class,
            ProductLang::class,
            'product_id',
            'id',
            'id',
            'image_id'
        )->where('language', $locale);
    }
}
