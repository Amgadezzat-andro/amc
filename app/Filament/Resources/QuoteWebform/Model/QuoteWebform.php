<?php

namespace App\Filament\Resources\QuoteWebform\Model;

use App\Models\Base\BaseModelNotForAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteWebform extends BaseModelNotForAdmin
{
    use HasFactory;

    protected $dateFormat = 'U';

    protected $table = 'quote_webform';

    const UPDATED_AT = null;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'site_location',
        'power_source',
        'other_power_source',
        'project_type',
        'residential_roof_space',
        'residential_ground_space',
        'residential_current_consumption',
        'residential_peak_load',
        'residential_backup_needed',
        'residential_backup_duration',
        'residential_backup_percentage',
        'commercial_business_name',
        'commercial_business_type',
        'commercial_roof_space',
        'commercial_ground_space',
        'commercial_consumption',
        'commercial_peak_load',
        'commercial_working_hours',
        'commercial_operates_at_night',
        'commercial_night_hours',
        'commercial_backup_needed',
        'commercial_backup_percentage',
        'agricultural_farm_name',
        'agricultural_activity_type',
        'agricultural_power_usage',
        'agricultural_other_power_usage',
        'agricultural_roof_space',
        'agricultural_ground_space',
        'agricultural_consumption',
        'agricultural_peak_load',
        'agricultural_working_hours',
        'agricultural_operates_at_night',
        'agricultural_night_hours',
        'agricultural_backup_needed',
        'agricultural_backup_percentage',
        'status',
    ];

    protected $casts = [
        'residential_backup_needed' => 'boolean',
        'commercial_operates_at_night' => 'boolean',
        'commercial_backup_needed' => 'boolean',
        'agricultural_power_usage' => 'array',
        'agricultural_operates_at_night' => 'boolean',
        'agricultural_backup_needed' => 'boolean',
    ];
}
