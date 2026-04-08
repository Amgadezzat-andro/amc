<?php

namespace App\Filament\Resources\Seo\Model;

use App\Models\Base\BaseLangModel;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeoLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'seo_lang';
    public $timestamps = false;
    protected $fillable = [
        'title', 'description', 'author', 'keywords', 'image_id',
    ];


    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id', 'id');
    }

}
