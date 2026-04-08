<?php

namespace App\Livewire;

use App\Filament\Resources\QuoteWebform\Model\QuoteWebform;
use Illuminate\Validation\Rule;

class QuoteForm extends BaseForm
{
    public $mainModel = QuoteWebform::class;

    public $subject = 'Quote Request Form';
    public $emailList = '';

    public const POWER_SOURCES = ['grid', 'generator', 'solar', 'hybrid', 'other'];
    public const PROJECT_TYPES = ['residential', 'commercial', 'agricultural', 'utility'];
    public const AGRICULTURAL_POWER_USAGE = ['water-pumping', 'irrigation', 'other'];

    public $full_name;
    public $email;
    public $phone;
    public $site_location;
    public $power_source;
    public $other_power_source;
    public $project_type;

    public $residential_roof_space;
    public $residential_ground_space;
    public $residential_current_consumption;
    public $residential_peak_load;
    public $residential_backup_needed = false;
    public $residential_backup_duration;
    public $residential_backup_percentage = 50;

    public $commercial_business_name;
    public $commercial_business_type;
    public $commercial_roof_space;
    public $commercial_ground_space;
    public $commercial_consumption;
    public $commercial_peak_load;
    public $commercial_working_hours;
    public $commercial_operates_at_night = false;
    public $commercial_night_hours;
    public $commercial_backup_needed = false;
    public $commercial_backup_percentage = 50;

    public $agricultural_farm_name;
    public $agricultural_activity_type;
    public $agricultural_power_usage = [];
    public $agricultural_other_power_usage;
    public $agricultural_roof_space;
    public $agricultural_ground_space;
    public $agricultural_consumption;
    public $agricultural_peak_load;
    public $agricultural_working_hours;
    public $agricultural_operates_at_night = false;
    public $agricultural_night_hours;
    public $agricultural_backup_needed = false;
    public $agricultural_backup_percentage = 50;

    public $exclude = ['id'];
    public $time = ['created_at'];

    public function setEmailList(): void
    {
        $this->emailList = setting('site.quote_email_list')
            ?: setting('site.contact_us_email_list')
            ?: setting('site.management_email');
    }

    public function updatedProjectType($value): void
    {
        $this->resetTypeFields();
        $this->project_type = $value;
    }

    public function updatedPowerSource($value): void
    {
        if ($value !== 'other') {
            $this->other_power_source = null;
        }
    }

    public function updatedAgriculturalPowerUsage(): void
    {
        if (!in_array('other', $this->agricultural_power_usage, true)) {
            $this->agricultural_other_power_usage = null;
        }
    }

