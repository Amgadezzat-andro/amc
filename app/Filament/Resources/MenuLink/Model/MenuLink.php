<?php

namespace App\Filament\Resources\MenuLink\Model;

use App\Filament\Resources\Menu\Model\Menu;
use App\Models\Base\BaseTranslationModel;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuLink extends BaseTranslationModel
{
    use HasFactory, ModelTree;

    protected $table = 'menu_link';
    protected $translationForeignKey = 'parent_id';

    protected $dateFormat = 'U';



    public $translatedAttributes =
    [
        'title', 'link', 'brief',
    ];

    protected $fillable =
    [
        'menu_id', 'self_parent_id', 'image', 'icon', 'additional_attributes',
        'status', 'weight_order', 'position','custom_color_class',
        'published_at', 'revision', 'changed', 'reject_note'
    ];


    public function MainMenu() : BelongsTo
	{
		return $this->belongsTo(Menu::class,'menu_id','id');
	}

    public function image()
	{
		return $this->belongsTo(Media::class,'image','id');
	}


    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
                    ->with("translation")
                    ->orderBy("order", "ASC");
    }

    public function childs()
    {
        return $this->hasMany(MenuLink::class, 'self_parent_id', 'id')
                    ->with("translation")
                    ->with("image")
                    ->where(["status"=> self::STATUS_PUBLISHED])
                    ->orderBy("order", "ASC");
    }

    // Default if you need to override

    // public function determineOrderColumnName(): string
    // {
    //     return "order";
    // }

    // public function determineParentColumnName(): string
    // {
    //     return "parent_id";
    // }

    // public function determineTitleColumnName(): string
    // {
    //     return 'title';
    // }

    // public static function defaultParentKey()
    // {
    //     return -1;
    // }

    // public static function defaultChildrenKeyName(): string
    // {
    //     return "children";
    // }






}
