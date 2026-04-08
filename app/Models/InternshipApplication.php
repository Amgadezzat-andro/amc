<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipApplication extends Model
{
    use HasFactory;

    protected $table = 'internship_applications';

    protected $dateFormat = 'U';

    const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'date_of_birth',
        'address',
        'university',
        'major',
        'level_of_studies',
        'date_of_availability',
        'cv',
        'cover_letter',
        'message',
    ];
}
