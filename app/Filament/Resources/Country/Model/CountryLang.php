<?php

namespace App\Filament\Resources\Country\Model;

use App\Models\Base\BaseLangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CountryLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'countries_tbl_lang';
    public $timestamps = false;
    protected $fillable = ['title'];


}
