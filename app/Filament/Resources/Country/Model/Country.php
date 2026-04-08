<?php

namespace App\Filament\Resources\Country\Model;

use App\Models\Base\BaseTranslationModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends BaseTranslationModel
{
    use HasFactory;


    protected $translationForeignKey = 'parent_id';

    protected $table = 'countries_tbl';


    public $translatedAttributes =['title'];

    protected $fillable =
    [
        'slug', 'image', 'status', 'status', 'weight_order', 'published_at',
        'revision', 'changed', 'reject_note'
    ];



}
