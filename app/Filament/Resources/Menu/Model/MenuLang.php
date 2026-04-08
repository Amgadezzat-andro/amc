<?php

namespace App\Filament\Resources\Menu\Model;

use App\Models\Base\BaseLangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'menu_lang';
    public $timestamps = false;
    protected $fillable =
    [
        'title'
    ];


}
