<?php

namespace App\Filament\Resources\MessageCategory\Model;

use App\Models\Base\BaseLangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MessageLang extends BaseLangModel
{
    use HasFactory;

    protected $table = 'message_lang';
    public $timestamps = false;
    protected $fillable = ['translation_value'];

}
