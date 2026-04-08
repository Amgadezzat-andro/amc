<?php

namespace App\Filament\Resources\Button\Model;


use App\Models\Base\BaseTranslationModel;
use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;





class Button extends BaseTranslationModel
{
    

    use HasFactory;

    protected $table = 'button';
    protected $translationForeignKey = 'parent_id';
    


    public $translatedAttributes =
    [
        'url', 'label', 'image_id'
    ];

    protected $fillable =
    [
        'status', 'category_slug', 'icon', 'weight_order', 'published_at',
        'revision', 'changed', 'reject_note'
    ];


    public function scopeActiveWithCategory($query,$category_slug)
    {
        return $query->active()
                    ->where('category_slug', $category_slug);
    }

    public static function getCategoryList()
	{
        $categories = DropdownList::with('translations')->active()->where("category",DropdownList::BUTTON_CATEGORY)->get()->mapWithKeys(function($i) {
            return [$i->id => $i->title];
        });
        return $categories;
	}

    public static function getButtonCategoryList()
	{
        $categories = DropdownList::with('translations')->active()->where("category",DropdownList::BUTTON_CATEGORY)->get()->mapWithKeys(function($i) {
            return [$i->slug => $i->title];
        });
        return $categories;
	}


    public function category()
	{
		return $this->belongsTo(DropdownList::class,'category_slug','slug');
	}

    public function getIcon()
    {
        if($this->icon)
        {
            $iconParts = explode( "-", $this->icon);
            $type = $iconParts[0];
            array_shift($iconParts);
            $iconParts = implode("-",$iconParts);
            return "{$type} fa-{$iconParts}";
        }

    }

    public function mainImage()
    {
        $locale = app()->getLocale();

        return $this->hasOneThrough(
            Media::class,
            ButtonLang::class,
            'parent_id',
            'id',   
            'id',         
            'image_id'
        )->where('language', $locale);
    }



}
