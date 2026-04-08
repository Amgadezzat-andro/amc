<?php

namespace App\Filament\Resources\CenterService\Model;

use App\Filament\Resources\CenterService\Model\CenterService;
use App\Filament\Resources\News\Model\News;
use App\Filament\Resources\SpecializedCenter\Model\SpecializedCenter;
use App\Models\Base\BaseModelNotForAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsSpecializedCenter extends BaseModelNotForAdmin
{
    use HasFactory;

    protected $table = 'news_specialized_center';

    protected $fillable =
        [
            'specialized_center_id',
            'news_id',
        ];

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id', 'id');
    }
    public function centers()
    {
        return $this->belongsTo(SpecializedCenter::class, 'specialized_center_id', 'id');
    }



}
