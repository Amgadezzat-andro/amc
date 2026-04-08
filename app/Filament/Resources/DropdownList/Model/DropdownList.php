<?php

namespace App\Filament\Resources\DropdownList\Model;

use App\Filament\Resources\AcademicAffairs\Model\AcademicAffairs;
use App\Filament\Resources\Bms\Model\Bms;
use App\Filament\Resources\Faq\Model\Faq;
use App\Models\Base\BaseTranslationModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DropdownList extends BaseTranslationModel
{
    use HasFactory;


    protected $table = 'dropdown_list';
    protected $translationForeignKey = 'parent_id';
    protected $dateFormat = "U";


    public $translatedAttributes =
        [
            'title',
            'second_title',
            'content',
            'image',
            'video_link'
        ];

    protected $fillable =
        [
            'slug',
            'status',
            'category',
            'published_at',
            'weight_order',
            'changed',
            'reject_note',
            'revision'
        ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopeActiveWithCategory($query, $slug)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->where('category', $slug)
            ->with("translations")
            ->orderBy("weight_order", "ASC")
            ->orderBy("published_at", "DESC");
    }


    // const MENU_CATEGORY = 'Menu Category';
    // const BMS_CATEGORY = "Bms Category";
    // const PAGE_BMS_CATEGORY = "Page Bms Category";
    // const Cities = 'Cities';
    // const VideoGallery = 'VideoGallery';
    const NEWS_CATEGORY = 'News Category';
    const PRODUCT_CATEGORY = 'Product Category';
    const PRODUCT_BRAND = 'Product Brand';
    // const PROJECT_CATEGORY = 'Project Category';
    const BUTTON_CATEGORY = "Button Category";
    const WHY_CHOOSE_US_ABOUT_US = 'Why Choose Us About Us';
    const OUR_PARTNERS_ABOUT_US = 'Our Partners About Us';
    const AG_ENERGIES_TEAM_ABOUT_US = 'AG Energies Team About Us';
    const HOME_PAGE_SLIDER = 'Home Page Slider';
    const HOME_PAGE_ENERGY_CARDS = 'Home Page Energy Cards';
    const HOME_PAGE_COUNTERS = 'Home Page Counters';
    const WHY_CHOOSE_US_ABOUT_US_HOME_PAGE = 'Why Choose Us About Us Home Page';
    const HOME_PAGE_OUR_PARTNERS = 'Home Page Our Partners';
    const CONTACT_SUBJECT = 'Contact Subject';





    // WEB FORMS //




    /**
     * getTypeList
     * @return array
     */
    public static function getCategoryList()
    {
        return
            [
                // self::MENU_CATEGORY => __('Menu Category'),
                // self::BMS_CATEGORY => __("Bms Category"),
                // self::PAGE_BMS_CATEGORY => __("Page Bms Category"),
                // self::Cities => __('Cities'),
                // self::VideoGallery => __('Video Gallery'),
                self::NEWS_CATEGORY => __('News Category'),
                self::PRODUCT_CATEGORY => __('Product Category'),
                self::PRODUCT_BRAND => __('Product Brand'),
                // self::PROJECT_CATEGORY => __('Project Category'),
                self::BUTTON_CATEGORY => __('Button Category'),
                self::WHY_CHOOSE_US_ABOUT_US => __('Why Choose Us About Us'),
                self::OUR_PARTNERS_ABOUT_US => __('Our Partners About Us'),
                self::AG_ENERGIES_TEAM_ABOUT_US => __('Slider Footer About Us'),
                self::HOME_PAGE_SLIDER => __('Home Page Slider'),
                self::HOME_PAGE_ENERGY_CARDS => __('Home Page Energy Cards'),
                self::HOME_PAGE_COUNTERS => __('Home Page Counters'),
                self::WHY_CHOOSE_US_ABOUT_US_HOME_PAGE => __('Why Choose Us About Us Home Page'),
                self::HOME_PAGE_OUR_PARTNERS => __('Home Page Our Partners'),
                self::CONTACT_SUBJECT => __('Contact Subject'),




            ];
    }


    // public function faqs()
    // {
    //     return $this->hasMany(Faq::class, 'category_id', 'id')->active();
    // }

    public function mainImage()
    {
        return $this->translate()->mainImage();
    }

        public function bmses()
    {
        return $this->hasMany(Bms::class, 'module_id')
            ->where('module_class', self::class)
            ->where('category', '=', 'ContentTaps')
            ->orderBy('category')
            ->orderBy('weight_order');
    }



}
