<?php

namespace App\Filament\Resources\Seo\Model;

use App\Models\Base\BaseTranslationModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seo extends BaseTranslationModel
{
    use HasFactory;

    protected $table = 'seo';
    protected $translationForeignKey = 'parent_id';

    protected $dateFormat = "U";



    public $translatedAttributes =
    [
        'title', 'description', 'author', 'keywords', 'image_id',
    ];

    protected $fillable =
    [
        'path', 'status', 'published_at', 'robots'
    ];


}
