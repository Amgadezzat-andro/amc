<?php

namespace App\Filament\Resources\Product\Model;

use App\Models\Base\BaseLangModel;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'products_lang';
    public $timestamps = false;
    protected $fillable = ['title', 'brief', 'image_id'];

    public function mainImage()
    {
        return $this->belongsTo(Media::class, 'image_id', 'id');
    }
}
