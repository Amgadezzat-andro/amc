<?php

namespace App\Filament\Resources\Bms\Model;

use App\Models\Base\BaseLangModel;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BmsLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'bms_lang';
    public $timestamps = false;
    protected $fillable = [
        'title',
        'second_title',
        'brief',
        'image_id',
        // 'cover_image_id',
        'video_id',
        // 'image_responsive_id',
        'button_text',
        'content',
        'content2'
    ];



    public function mainImage()
    {
        return $this->belongsTo(Media::class, 'image_id', 'id');
    }
    public function coverImage()
    {
        return $this->belongsTo(Media::class, 'cover_image_id', 'id');
    }

    public function mainResponsiveImage()
    {
        return $this->belongsTo(Media::class, 'image_responsive_id', 'id');
    }
    public function mainVideo()
    {
        return $this->belongsTo(Media::class, 'video_id', 'id');
    }


}
