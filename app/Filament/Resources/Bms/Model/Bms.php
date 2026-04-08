<?php

namespace App\Filament\Resources\Bms\Model;

use App\Filament\Resources\Button\Model\Button;
use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Models\Base\BaseTranslationModel;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Bms extends BaseTranslationModel
{
    use HasFactory;

    protected $table = 'bms';
    protected $translationForeignKey = 'parent_id';

    public $translatedAttributes =
        [
            'title',
            'second_title',
            'brief',
            'image_id',
            'cover_image_id',
            'video_id',
            // 'image_responsive_id',
            'button_text',
            'content',
            'content2'
        ];

    protected $fillable =
        [
            'slug',
            'status',
            // 'url',
            'code',
            'category',
            'rate',
            'site_id',
            'weight_order',
            'published_at',
            'revision',
            'changed',
            'reject_note',
            'module_class',
            'module_id',
        ];


    public function scopeActiveWithCategory($query, $category)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->where('category', $category)
            ->with("translations")
            ->orderBy("weight_order", "ASC")
            ->orderBy("published_at", "DESC");
    }

    public static function getBmsCategoryList()
    {
        $categories = DropdownList::with('translations')->active()->where("category", DropdownList::BMS_CATEGORY)->get()->mapWithKeys(function ($i) {
            return [$i->slug => $i->title];
        });
        return $categories;
    }

    public static function getCategoryList()
    {
        return [
            'who-we-are' => __('Who We Are'),
            'powering-africa-future' => __('Powering Africa Future'),
            'investing-clean-energy' => __('Investing Clean Energy'),
            'home-page-news-letter' => __('Home Page News Letter'),
        ];
    }


    // public static function getPageBmsCategoryList()
    // {
    //     $categories = DropdownList::activeWithCategory(DropdownList::PAGE_BMS_CATEGORY)->get()->mapWithKeys(function ($i) {
    //         return [$i->slug => $i->title];
    //     });
    //     return $categories;
    // }


    public function category()
    {
        return $this->belongsTo(DropdownList::class, 'category_slug', 'slug');
    }
    public function buttons()
    {
        return $this->hasMany(Button::class, 'category_slug', 'slug');

    }

    public function frontButtons()
    {
        return $this->hasMany(Button::class, 'category_slug', 'slug')->active();
    }

    public function mainImage()
    {
        $locale = app()->getLocale();

        return $this->hasOneThrough(
            Media::class,
            BmsLang::class,
            'parent_id',
            'id',
            'id',
            'image_id'
        )->where('language', $locale);
    }
    public function coverImage()
    {
        $locale = app()->getLocale();

        return $this->hasOneThrough(
            Media::class,
            BmsLang::class,
            'parent_id',
            'id',
            'id',
            'cover_image_id'
        )->where('language', $locale);
    }
    public function mainVideo()
    {
        $locale = app()->getLocale();

        return $this->hasOneThrough(
            Media::class,
            BmsLang::class,
            'parent_id',
            'id',
            'id',
            'video_id'
        )->where('language', $locale);
    }

    public function mainResponsiveImage()
    {
        $locale = app()->getLocale();

        return $this->hasOneThrough(
            Media::class,
            BmsLang::class,
            'parent_id',
            'id',
            'id',
            'image_responsive_id'
        )->where('language', $locale);
    }





}
