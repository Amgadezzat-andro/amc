<?php

namespace App\Filament\Resources\Page\Model;

use App\Models\Base\BaseLangModel;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'page_lang';
    public $timestamps = false;
    protected $fillable =
        [
            'title',
            'brief',
            'content',
            'video_link',
            'image',
        ];

    public function mainImage()
    {
        return $this->belongsTo(Media::class, 'image', 'id');
    }





}
