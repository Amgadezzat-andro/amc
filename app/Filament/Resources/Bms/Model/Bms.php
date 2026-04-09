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
        $formatted = [];
        foreach (self::getGroupedCategories() as $groupName => $categories) {
            foreach ($categories as $key => $value) {
                $formatted[$key] = "[$groupName] $value";
            }
        }
        return $formatted;
    }

    public static function getCategoryListPlain()
    {
        return [
            //! Home PAGE
            'home-page-slider'=>__('Home Page Slider'),
            'home-page-about-us'=>__('Home Page About Us'),
            'home-page-services-overview' => __('Home Page Services Overview'),
            'home-page-services-core' => __('Home Page Services Core'),
            'home-page-services-industries' => __('Home Page Services industries'),
            'home-page-culture-how-we-do'=>__('Home Page Culture How We Do'),
            'home-page-culture-rise-values'=>__('Home Page Culture Rise Values'),
            'home-page-culture-equity-drivin'=>__('Home Page Culture Equity Driven'),
            'home-page-careers'=>__('Home Page Careers'),
            'home-page-our-internship-program'=>__('Home Page Our Internship Program'),

            //!! About Us
            'about-us-header-section' => __('About Us Header Section'),
            'about-us-history-and-evolution' => __('About Us History and Evolution'),
            'about-us-propose-and-future' => __('About Us Propose and Future'),
            'about-us-our-people' => __('About Us Our People'),
            'about-use-partner'=>__('About Us Partner'),
            'about-use-joint-ventures'=>__('About Us Joint Ventures'),

            //!!Services
            'services-overview' => __('Services Overview'),
            'services-industries' => __('Services Industries'),
            'services-what-we-do-company-setup'=>__('Services What We Do Company Setup'),
            'services-what-we-do-audit-and-assurance'=>__('Services What We Do Audit and Assurance'),
            'services-what-we-do-accounting-and-bookkeeping'=>__('Services What We Do Accounting and Bookkeeping'),
            'services-what-we-do-payroll'=>__('Services What We Do Payroll'),
            'services-what-we-do-tax-advisory'=>__('Services What We Do Tax Advisory'),
            'services-what-we-do-internal-control-assessment'=>__('Services What We Do Internal Control Assessment'),
            'services-what-we-do-mergers'=>__('Services What We Do Mergers'),
            'services-what-we-do-human-capital'=>__('Services What We Do Human Capital'),
            'services-connect-us-banner'=>__('Services Connect Us Banner'),

            //!! Cultures
            'culture-header' => __('Culture Header'),
            'culture-feature-card'=>__('Culture Feature Card'),
            'culture-core-value-respect'=>__('Culture Core Value Respect'),
            'culture-core-value-integrity'=>__('Culture Core Value Integrity'),
            'culture-core-value-skills'=>__('Culture Core Value Skills'),
            'culture-core-value-Equaility'=>__('Culture Core Value Equaility'),
            'culture-equity-driven-card'=>__('Culture Equity Driven Card'),

            //!!Careers
            'careers-header'=>__('Careers Header'),

            //!! InternShip
            'internship-header'=>__('Internship Header'),
            'internship-why-join-section'=>__('Internship Why Join Section'),
            'internship-our-program-card'=>__('Internship Our Program Card'),

            //!!News
            'news-index-banner'=>__('News Index Banner'),


        ];
    }

    public static function getGroupedCategories()
    {
        return [
            __('HomePage') => [
                'home-page-slider'=>__('Home Page Slider'),
                'home-page-about-us'=>__('Home Page About Us'),
                'home-page-services-overview' => __('Home Page Services Overview'),
                'home-page-services-core' => __('Home Page Services Core'),
                'home-page-services-industries' => __('Home Page Services industries'),
                'home-page-culture-how-we-do'=>__('Home Page Culture How We Do'),
                'home-page-culture-rise-values'=>__('Home Page Culture Rise Values'),
                'home-page-culture-equity-drivin'=>__('Home Page Culture Equity Driven'),
                'home-page-careers'=>__('Home Page Careers'),
                'home-page-our-internship-program'=>__('Home Page Our Internship Program'),
            ],
            __('Cultures') => [
                'culture-header' => __('Culture Header'),
                'culture-feature-card'=>__('Culture Feature Card'),
                'culture-core-value-respect'=>__('Culture Core Value Respect'),
                'culture-core-value-integrity'=>__('Culture Core Value Integrity'),
                'culture-core-value-skills'=>__('Culture Core Value Skills'),
                'culture-core-value-Equaility'=>__('Culture Core Value Equaility'),
                'culture-equity-driven-card'=>__('Culture Equity Driven Card'),
            ],
            __('About Us') => [
                'about-us-header-section' => __('About Us Header Section'),
                'about-us-history-and-evolution' => __('About Us History and Evolution'),
                'about-us-propose-and-future' => __('About Us Propose and Future'),
                'about-us-our-people' => __('About Us Our People'),
                'about-use-partner'=>__('About Us Partner'),
                'about-use-joint-ventures'=>__('About Us Joint Ventures'),
            ],
            __('Services') => [
                'services-overview' => __('Services Overview'),
                'services-industries' => __('Services Industries'),
                'services-what-we-do-company-setup'=>__('Services What We Do Company Setup'),
                'services-what-we-do-audit-and-assurance'=>__('Services What We Do Audit and Assurance'),
                'services-what-we-do-accounting-and-bookkeeping'=>__('Services What We Do Accounting and Bookkeeping'),
                'services-what-we-do-payroll'=>__('Services What We Do Payroll'),
                'services-what-we-do-tax-advisory'=>__('Services What We Do Tax Advisory'),
                'services-what-we-do-internal-control-assessment'=>__('Services What We Do Internal Control Assessment'),
                'services-what-we-do-mergers'=>__('Services What We Do Mergers'),
                'services-what-we-do-human-capital'=>__('Services What We Do Human Capital'),
                'services-connect-us-banner'=>__('Services Connect Us Banner'),
            ],
            __('Careers') => [
                'careers-header'=>__('Careers Header'),
            ],
            __('Internship') => [
                'internship-header'=>__('Internship Header'),
                'internship-why-join-section'=>__('Internship Why Join Section'),
                'internship-our-program-card'=>__('Internship Our Program Card'),
            ],
            __('News') => [
                'news-index-banner'=>__('News Index Banner'),
            ],
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
