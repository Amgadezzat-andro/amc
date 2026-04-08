<?php

namespace App\Filament\Resources\Page\Model;

use App\Filament\Resources\Bms\Model\Bms;
use App\Filament\Resources\Button\Model\Button;
use App\Filament\Resources\MicroSite\Model\MicroSite;
use App\Models\Base\BaseTranslationModel;
use App\Models\Media\Media;
use App\Traits\HasHeaderImage;
use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class Page extends BaseTranslationModel
{
    use HasFactory, HasSeo, HasHeaderImage, Searchable;


    protected $table = 'page';
    protected $translationForeignKey = 'parent_id';

    protected $dateFormat = 'U';


    public $translatedAttributes =
        [
            'title',
            'brief',
            'content',
            'video_link',
            'image'
        ];

    protected $fillable =
        [
            'slug',
            'bms_category_id',
            'view',
            'layout',
            'image_header_id',
            'status',
            'weight_order',
            'published_at',
            'revision',
            'changed',
            'reject_note',
        ];


    /**
     * getViewList
     * @return array
     */
    public static function getViewList()
    {
        return
            [
                'page' => __('Default Page'),
                'intern_closed_page' => __('INTERNSHIP CLOSED Page'),
                // 'page_with_collapse' => __('Page With Collapse'),
                // 'page_with_tabs' => __('Page With Tabs'),
            ];
    }

    // const MAIN_LAYOUT = 'main-inner';
    // const BUSINESS_LAYOUT = 'business';
    // const LOGIN_LAYOUT = 'login';
    // /**
    //  * getViewList
    //  * @return array
    //  */
    // public static function getLayoutList()
    // {
    //     return
    //         [
    //             self::MAIN_LAYOUT => __('Main Layout'),
    //             self::BUSINESS_LAYOUT => __('Business Layout'),
    //             self::LOGIN_LAYOUT => __('Logoin Layout'),
    //         ];
    // }



    public function mainImage()
    {
        return $this->translate()->mainImage();
    }
    public function headerImage()
    {
        return $this->belongsTo(Media::class, 'image_header_id', 'id');
    }

    public function buttons()
    {
        return $this->hasMany(Button::class, 'category_slug', 'slug');

    }

    public function frontButtons()
    {
        return $this->hasMany(Button::class, 'category_slug', 'slug')->active();
    }


    public function bmses()
    {
        return $this->hasMany(Bms::class, 'module_id')
            ->where('module_class', self::class)
            ->orderBy('category_slug')
            ->orderBy('weight_order');
    }

    public function firstSections()
    {
        return $this->hasMany(Bms::class, 'module_id')
            ->where('module_class', self::class)
            ->where('category_slug', 'first-section')
            ->where('status', true)
            ->with("translations")
            ->orderBy('weight_order');
    }


    // public function microSites()
    // {
    //     return $this->belongsToMany(
    //         MicroSite::class,
    //         'micro_site_common',  // pivot table
    //         'module_id',          // foreign key on pivot (module_id)
    //         'micro_site_id'        // related key on pivot (micro_site_id)
    //     )
    //     ->withPivot('module_class')
    //     ->wherePivot('module_class', self::class); // filter
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
