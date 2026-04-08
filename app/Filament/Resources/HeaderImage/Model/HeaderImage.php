<?php

namespace App\Filament\Resources\HeaderImage\Model;

use App\Models\Base\BaseTranslationModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class HeaderImage extends BaseTranslationModel
{
    use HasFactory;

    protected $table = 'header_image';
    protected $translationForeignKey = 'parent_id';

        protected $dateFormat = 'U';


    public $translatedAttributes =
    [
        'title',  'image_id', 'header_image_title_color','mobile_image_id','header_image_brief'
    ];

    protected $fillable =
    [
        'path', 'weight_order', 'published_at', 'status',
    ];


}
