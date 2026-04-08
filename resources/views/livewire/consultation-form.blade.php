<form wire:submit.prevent="submit">
    <x-common.form-success-flush :message="Session::get('success')" />

    <div class="consultation-form-row">
        <div class="consultation-form-group">
            <label class="consultation-form-label" for="consultationFirstName">First Name<span class="required">*</span></label>
            <input type="text" id="consultationFirstName" wire:model.blur="first_name" class="consultation-form-input @error('first_name') border-red-500 @enderror" required>
            @error('first_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="consultation-form-group">
            <label class="consultation-form-label" for="consultationLastName">Last Name<span class="required">*</span></label>
            <input type="text" id="consultationLastName" wire:model.blur="last_name" class="consultation-form-input @error('last_name') border-red-500 @enderror" required>
            @error('last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="consultation-form-row">
        <div class="consultation-form-group">
            <label class="consultation-form-label" for="consultationCompany">Company</label>
            <input type="text" id="consultationCompany" wire:model.blur="company" class="consultation-form-input @error('company') border-red-500 @enderror">
            @error('company') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="consultation-form-group">
            <label class="consultation-form-label" for="consultationPosition">Position<span class="required">*</span></label>
            <input type="text" id="consultationPosition" wire:model.blur="position" class="consultation-form-input @error('position') border-red-500 @enderror" required>
            @error('position') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="consultation-form-row">
        <div class="consultation-form-group">
            <label class="consultation-form-label" for="consultationEmail">Email<span class="required">*</span></label>
            <input type="email" id="consultationEmail" wire:model.blur="email" class="consultation-form-input @error('email') border-red-500 @enderror" required>
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="consultation-form-group">
            <label class="consultation-form-label" for="consultationPhone">Phone<span class="required">*</span></label>
            <input type="tel" id="consultationPhone" wire:model.blur="phone" class="consultation-form-input @error('phone') border-red-500 @enderror" required>
            @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="consultation-form-group">
        <label class="consultation-form-label" for="consultationLocation">Location<span class="required">*</span></label>
        <input type="text" id="consultationLocation" wire:model.blur="location" class="consultation-form-input @error('location') border-red-500 @enderror" required>
        @error('location') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="consultation-form-group">
        <label class="consultation-form-label" for="consultationMessage">Message<span class="required">*</span></label>
        <textarea id="consultationMessage" wire:model.blur="message" class="consultation-form-textarea @error('message') border-red-500 @enderror" required></textarea>
        @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="consultation-form-group" wire:ignore>
        <div id="contact-captcha" class="@error('captcha') is-invalid @enderror"></div>
        @error('captcha') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="consultation-form-submit-btn">Submit Consultation Request</button>
</form>
