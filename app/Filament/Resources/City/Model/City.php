<?php

namespace App\Filament\Resources\City\Model;

use App\Models\Base\BaseTranslationModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends BaseTranslationModel
{
    use HasFactory;


    protected $translationForeignKey = 'city_id';

    protected $table = 'city';


    public $translatedAttributes =
    [
        'title'
    ];

    protected $fillable =
    [
        'slug', 'status', 'weight_order', 'published_at',
        'revision', 'changed', 'reject_note'
    ];

}
