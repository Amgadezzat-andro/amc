<?php

namespace App\Filament\Resources\District\Model;

use App\Filament\Resources\City\Model\City;
use App\Models\Base\BaseTranslationModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends BaseTranslationModel
{
    use HasFactory;


    protected $translationForeignKey = 'district_id';

    protected $dateFormat = 'U';


    protected $table = 'district';


    public $translatedAttributes =
    [
        'title'
    ];

    protected $fillable =
    [
        'city_id',
        'slug', 'status', 'weight_order', 'published_at',
        'revision', 'changed', 'reject_note'
    ];


    public static function getCityList()
    {
        $items = City::with('translations')->active()->get()->mapWithKeys(function($i) {
            return [$i->id => $i->title];
        });
        return $items;
    }

    public function city()
	{
		return $this->belongsTo(City::class,'city_id','id');
	}



}
