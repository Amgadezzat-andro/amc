<form method="post" action="#" class="contact-form-inner" style="max-width:460px;" wire:submit.prevent="submit">
    @csrf
    @if (Session::has('success'))
        <div class="form-success-toast" role="status" aria-live="polite">
            <div class="form-success-toast__icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="form-success-toast__content">
                <p class="form-success-toast__eyebrow">Submission received</p>
                <p class="form-success-toast__message">{{ Session::get('success') }}</p>
            </div>
            <button type="button" class="form-success-toast__close" onclick="this.closest('.form-success-toast').remove()" aria-label="Dismiss success message">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6 mb-6">
        <div>
            <label class="form-label">{{ __('site.first_name') }} <span class="text-red-500">*</span></label>
            <input type="text" wire:model.blur="first_name" class="contact-input @error('first_name') border-red-500 @enderror" placeholder="{{ __('site.ENTER_YOUR_FIRST_NAME') }}">
            @error('first_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="form-label">{{ __('site.LAST_NAME') }} <span class="text-red-500">*</span></label>
            <input type="text" wire:model.blur="last_name" class="contact-input @error('last_name') border-red-500 @enderror" placeholder="{{ __('site.ENTER_YOUR_LAST_NAME') }}">
            @error('last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mb-6">
        <label class="form-label">{{ __('Company') }}</label>
        <input type="text" wire:model.blur="company" class="contact-input @error('company') border-red-500 @enderror" placeholder="{{ __('Your company') }}">
        @error('company') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-6">
        <label class="form-label">{{ __('site.EMAIL') }} <span class="text-red-500">*</span></label>
        <input type="email" wire:model.blur="email" class="contact-input @error('email') border-red-500 @enderror" placeholder="{{ __('site.ENTER_YOUR_EMAIL') }}">
        @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-6 @error('phone') is-invalid @enderror">
        <label class="form-label">{{ __('site.PHONE') }} <span class="text-red-500">*</span></label>
        <input type="tel" wire:model.blur="phone" class="contact-input" placeholder="+255 700 000 000">
        @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    @if(!empty($subjectList))
    <div class="mb-6">
        <label class="form-label">{{ __('Subject') }}</label>
        <select wire:model.blur="subject_id" class="contact-input @error('subject_id') border-red-500 @enderror">
            <option value="">{{ __('Select a subject') }}</option>
            @foreach($subjectList as $id => $title)
                <option value="{{ $id }}">{{ $title }}</option>
            @endforeach
        </select>
        @error('subject_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>
    @endif

    <div class="mb-8">
        <label class="form-label">{{ __('site.MESSAGE') }}</label>
        <textarea wire:model.blur="message" rows="4" class="contact-input resize-none @error('message') border-red-500 @enderror" placeholder="{{ __('site.Enter Message') }}"></textarea>
        @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-6" wire:ignore>
        <div id="contact-captcha" class="@error('captcha') is-invalid @enderror"></div>
        @error('captcha') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="btn-contact" style="background:var(--contact-orange,#f97316);color:#fff;border:none;padding:0.85rem 2.6rem;font-weight:700;font-size:0.9rem;text-transform:uppercase;cursor:pointer;border-radius:0;">
        <span>{{ __('site.SEND') }}</span>
        <i class="fas fa-arrow-right text-sm ms-2"></i>
    </button>
</form>

