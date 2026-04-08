<?php

namespace App\Filament\Resources\Emobility\Model;

use App\Models\Base\BaseLangModel;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmobilityLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'emobility_lang';
    public $timestamps = false;
    protected $fillable = ['title', 'brief', 'content', 'image_id'];

    public function mainImage()
    {
        return $this->belongsTo(Media::class, 'image_id', 'id');
    }
}
