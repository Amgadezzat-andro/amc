<form method="post" class="livewire-form-submit">
    @csrf

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="form-group">
        <label for="fullName" class="form-label">
            <h5>
                {{ __('site.FULL_NAME') }}
            </h5>
            <span class="required">*</span>
        </label>
        <input type="text" wire:model.blur="full_name" id="full_name" name="fullName"
            class="form-control @error('full_name') is-invalid @elseif(filled($full_name)) is-valid @enderror"
            placeholder="{{ __('site.ENTER_YOUR_FULL_NAME') }}" >
        @error('full_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="email" class="form-label">
            <h5>
                {{ __('site.EMAIL') }}
            </h5>
            <span class="required">*</span>
        </label>
        <input type="email" id="email" wire:model.blur="email"
            class="form-control @error('email') is-invalid @elseif(filled($email)) is-valid @enderror "
            placeholder="{{ __('site.ENTER_YOUR_EMAIL') }}" >
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div
        class="form-group phone-internation-parent @error('phone') is-invalid @elseif(filled($phone)) is-valid @enderror">
        <input type="hidden" class="phone-internationl-country" wire:model="internation_phone_country">
        <input type="hidden"
            class="phone-internationl-full  form-control @error('phone') is-invalid @elseif(filled($phone)) is-valid @enderror"
            wire:model="phone">
        <div wire:ignore>
            <label class="form-label" for="mobile-number">
                <h5>{{ __('site.PHONE') }} </h5>* </label>

            <input id="mobile-number" placeholder="" type="tel" wire:key="uniqueKey"
                class="phone-internationl form-control @error('phone') is-invalid @elseif(filled($phone)) is-valid @enderror">

        </div>
        @error('phone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="cv" class="form-label">
            <h5>
                {{ __('site.CV') }}
            </h5>
            <span class="required">*</span>
        </label>
        <div class="file-upload-btn">
            <i class="fa-solid fa-arrow-up-from-bracket"></i>
            <span id="cvFileName">{{ __('site.Choose_FILE') }}</span>
            <input wire:model.blur="cv" type="file" id="fileInput" accept=".pdf,.doc,.docx"
                class="file-upload-input  @error('cv') is-invalid @elseif(filled($cv)) is-valid @enderror">
            </div>
            @error('cv')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        @if ($cv)
            <p id="fileName" class="img-preview"> {{ $cv->getClientOriginalName() }} </p>
        @endif
    </div>



    <div class="form-group">
        <label for="availability" class="form-label">
            <h5>{{ __('site.Availability') }}</h5>
            <span class="required">*</span>
        </label>
        <select
            class="form-select form-control select-styled @error('subject_id') is-invalid @elseif(filled($subject_id)) is-valid @enderror"
            id="contact-method" wire:model.blur="subject_id" >
            <option selected> {{ __('site.SELECT_SUBJECT_TYPE') }} </option>
            @foreach ($subjectList as $subject)
                <option value="{{ $subject->id }}">{{ $subject->title }}</option>
            @endforeach
        </select>
        @error('subject_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
{{-- @if ($subjectSlug === 'intern-date') --}}
<div class="form-group {{ $subjectSlug == 'intern-date' ? '' : 'd-none' }}" >
    <label for="specific_date" class="form-label">
        <h5>{{ __('site.AVAL_DATE') }}</h5>
        <span class="required">*</span>
    </label>

    <input
        type="text"
        id="specific_date"
        class="form-control @error('specific_date') is-invalid @elseif(filled($specific_date)) is-valid @enderror"
        placeholder="{{ __('site.AVAL_DATE') }}"
        wire:model.blur="specific_date"
    >

    @error('specific_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
{{-- @endif --}}

    <div class="reference-section">
        <label for="reference" class="form-label">
            <h5 class="reference-title">{{ __('site.Reference') }}</h5>
            {{-- <span class="required">*</span> --}}
        </label>

        <div class="form-group">
            {{-- <label for="referenceName" class="form-label">
                {{ __('site.reference_Name') }}
                <span class="required">*</span>
            </label> --}}
            <input type="text" wire:model.blur="reference_name" id="referenceName"
                class="form-control @error('reference_name') is-invalid @elseif(filled($reference_name)) is-valid @enderror"
                placeholder="{{ __('site.ENTER_YOUR_reference_name') }}" >
            @error('reference_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            {{-- <label for="referencePosition" class="form-label">
                <h5>{{ __('site.reference_Position') }}</h5>
                <span class="required">*</span>
            </label> --}}
            <input type="text" wire:model.blur="reference_position" id="referencePosition"
                class="form-control @error('reference_position') is-invalid @elseif(filled($reference_position)) is-valid @enderror"
                placeholder="{{ __('site.ENTER_YOUR_reference_position') }}" >
            @error('reference_position')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            {{-- <label for="referenceCompany" class="form-label">
                <h5>{{ __('site.reference_Company') }}</h5>
                <span class="required">*</span>
            </label> --}}
            <input type="text" wire:model.blur="reference_company" id="referenceCompany"
                class="form-control @error('reference_company') is-invalid @elseif(filled($reference_company)) is-valid @enderror"
                placeholder="{{ __('site.ENTER_YOUR_reference_company') }}" >
            @error('reference_company')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div
            class="form-group phone-internation-parent @error('reference_phone') is-invalid @elseif(filled($reference_phone)) is-valid @enderror">
            <input type="hidden" class="phone-internationl-country" wire:model="internation_phone_country_2">
            <input type="hidden"
                class="phone-internationl-full  form-control @error('reference_phone') is-invalid @elseif(filled($reference_phone)) is-valid @enderror"
                wire:model="reference_phone">
            <div wire:ignore>
                {{-- <label class="form-label" for="mobile-number-2">
                    <h5>{{ __('site.reference_phone') }}</h5>
                    <span class="required">*</span>
                </label> --}}

                <input id="mobile-number-2" placeholder="" type="tel" wire:key="uniqueKey2"
                    class="phone-internationl-2 form-control @error('reference_phone') is-invalid @elseif(filled($reference_phone)) is-valid @enderror">

            </div>
            @error('reference_phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="school_record" class="form-label">
                <h5>{{ __('site.school_record') }}</h5>
                {{-- <span class="required">*</span> --}}
            </label>
            <div class="file-upload-btn">
                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                <span id="school_recordFileName">{{ __('site.Choose_FILE') }}</span>
                <input wire:model.blur="school_record" type="file" id="fileInput" accept=".pdf,.doc,.docx"
                    class="file-upload-input  @error('school_record') is-invalid @elseif(filled($school_record)) is-valid @enderror">
                @error('school_record')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            @if ($school_record)
                <p id="fileName" class="img-preview"> {{ $school_record->getClientOriginalName() }} </p>
            @endif
        </div>





    </div>


    <div class="form-group">
        <label for="message" class="form-label">
            <h5>{{ __('site.MESSAGE') }}</h5>
        </label>
        <textarea id="message" wire:model.blur="message" class="form-textarea"
            placeholder="{{ __('site.Enter Message') }}">
        </textarea>
        @error('message')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>



    <div class="row mb-3">
        <div class="col-md-12 px-2 mb-4 ">
            <div id="captcha"
                class="mt-4 @error('captcha') is-invalid @elseif(filled($captcha)) is-valid @enderror"
                wire:ignore>
            </div>
            @error('captcha')
                <div class="captcha invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="main-btn">{{ __('site.SEND') }}</button>
    </div>


</form>



@push('js')
    <script type="text/javascript" src="{{ asset('/js/intlTelInputWithUtils.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('/js/custom_intl_phone.js') }}"></script>

    <script src="https://www.google.com/recaptcha/api.js?onload=handle&render=explicit" async defer
></script>

    <script>
        function handle() {

            scrollToErrorOrSuccess();

            widget = grecaptcha.render('captcha', {
                'sitekey': '{{ setting('general.google_recaptcha_site_key') }}',
                'theme': 'light', // you could switch between dark and light mode.
                'callback': verify
            });

        }
        var verify = function(response) {
            @this.set('captcha', response)
        }

        $(document).ready(function() {

            $(document).ready(function() {
                $(document).on('submit', '.livewire-form-submit', function(e) {
                    e.preventDefault();

                    $(".phone-internationl").blur();
                    $(".phone-internationl-2").blur();
                    // Call the Livewire method
                    @this.call('submit').then(function() {
                        handle();
                    });

                });
            });

        });


        $(document).on("change", ".date-input", function() {
            if ($(this).val().split("-")[0].length > 4) {
                $(this).val(null);
                $(this).blur();
                $(this).focus();
            }
        });
        flatpickr("#specific_date", {
        dateFormat: "Y-m-d",
        minDate: "today",
        onChange: function (selectedDates, dateStr) {
            @this.set('specific_date', dateStr);
        }
    });
    </script>
@endpush
