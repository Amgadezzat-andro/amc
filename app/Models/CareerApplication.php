<?php

namespace App\Models;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Models\Job;
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
        'job_id',
        'position_id',
        'message',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(DropdownList::class, 'position_id', 'id');
    }
}
