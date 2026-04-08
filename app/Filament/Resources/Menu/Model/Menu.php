<?php

namespace App\Filament\Resources\Menu\Model;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Models\Base\BaseTranslationModel;
use Filament\Navigation\MenuItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends BaseTranslationModel
{
    use HasFactory;

    protected $table = 'menu';
    protected $translationForeignKey = 'parent_id';

    protected $dateFormat = 'U';




    public $translatedAttributes =
    [
        'title',
    ];

    protected $fillable =
    [
        'category_slug', 'status', 'weight_order', 'published_at',
        'revision', 'changed', 'reject_note'
    ];




    // public static function getCategoryList()
	// {
    //     $categories = DropdownList::with('translations')->active()->where("category",DropdownList::MENU_CATEGORY)->get()->mapWithKeys(function($i) {
    //         return [$i->slug => $i->title];
    //     });
    //     return $categories;
	// }

    public function category()
	{
		return $this->belongsTo(DropdownList::class,'category_slug','slug');
	}


    public static function getAllList()
    {
        return self::all()->mapWithKeys(function($i) {
            return [$i->id => $i->title];
        });
    }

    public function menuItems(): HasMany
	{
		return $this->hasMany(MenuItem::class,'menu_id','id');
	}



}
