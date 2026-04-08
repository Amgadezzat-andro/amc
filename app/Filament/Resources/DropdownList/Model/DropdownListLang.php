<?php

namespace App\Filament\Resources\DropdownList\Model;

use App\Models\Base\BaseLangModel;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DropdownListLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'dropdown_list_lang';
    public $timestamps = false;
    protected $fillable = [
        'title',
        'content',
        'image',
        'video_link'
    ];

    public function mainImage()
    {
        return $this->belongsTo(Media::class, 'image', 'id');
    }
}
