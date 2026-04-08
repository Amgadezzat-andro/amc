<?php

namespace App\Filament\Resources\VideoGallery\Model;

use App\Models\Base\BaseLangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoGalleryLang extends BaseLangModel
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'youtube_links_lang';
    protected $fillable = [
        'title',
        'url',
        'description'
    ];


}
