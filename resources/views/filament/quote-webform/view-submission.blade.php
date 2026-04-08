@php
    $projectType = $record->project_type;
    $powerUsage = is_array($record->agricultural_power_usage)
        ? $record->agricultural_power_usage
        : json_decode($record->agricultural_power_usage ?? '[]', true);

    $submittedAt = null;
    if ($record->created_at instanceof \Carbon\CarbonInterface) {
        $submittedAt = $record->created_at->format('d/m/Y h:i A');
    } elseif (is_numeric($record->created_at)) {
        $submittedAt = date('d/m/Y h:i A', (int) $record->created_at);
    } elseif (!empty($record->created_at)) {
        try {
            $submittedAt = \Carbon\Carbon::parse($record->created_at)->format('d/m/Y h:i A');
        } catch (\Throwable $e) {
            $submittedAt = (string) $record->created_at;
        }
    }

    $generalDetails = [
        'Full Name' => $record->full_name,
        'Email' => $record->email,
        'Phone' => $record->phone,
        'Site Location' => $record->site_location,
        'Power Source' => $record->power_source,
        'Other Power Source' => $record->other_power_source,
        'Project Type' => $record->project_type,
        'Submitted At' => $submittedAt,
    ];

    $residentialDetails = [
        'Roof Space (m2)' => $record->residential_roof_space,
        'Ground Space (m2)' => $record->residential_ground_space,
        'Consumption (kWh/day)' => $record->residential_current_consumption,
        'Peak Load (kW)' => $record->residential_peak_load,
        'Backup Needed' => $record->residential_backup_needed ? 'Yes' : 'No',
        'Backup Duration (hours)' => $record->residential_backup_duration,
        'Backup Percentage (%)' => $record->residential_backup_percentage,
    ];

    $commercialDetails = [
        'Business Name' => $record->commercial_business_name,
        'Business Type' => $record->commercial_business_type,
        'Roof Space (m2)' => $record->commercial_roof_space,
        'Ground Space (m2)' => $record->commercial_ground_space,
        'Consumption (kWh/day)' => $record->commercial_consumption,
        'Peak Load (kW)' => $record->commercial_peak_load,
        'Working Hours/day' => $record->commercial_working_hours,
        'Night Operations' => $record->commercial_operates_at_night ? 'Yes' : 'No',
        'Night Hours' => $record->commercial_night_hours,
        'Backup Needed' => $record->commercial_backup_needed ? 'Yes' : 'No',
        'Backup Percentage (%)' => $record->commercial_backup_percentage,
    ];

    $agriculturalDetails = [
        'Farm Name' => $record->agricultural_farm_name,
        'Activity Type' => $record->agricultural_activity_type,
        'Power Usage' => !empty($powerUsage) ? implode(', ', $powerUsage) : null,
        'Other Power Usage' => $record->agricultural_other_power_usage,
        'Roof Space (m2)' => $record->agricultural_roof_space,
        'Ground Space (m2)' => $record->agricultural_ground_space,
        'Consumption (kWh/day)' => $record->agricultural_consumption,
        'Peak Load (kW)' => $record->agricultural_peak_load,
        'Working Hours/day' => $record->agricultural_working_hours,
        'Night Operations' => $record->agricultural_operates_at_night ? 'Yes' : 'No',
        'Night Hours' => $record->agricultural_night_hours,
        'Backup Needed' => $record->agricultural_backup_needed ? 'Yes' : 'No',
        'Backup Percentage (%)' => $record->agricultural_backup_percentage,
    ];
@endphp

<div style="display:grid;gap:1.5rem;max-height:75vh;overflow:auto;padding:0.25rem 0.25rem 0.5rem;">
    <section style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:1.25rem;">
        <h3 style="margin:0 0 1rem;font-size:1.05rem;font-weight:800;color:#0f172a;">General Information</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:0.9rem;">
            @foreach($generalDetails as $label => $value)
                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:0.85rem 0.95rem;">
                    <div style="font-size:0.75rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#64748b;margin-bottom:0.3rem;">{{ $label }}</div>
                    <div style="font-size:0.95rem;color:#0f172a;word-break:break-word;">{{ filled($value) ? $value : '—' }}</div>
                </div>
            @endforeach
        </div>
    </section>

    @if($projectType === 'residential')
        <section style="background:#fff7ed;border:1px solid #fed7aa;border-radius:16px;padding:1.25rem;">
            <h3 style="margin:0 0 1rem;font-size:1.05rem;font-weight:800;color:#9a3412;">Residential Details</h3>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:0.9rem;">
                @foreach($residentialDetails as $label => $value)
                    <div style="background:#fff;border:1px solid #fdba74;border-radius:12px;padding:0.85rem 0.95rem;">
                        <div style="font-size:0.75rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#9a3412;margin-bottom:0.3rem;">{{ $label }}</div>
                        <div style="font-size:0.95rem;color:#431407;word-break:break-word;">{{ filled($value) ? $value : '—' }}</div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if($projectType === 'commercial')
        <section style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:16px;padding:1.25rem;">
            <h3 style="margin:0 0 1rem;font-size:1.05rem;font-weight:800;color:#1d4ed8;">Commercial Details</h3>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:0.9rem;">
                @foreach($commercialDetails as $label => $value)
                    <div style="background:#fff;border:1px solid #93c5fd;border-radius:12px;padding:0.85rem 0.95rem;">
                        <div style="font-size:0.75rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#1d4ed8;margin-bottom:0.3rem;">{{ $label }}</div>
                        <div style="font-size:0.95rem;color:#172554;word-break:break-word;">{{ filled($value) ? $value : '—' }}</div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if($projectType === 'agricultural')
        <section style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:16px;padding:1.25rem;">
            <h3 style="margin:0 0 1rem;font-size:1.05rem;font-weight:800;color:#15803d;">Agricultural Details</h3>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:0.9rem;">
                @foreach($agriculturalDetails as $label => $value)
                    <div style="background:#fff;border:1px solid #86efac;border-radius:12px;padding:0.85rem 0.95rem;">
                        <div style="font-size:0.75rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#15803d;margin-bottom:0.3rem;">{{ $label }}</div>
                        <div style="font-size:0.95rem;color:#14532d;word-break:break-word;">{{ filled($value) ? $value : '—' }}</div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if($projectType === 'utility')
        <section style="background:#f8fafc;border:1px solid #cbd5e1;border-radius:16px;padding:1.25rem;">
            <h3 style="margin:0 0 1rem;font-size:1.05rem;font-weight:800;color:#0f172a;">Utility Project</h3>
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem;">
                <div style="font-size:0.95rem;color:#0f172a;line-height:1.6;">This submission selected <strong>Utility</strong>, which is configured as a direct-contact project type in the public form.</div>
            </div>
        </section>
    @endif
</div>
