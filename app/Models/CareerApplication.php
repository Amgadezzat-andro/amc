<?php

namespace App\Models;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplication extends Model
{
    use HasFactory;

    protected $table = 'career_applications';

    protected $dateFormat = 'U';

    const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'cv',
        'cover_letter',
        'position_id',
        'message',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(DropdownList::class, 'position_id', 'id');
    }
}
