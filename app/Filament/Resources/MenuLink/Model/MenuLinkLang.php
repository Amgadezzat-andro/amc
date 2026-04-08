<?php

namespace App\Filament\Resources\MenuLink\Model;

use App\Models\Base\BaseLangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuLinkLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'menu_link_lang';
    public $timestamps = false;
    protected $fillable =
    [
        'title', 'link', 'brief'
    ];


}
