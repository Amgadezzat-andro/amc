<form wire:submit.prevent="submit">
    @csrf
    <x-common.form-success-flush :message="Session::get('success')" />

    <div class="form-row">
        <div class="form-group">
            <label class="form-label">First Name <span class="required">*</span></label>
            <input type="text" wire:model.blur="first_name" class="form-input @error('first_name') border-red-500 @enderror" placeholder="Enter your first name">
            @error('first_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label class="form-label">Last Name <span class="required">*</span></label>
            <input type="text" wire:model.blur="last_name" class="form-input @error('last_name') border-red-500 @enderror" placeholder="Enter your last name">
            @error('last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label class="form-label">Company</label>
            <input type="text" wire:model.blur="company" class="form-input @error('company') border-red-500 @enderror" placeholder="Your company">
            @error('company') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label class="form-label">Position <span class="required">*</span></label>
            <input type="text" wire:model.blur="position" class="form-input @error('position') border-red-500 @enderror" placeholder="Your position">
            @error('position') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label class="form-label">Email <span class="required">*</span></label>
            <input type="email" wire:model.blur="email" class="form-input @error('email') border-red-500 @enderror" placeholder="Enter your email">
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="form-group @error('phone') is-invalid @enderror">
            <label class="form-label">Phone <span class="required">*</span></label>
            <input type="tel" wire:model.blur="phone" class="form-input" placeholder="+961 70 123 456">
            @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Location <span class="required">*</span></label>
        <input type="text" wire:model.blur="location" class="form-input @error('location') border-red-500 @enderror" placeholder="Your location">
        @error('location') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label class="form-label">Message <span class="required">*</span></label>
        <textarea wire:model.blur="message" rows="5" class="form-textarea @error('message') border-red-500 @enderror" placeholder="Enter message"></textarea>
        @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="form-group" wire:ignore>
        <div id="contact-captcha" class="@error('captcha') is-invalid @enderror"></div>
        @error('captcha') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="form-submit-btn">Send Message</button>
</form>

