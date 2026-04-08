<form method="post" action="#" class="quote-form-inner" wire:submit.prevent="submit">
    @csrf

    @if (Session::has('success'))
        <div class="form-success-toast" role="status" aria-live="polite">
            <div class="form-success-toast__icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="form-success-toast__content">
                <p class="form-success-toast__eyebrow">Assessment submitted</p>
                <p class="form-success-toast__message">{{ Session::get('success') }}</p>
            </div>
            <button type="button" class="form-success-toast__close" onclick="this.closest('.form-success-toast').remove()" aria-label="Dismiss success message">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="form-label">Full Name <span class="text-red-500">*</span></label>
            <input type="text" wire:model.blur="full_name" class="quote-input @error('full_name') border-red-500 @enderror" placeholder="John Doe">
            @error('full_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="form-label">Email <span class="text-red-500">*</span></label>
            <input type="email" wire:model.blur="email" class="quote-input @error('email') border-red-500 @enderror" placeholder="john@example.com">
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="form-label">Phone <span class="text-red-500">*</span></label>
            <input type="tel" wire:model.blur="phone" class="quote-input @error('phone') border-red-500 @enderror" placeholder="+255 700 000 000">
            @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="form-label">Site Location <span class="text-red-500">*</span></label>
            <input type="text" wire:model.blur="site_location" class="quote-input @error('site_location') border-red-500 @enderror" placeholder="Site address">
            @error('site_location') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="form-label">Power Source <span class="text-red-500">*</span></label>
            <select wire:model.live="power_source" class="quote-input @error('power_source') border-red-500 @enderror">
                <option value="">Select power source</option>
                @foreach($powerSourceOptions as $option)
                    <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                @endforeach
            </select>
            @error('power_source') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            @if($power_source === 'other')
                <label class="form-label">Specify Other Power Source <span class="text-red-500">*</span></label>
                <input type="text" wire:model.blur="other_power_source" class="quote-input @error('other_power_source') border-red-500 @enderror" placeholder="Please specify">
                @error('other_power_source') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            @endif
        </div>
    </div>

    @php
        $projectIcons = [
            'residential' => 'fas fa-home',
            'commercial' => 'fas fa-building',
            'agricultural' => 'fas fa-tractor',
            'utility' => 'fas fa-industry',
        ];
        $utilityPhone = setting('site.phone') ?: '+255-746-022022';
    @endphp

    <div class="mb-8">
        <label class="form-label">Project Type <span class="text-red-500">*</span></label>
        <div class="project-type-grid">
            @foreach($projectTypeOptions as $option)
                <label class="project-card {{ $project_type === $option ? 'active' : '' }}">
                    <input type="radio" wire:model.live="project_type" value="{{ $option }}" class="hidden">
                    <span class="project-card-icon"><i class="{{ $projectIcons[$option] ?? 'fas fa-bolt' }}"></i></span>
                    <span>{{ ucfirst($option) }}</span>
                </label>
            @endforeach
        </div>
        @error('project_type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    @if($project_type === 'residential')
        <div class="section-box">
            <h4 class="section-title">Residential Details</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Roof Space (m2) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" wire:model.blur="residential_roof_space" class="quote-input @error('residential_roof_space') border-red-500 @enderror">
                    @error('residential_roof_space') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Ground Space (m2) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" wire:model.blur="residential_ground_space" class="quote-input @error('residential_ground_space') border-red-500 @enderror">
                    @error('residential_ground_space') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Consumption (kWh/day) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" wire:model.blur="residential_current_consumption" class="quote-input @error('residential_current_consumption') border-red-500 @enderror">
                    @error('residential_current_consumption') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Peak Load (kW) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" wire:model.blur="residential_peak_load" class="quote-input @error('residential_peak_load') border-red-500 @enderror">
                    @error('residential_peak_load') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6">
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <input type="checkbox" wire:model.live="residential_backup_needed">
                    Backup Needed?
                </label>
            </div>

            @if($residential_backup_needed)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div>
                        <label class="form-label">Backup Duration (hours) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.5" min="0" wire:model.blur="residential_backup_duration" class="quote-input @error('residential_backup_duration') border-red-500 @enderror">
                        @error('residential_backup_duration') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="form-label">Backup Percentage (%) <span class="text-red-500">*</span></label>
                        <input type="number" step="1" min="0" max="100" wire:model.blur="residential_backup_percentage" class="quote-input @error('residential_backup_percentage') border-red-500 @enderror">
                        @error('residential_backup_percentage') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif
        </div>
    @endif

    @if($project_type === 'commercial')
        <div class="section-box">
            <h4 class="section-title">Commercial Details</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Business Name <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.blur="commercial_business_name" class="quote-input @error('commercial_business_name') border-red-500 @enderror">
                    @error('commercial_business_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Business Type <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.blur="commercial_business_type" class="quote-input @error('commercial_business_type') border-red-500 @enderror">
                    @error('commercial_business_type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Roof Space (m2) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" wire:model.blur="commercial_roof_space" class="quote-input @error('commercial_roof_space') border-red-500 @enderror">
                    @error('commercial_roof_space') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Ground Space (m2) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" wire:model.blur="commercial_ground_space" class="quote-input @error('commercial_ground_space') border-red-500 @enderror">
                    @error('commercial_ground_space') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Consumption (kWh/day) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" wire:model.blur="commercial_consumption" class="quote-input @error('commercial_consumption') border-red-500 @enderror">
                    @error('commercial_consumption') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Peak Load (kW) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" wire:model.blur="commercial_peak_load" class="quote-input @error('commercial_peak_load') border-red-500 @enderror">
                    @error('commercial_peak_load') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Working Hours/day <span class="text-red-500">*</span></label>
                    <input type="number" step="0.5" min="0" max="24" wire:model.blur="commercial_working_hours" class="quote-input @error('commercial_working_hours') border-red-500 @enderror">
                    @error('commercial_working_hours') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <input type="checkbox" wire:model.live="commercial_operates_at_night">
                    Night Operations?
                </label>
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <input type="checkbox" wire:model.live="commercial_backup_needed">
                    Backup Needed?
                </label>
            </div>

            @if($commercial_operates_at_night)
                <div class="mt-4">
                    <label class="form-label">Night Hours <span class="text-red-500">*</span></label>
                    <input type="number" step="0.5" min="0" max="24" wire:model.blur="commercial_night_hours" class="quote-input @error('commercial_night_hours') border-red-500 @enderror">
                    @error('commercial_night_hours') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            @endif

            @if($commercial_backup_needed)
                <div class="mt-4">
                    <label class="form-label">Backup Percentage (%) <span class="text-red-500">*</span></label>
                    <input type="number" step="1" min="0" max="100" wire:model.blur="commercial_backup_percentage" class="quote-input @error('commercial_backup_percentage') border-red-500 @enderror">
                    @error('commercial_backup_percentage') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            @endif
        </div>
    @endif

    @if($project_type === 'agricultural')
        <div class="section-box">
            <h4 class="section-title">Agricultural Details</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Farm Name <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.blur="agricultural_farm_name" class="quote-input @error('agricultural_farm_name') border-red-500 @enderror">
                    @error('agricultural_farm_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Activity Type <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.blur="agricultural_activity_type" class="quote-input @error('agricultural_activity_type') border-red-500 @enderror">
                    @error('agricultural_activity_type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6">
                <label class="form-label">Power Usage <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach($agriculturalPowerUsageOptions as $option)
                        <label class="checkbox-card">
                            <input type="checkbox" wire:model.live="agricultural_power_usage" value="{{ $option }}">
                            <span>{{ ucfirst(str_replace('-', ' ', $option)) }}</span>
                        </label>
                    @endforeach
                </div>
                @error('agricultural_power_usage') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            @if(in_array('other', $agricultural_power_usage, true))
                <div class="mt-4">
                    <label class="form-label">Specify Other Power Usage <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.blur="agricultural_other_power_usage" class="quote-input @error('agricultural_other_power_usage') border-red-500 @enderror">
                    @error('agricultural_other_power_usage') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="form-label">Roof Space (m2) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" wire:model.blur="agricultural_roof_space" class="quote-input @error('agricultural_roof_space') border-red-500 @enderror">
                    @error('agricultural_roof_space') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Ground Space (m2) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" wire:model.blur="agricultural_ground_space" class="quote-input @error('agricultural_ground_space') border-red-500 @enderror">
                    @error('agricultural_ground_space') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Consumption (kWh/day) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" wire:model.blur="agricultural_consumption" class="quote-input @error('agricultural_consumption') border-red-500 @enderror">
                    @error('agricultural_consumption') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Peak Load (kW) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" wire:model.blur="agricultural_peak_load" class="quote-input @error('agricultural_peak_load') border-red-500 @enderror">
                    @error('agricultural_peak_load') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Working Hours/day <span class="text-red-500">*</span></label>
                    <input type="number" step="0.5" min="0" max="24" wire:model.blur="agricultural_working_hours" class="quote-input @error('agricultural_working_hours') border-red-500 @enderror">
                    @error('agricultural_working_hours') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <input type="checkbox" wire:model.live="agricultural_operates_at_night">
                    Night Operations?
                </label>
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <input type="checkbox" wire:model.live="agricultural_backup_needed">
                    Backup Needed?
                </label>
            </div>

            @if($agricultural_operates_at_night)
                <div class="mt-4">
                    <label class="form-label">Night Hours <span class="text-red-500">*</span></label>
                    <input type="number" step="0.5" min="0" max="24" wire:model.blur="agricultural_night_hours" class="quote-input @error('agricultural_night_hours') border-red-500 @enderror">
                    @error('agricultural_night_hours') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            @endif

            @if($agricultural_backup_needed)
                <div class="mt-4">
                    <label class="form-label">Backup Percentage (%) <span class="text-red-500">*</span></label>
                    <input type="number" step="1" min="0" max="100" wire:model.blur="agricultural_backup_percentage" class="quote-input @error('agricultural_backup_percentage') border-red-500 @enderror">
                    @error('agricultural_backup_percentage') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            @endif
        </div>
    @endif

    @if($project_type === 'utility')
        <div class="section-box">
            <h4 class="section-title">Utility Details</h4>
            <div class="utility-call-box">
                <div class="utility-call-icon"><i class="fas fa-phone"></i></div>
                <p class="utility-call-text">For utility-scale projects, please contact us directly</p>
                <a href="tel:{{ preg_replace('/\s+/', '', $utilityPhone) }}" class="utility-call-link">{{ $utilityPhone }}</a>
            </div>
        </div>
    @endif

    <div class="mb-6 mt-8" wire:ignore>
        <div id="contact-captcha" class="@error('captcha') is-invalid @enderror"></div>
        @error('captcha') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="btn-quote-submit">
        <span>Submit Assessment</span>
        <i class="fas fa-arrow-right text-sm ms-2"></i>
    </button>
</form>
