<?php

namespace App\Filament\Resources\SwappingStation\Model;

use App\Models\Base\BaseTranslationModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SwappingStation extends BaseTranslationModel
{
    use HasFactory;

    protected $table = 'swapping_stations';
    protected $translationForeignKey = 'swapping_station_id';
    protected $dateFormat = 'Y-m-d H:i:s';

    public $translatedAttributes = ['name', 'address', 'hours'];

    protected $fillable = [
        'lat',
        'lng',
        'status',
        'published_at',
        'weight_order',
    ];

    protected $casts = [
        'published_at' => 'date',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
    ];

    public function setPublishedAtAttribute($value): void
    {
        $this->attributes['published_at'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }
}
