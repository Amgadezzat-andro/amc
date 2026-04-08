<?php

namespace App\Filament\Resources\ConsultationWebform\Model;

use App\Models\Base\BaseModelNotForAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsultationWebform extends BaseModelNotForAdmin
{
    use HasFactory;

    protected $dateFormat = 'U';

    protected $table = 'consultation_webform';

    const UPDATED_AT = null;

    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'position',
        'email',
        'phone',
        'location',
        'message',
    ];
}
