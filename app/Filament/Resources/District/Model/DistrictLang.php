<?php

namespace App\Filament\Resources\District\Model;

use App\Models\Base\BaseLangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DistrictLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'district_lang';
    public $timestamps = false;
    protected $fillable = ['title'];


}
