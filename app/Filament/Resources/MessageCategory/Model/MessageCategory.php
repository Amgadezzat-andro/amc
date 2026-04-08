<?php

namespace App\Filament\Resources\MessageCategory\Model;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MessageCategory extends BaseModel
{
    use HasFactory;

    protected $table = 'message_category';

    /** @var array */
    public $guarded = ['id'];

    protected $fillable = ['title'];


    public function messages()
	{
		return $this->hasMany(Message::class,'category_id','id')->with('translations');
	}





}
