<form class="application-form" wire:submit.prevent="submit" enctype="multipart/form-data">
    <x-common.form-success-flush :message="Session::get('success')" />

    <h2 class="form-title">Application Form</h2>

    <div class="form-row">
        <div class="form-group">
            <label class="form-label" for="career-name">Name<span class="required">*</span></label>
            <input id="career-name" type="text" wire:model.blur="name" class="form-input @error('name') border-red-500 @enderror" required>
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="career-surname">Surname<span class="required">*</span></label>
            <input id="career-surname" type="text" wire:model.blur="surname" class="form-input @error('surname') border-red-500 @enderror" required>
            @error('surname') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="career-email">E-mail<span class="required">*</span></label>
            <input id="career-email" type="email" wire:model.blur="email" class="form-input @error('email') border-red-500 @enderror" required>
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="career-phone">Phone Number<span class="required">*</span></label>
            <input id="career-phone" type="tel" wire:model.blur="phone" class="form-input @error('phone') border-red-500 @enderror" placeholder="+961 70 123 456" required>
            @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="form-label" for="career-cv">Submit your CV<span class="required">*</span> (mandatory field)</label>
        <div class="file-upload-wrapper">
            <input id="career-cv" type="file" wire:model="cv" class="file-upload-input" accept=".pdf,.doc,.docx" required>
            <label for="career-cv" class="file-upload-label">
                <span class="file-upload-text">{{ $cv ? $cv->getClientOriginalName() : 'Choose file or drag it here' }}</span>
                <i class="fas fa-upload"></i>
            </label>
        </div>
        <p class="form-note">Accepted formats: PDF, DOC, DOCX</p>
        @error('cv') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="career-cover-letter">Submit a Cover letter (optional)</label>
        <div class="file-upload-wrapper">
            <input id="career-cover-letter" type="file" wire:model="cover_letter" class="file-upload-input" accept=".pdf,.doc,.docx">
            <label for="career-cover-letter" class="file-upload-label">
                <span class="file-upload-text">{{ $cover_letter ? $cover_letter->getClientOriginalName() : 'Choose file or drag it here' }}</span>
                <i class="fas fa-upload"></i>
            </label>
        </div>
        <p class="form-note">Accepted formats: PDF, DOC, DOCX</p>
        @error('cover_letter') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="career-position">Position<span class="required">*</span></label>
        <select id="career-position" wire:model.blur="position_id" class="form-input @error('position_id') border-red-500 @enderror" required>
            <option value="">Select a position</option>
            @foreach($positionList as $id => $title)
                <option value="{{ $id }}">{{ $title }}</option>
            @endforeach
        </select>
        @error('position_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="career-message">Your Message (optional)</label>
        <textarea id="career-message" wire:model.blur="message" class="form-textarea" placeholder="Tell us why you're interested in this position..."></textarea>
        @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <p class="form-note" style="margin-top:24px; margin-bottom:0;">
        <span class="required">*</span> Mandatory Fields, application cannot be submitted without them
    </p>

    <button type="submit" class="form-submit-btn">Submit Application</button>
</form>
