<?php

namespace App\Filament\Resources\Button\Model;

use App\Models\Base\BaseLangModel;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ButtonLang extends BaseLangModel
{
    
    use HasFactory;

    protected $table = 'button_lang';
    public $timestamps = false;
    protected $fillable = 
    [
        'url', 'label', 'image_id'
    ];

    public function mainImage()
    {
        return $this->belongsTo(Media::class, 'image_id', 'id');
    }

}
