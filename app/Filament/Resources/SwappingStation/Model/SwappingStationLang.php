<?php

namespace App\Filament\Resources\SwappingStation\Model;

use App\Models\Base\BaseLangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SwappingStationLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'swapping_stations_lang';
    public $timestamps = false;
    protected $fillable = ['name', 'address', 'hours'];
}
