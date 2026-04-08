<?php

namespace App\Filament\Resources\City\Model;

use App\Models\Base\BaseLangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CityLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'city_lang';
    public $timestamps = false;
    protected $fillable = ['title'];


}
