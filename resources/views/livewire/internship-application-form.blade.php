<form class="application-form" wire:submit.prevent="submit" enctype="multipart/form-data">
    <x-common.form-success-flush :message="Session::get('success')" />

    <h2 class="form-title">Internship Application Form</h2>

    <div class="form-row">
        <div class="form-group">
            <label class="form-label" for="intern-name">Name<span class="required">*</span></label>
            <input id="intern-name" type="text" wire:model.blur="name" class="form-input @error('name') border-red-500 @enderror" required>
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="intern-surname">Surname<span class="required">*</span></label>
            <input id="intern-surname" type="text" wire:model.blur="surname" class="form-input @error('surname') border-red-500 @enderror" required>
            @error('surname') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="intern-email">E-mail<span class="required">*</span></label>
            <input id="intern-email" type="email" wire:model.blur="email" class="form-input @error('email') border-red-500 @enderror" required>
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="intern-phone">Phone Number<span class="required">*</span></label>
            <input id="intern-phone" type="tel" wire:model.blur="phone" class="form-input @error('phone') border-red-500 @enderror" required>
            @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="intern-dob">Date of Birth<span class="required">*</span></label>
            <input id="intern-dob" type="date" wire:model.blur="date_of_birth" class="form-input @error('date_of_birth') border-red-500 @enderror" required>
            @error('date_of_birth') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row-2">
        <div class="form-group">
            <label class="form-label" for="intern-address">Address<span class="required">*</span></label>
            <input id="intern-address" type="text" wire:model.blur="address" class="form-input @error('address') border-red-500 @enderror" required>
            @error('address') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="intern-university">University<span class="required">*</span></label>
            <input id="intern-university" type="text" wire:model.blur="university" class="form-input @error('university') border-red-500 @enderror" required>
            @error('university') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="intern-major">Major<span class="required">*</span></label>
            <input id="intern-major" type="text" wire:model.blur="major" class="form-input @error('major') border-red-500 @enderror" required>
            @error('major') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="intern-level">Level of Studies<span class="required">*</span></label>
            <select id="intern-level" wire:model.blur="level_of_studies" class="form-select @error('level_of_studies') border-red-500 @enderror" required>
                <option value="">Select Level</option>
                @foreach($levelOptions as $level)
                    <option value="{{ $level }}">{{ $level }}</option>
                @endforeach
            </select>
            @error('level_of_studies') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="intern-availability">Date of Availability</label>
            <input id="intern-availability" type="date" wire:model.blur="date_of_availability" class="form-input @error('date_of_availability') border-red-500 @enderror">
            @error('date_of_availability') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="form-label" for="intern-cv">Submit your CV<span class="required">*</span> (mandatory field)</label>
        <div class="file-upload-wrapper">
            <input id="intern-cv" type="file" wire:model="cv" class="file-upload-input" accept=".pdf,.doc,.docx" required>
            <label for="intern-cv" class="file-upload-label">
                <span class="file-upload-text">{{ $cv ? $cv->getClientOriginalName() : 'Choose file or drag it here' }}</span>
                <i class="fas fa-upload"></i>
            </label>
        </div>
        <p class="form-note">Accepted formats: PDF, DOC, DOCX</p>
        @error('cv') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="intern-cover-letter">Submit a Cover letter (optional)</label>
        <div class="file-upload-wrapper">
            <input id="intern-cover-letter" type="file" wire:model="cover_letter" class="file-upload-input" accept=".pdf,.doc,.docx">
            <label for="intern-cover-letter" class="file-upload-label">
                <span class="file-upload-text">{{ $cover_letter ? $cover_letter->getClientOriginalName() : 'Choose file or drag it here' }}</span>
                <i class="fas fa-upload"></i>
            </label>
        </div>
        <p class="form-note">Accepted formats: PDF, DOC, DOCX</p>
        @error('cover_letter') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="intern-message">Your Message (optional)</label>
        <textarea id="intern-message" wire:model.blur="message" class="form-textarea" placeholder="Tell us why you're interested in our internship program..."></textarea>
        @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <p class="form-note" style="margin-top:24px; margin-bottom:0;">
        <span class="required">*</span> Mandatory Fields, application cannot be submitted without them
    </p>

    <button type="submit" class="form-submit-btn">Submit Application</button>
</form>