    public function rules(): array
    {
        $rules = [
            'full_name' => ['required', 'string', 'min:3', 'max:255', 'not_regex:/<[^b][^r][^>]*>/'],
            'email' => ['required', 'max:255', 'email:filter', 'not_regex:/<[^b][^r][^>]*>/'],
            'phone' => ['required', 'regex:/^[\d\s\-\+\(\)]{8,20}$/', 'not_regex:/<[^b][^r][^>]*>/'],
            'site_location' => ['required', 'string', 'max:255', 'not_regex:/<[^b][^r][^>]*>/'],
            'power_source' => ['required', Rule::in(self::POWER_SOURCES)],
            'other_power_source' => [
                Rule::requiredIf($this->power_source === 'other'),
                'nullable',
                'string',
                'max:255',
                'not_regex:/<[^b][^r][^>]*>/',
            ],
            'project_type' => ['required', Rule::in(self::PROJECT_TYPES)],
            'captcha' => ['nullable'],
        ];

        if ($this->project_type === 'residential') {
            $rules = array_merge($rules, [
                'residential_roof_space' => ['required', 'numeric', 'min:0'],
                'residential_ground_space' => ['required', 'numeric', 'min:0'],
                'residential_current_consumption' => ['required', 'numeric', 'min:0'],
                'residential_peak_load' => ['required', 'numeric', 'min:0'],
                'residential_backup_needed' => ['boolean'],
                'residential_backup_duration' => [Rule::requiredIf($this->residential_backup_needed), 'nullable', 'numeric', 'min:0'],
                'residential_backup_percentage' => [Rule::requiredIf($this->residential_backup_needed), 'nullable', 'integer', 'between:0,100'],
            ]);
        }

        if ($this->project_type === 'commercial') {
            $rules = array_merge($rules, [
                'commercial_business_name' => ['required', 'string', 'max:255', 'not_regex:/<[^b][^r][^>]*>/'],
                'commercial_business_type' => ['required', 'string', 'max:255', 'not_regex:/<[^b][^r][^>]*>/'],
                'commercial_roof_space' => ['required', 'numeric', 'min:0'],
                'commercial_ground_space' => ['required', 'numeric', 'min:0'],
                'commercial_consumption' => ['required', 'numeric', 'min:0'],
                'commercial_peak_load' => ['required', 'numeric', 'min:0'],
                'commercial_working_hours' => ['required', 'numeric', 'between:0,24'],
                'commercial_operates_at_night' => ['boolean'],
                'commercial_night_hours' => [Rule::requiredIf($this->commercial_operates_at_night), 'nullable', 'numeric', 'between:0,24'],
                'commercial_backup_needed' => ['boolean'],
                'commercial_backup_percentage' => [Rule::requiredIf($this->commercial_backup_needed), 'nullable', 'integer', 'between:0,100'],
            ]);
        }

        if ($this->project_type === 'agricultural') {
            $rules = array_merge($rules, [
                'agricultural_farm_name' => ['required', 'string', 'max:255', 'not_regex:/<[^b][^r][^>]*>/'],
                'agricultural_activity_type' => ['required', 'string', 'max:255', 'not_regex:/<[^b][^r][^>]*>/'],
                'agricultural_power_usage' => ['required', 'array', 'min:1'],
                'agricultural_power_usage.*' => [Rule::in(self::AGRICULTURAL_POWER_USAGE)],
                'agricultural_other_power_usage' => [
                    Rule::requiredIf(in_array('other', $this->agricultural_power_usage, true)),
                    'nullable',
                    'string',
                    'max:255',
                    'not_regex:/<[^b][^r][^>]*>/',
                ],
                'agricultural_roof_space' => ['required', 'numeric', 'min:0'],
                'agricultural_ground_space' => ['required', 'numeric', 'min:0'],
                'agricultural_consumption' => ['required', 'numeric', 'min:0'],
                'agricultural_peak_load' => ['required', 'numeric', 'min:0'],
                'agricultural_working_hours' => ['required', 'numeric', 'between:0,24'],
                'agricultural_operates_at_night' => ['boolean'],
                'agricultural_night_hours' => [Rule::requiredIf($this->agricultural_operates_at_night), 'nullable', 'numeric', 'between:0,24'],
                'agricultural_backup_needed' => ['boolean'],
                'agricultural_backup_percentage' => [Rule::requiredIf($this->agricultural_backup_needed), 'nullable', 'integer', 'between:0,100'],
            ]);
        }

        return $rules;
    }

    private function resetTypeFields(): void
    {
        $this->reset([
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
        ]);

        $this->residential_backup_needed = false;
        $this->commercial_operates_at_night = false;
        $this->commercial_backup_needed = false;
        $this->agricultural_operates_at_night = false;
        $this->agricultural_backup_needed = false;
        $this->residential_backup_percentage = 50;
        $this->commercial_backup_percentage = 50;
        $this->agricultural_backup_percentage = 50;
        $this->agricultural_power_usage = [];
    }

    public function render()
    {
        return view('livewire.quote-form', [
            'powerSourceOptions' => self::POWER_SOURCES,
            'projectTypeOptions' => self::PROJECT_TYPES,
            'agriculturalPowerUsageOptions' => self::AGRICULTURAL_POWER_USAGE,
        ]);
    }
}
