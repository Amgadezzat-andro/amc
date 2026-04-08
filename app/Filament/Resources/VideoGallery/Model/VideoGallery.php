<?php

namespace App\Filament\Resources\VideoGallery\Model;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Models\Base\BaseTranslationModel;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoGallery extends BaseTranslationModel
{
    use HasFactory;


    protected $translationForeignKey = 'parent_id';

    protected $table = 'youtube_links';


    public $translatedAttributes =
        [
            'title',
            'url',
            'description'
        ];

    protected $fillable =
        [
            'slug',
            'status',
            'category_id',
            'cover_image_id',
            'published_at',
            'revision',
            'changed',
            'reject_note',
            'weight_order',
        ];



    public function category()
    {
        return $this->belongsTo(DropdownList::class, 'category_id', 'id');
    }
    public function mainImage()
    {
        return $this->belongsTo(Media::class, 'cover_image_id', 'id');
    }
    public static function getVideoCategoryList()
    {
        $categories = DropdownList::with('translations')->active()->where("category", DropdownList::VideoGallery)->get()->mapWithKeys(function ($i) {
            return [$i->id => $i->title];
        });
        return $categories;
    }
}
