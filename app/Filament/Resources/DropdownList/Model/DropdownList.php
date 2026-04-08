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


    const BUTTON_CATEGORY = "Button Category";

    const Career_Position = 'Career Position';







    // WEB FORMS //




    /**
     * getTypeList
     * @return array
     */
    public static function getCategoryList()
    {
        return
            [


                self::BUTTON_CATEGORY => __('Button Category'),
                self::Career_Position => __('Career Position'),





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
