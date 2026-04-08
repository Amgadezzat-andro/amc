<?php

namespace App\Filament\Resources\HeaderImage\Model;

use App\Models\Base\BaseLangModel;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeaderImageLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'header_image_lang';
    public $timestamps = false;
    protected $fillable = [
        'title',  'image_id', 'header_image_title_color','header_image_brief','mobile_image_id'
    ];


    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id', 'id');
    }

}
