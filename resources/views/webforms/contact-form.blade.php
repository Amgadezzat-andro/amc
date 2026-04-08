<x-layouts.layout seoTitle="{{ __('site.CONTACT_US') }}" layoutView="main-inner">

    @push('css')
        <style>
            :root { --contact-orange: #f97316; --contact-orange-dk: #ea6a00; --contact-text-dark: #1a1a1a; --contact-text-mid: #555; --contact-border: #e5e7eb; }
            .contact-hero { display: flex; position: relative; min-height: auto; }
            .hero-left { flex: 1; background: #fff; padding: 3rem 5% 4rem; position: relative; }
            .hero-right { width: 46%; background: linear-gradient(155deg, #003d5c 0%, #0d9488 100%); padding: 3rem 5% 4rem; position: relative; overflow: hidden; }
            .hero-right::before { content: ''; position: absolute; inset: 0; background-image: radial-gradient(circle, rgba(255,255,255,.07) 1px, transparent 1px); background-size: 32px 32px; pointer-events: none; }
            .contact-title { font-size: clamp(1.8rem, 3vw, 2.8rem); font-weight: 800; color: var(--contact-text-dark); line-height: 1.15; margin-bottom: 0.5rem; }
            .contact-title span { color: var(--contact-orange); }
            .orange-bar { width: 52px; height: 3px; background: var(--contact-orange); border-radius: 2px; margin: 1rem 0 1.5rem; }
            .contact-subtitle { color: var(--contact-text-mid); font-size: 1rem; max-width: 420px; line-height: 1.7; margin-bottom: 2rem; }
            .contact-input { width: 100%; background: transparent; border: none; border-bottom: 1.5px solid var(--contact-border); padding: 0.7rem 0; font-size: 0.95rem; outline: none; border-radius: 0; }
            .contact-input:focus { border-bottom-color: var(--contact-orange); border-bottom-width: 2px; }
            .form-label { display: block; font-size: 0.78rem; font-weight: 600; color: var(--contact-text-mid); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.3rem; }
            .info-heading { font-size: 1.6rem; font-weight: 800; color: #fff; margin-bottom: 0.4rem; }
            .info-bar { width: 40px; height: 3px; background: linear-gradient(90deg, rgba(255,255,255,.8), rgba(255,255,255,.4)); border-radius: 2px; margin-bottom: 1.5rem; }
            .info-row { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.5rem; }
            .info-icon-circle { width: 48px; height: 48px; min-width: 48px; border-radius: 50%; border: 2px solid rgba(255,255,255,.7); display: flex; align-items: center; justify-content: center; color: #fff; background: rgba(255,255,255,.05); }
            .info-row-text p, .info-row-text a, .info-row-text span { color: rgba(255,255,255,.92); font-size: 0.95rem; line-height: 1.6; }
            .info-row-text a { text-decoration: none; }
            .info-row-text a:hover { color: #fff; text-decoration: underline; }
            .info-row-label { color: rgba(255,255,255,.65); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.25rem; }
            .social-label { color: rgba(255,255,255,.75); font-size: 0.82rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.75rem; }
            .social-link { width: 44px; height: 44px; border-radius: 50%; border: 2px solid rgba(255,255,255,.6); display: inline-flex; align-items: center; justify-content: center; color: #fff; margin-right: 0.5rem; text-decoration: none; transition: all 0.3s; }
            .social-link:hover { background: rgba(255,255,255,.25); border-color: #fff; }
            .map-wrapper { overflow: hidden; border-top: 4px solid var(--contact-orange); }
            .map-wrapper iframe { display: block; border: 0; }
            .form-success-toast { position: fixed; top: 5.5rem; right: 1.5rem; z-index: 80; width: min(420px, calc(100vw - 2rem)); display: flex; align-items: flex-start; gap: 1rem; padding: 1rem 1.1rem; border-radius: 18px; background: rgba(255,255,255,0.96); border: 1px solid rgba(13,148,136,0.18); box-shadow: 0 22px 55px rgba(15,23,42,0.18); backdrop-filter: blur(12px); animation: successToastIn .35s ease, successToastOut .35s ease 5.15s forwards; }
            .form-success-toast__icon { width: 46px; height: 46px; min-width: 46px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: linear-gradient(145deg, #10b981, #0d9488); color: #fff; box-shadow: 0 10px 24px rgba(13,148,136,0.28); }
            .form-success-toast__content { flex: 1; }
            .form-success-toast__eyebrow { margin: 0 0 0.2rem; color: #0f766e; font-size: 0.78rem; font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase; }
            .form-success-toast__message { margin: 0; color: var(--contact-text-dark); font-size: 0.96rem; line-height: 1.55; }
            .form-success-toast__close { border: none; background: transparent; color: #64748b; padding: 0.15rem; line-height: 1; }
            .form-success-toast__close:hover { color: #0f172a; }
            @keyframes successToastIn { from { opacity: 0; transform: translate3d(0, -12px, 0) scale(0.98); } to { opacity: 1; transform: translate3d(0, 0, 0) scale(1); } }
            @keyframes successToastOut { from { opacity: 1; transform: translate3d(0, 0, 0) scale(1); } to { opacity: 0; transform: translate3d(0, -10px, 0) scale(0.98); pointer-events: none; } }
            @media (max-width: 1023px) { .form-success-toast { top: 5rem; right: 1rem; left: 1rem; width: auto; } }
            @media (max-width: 1023px) { .contact-hero { flex-direction: column; } .hero-right { width: 100%; } }
        </style>
    @endpush

    @section('content')
        @php $path = '/contact-us'; @endphp
        <x-common.header-image :innerItem="null" :getFromSpacificLink="$path" />

        <section class="contact-hero">
            <div class="hero-left">
                <h2 class="contact-title">{{ __('site.Contact Us') }} <span>.</span></h2>
                <div class="orange-bar"></div>
                <p class="contact-subtitle">{{ __('site.GET_IN_TOUCH') }}</p>
                <livewire:contact-us-form :subjectList="$subjectList ?? []" />
            </div>
            <div class="hero-right" style="position:relative;z-index:1;">
                <h2 class="info-heading">{{ __('Info') }}</h2>
                <div class="info-bar"></div>
                @php $ci = $contactInfo ?? []; @endphp
                @if(!empty($ci['phone']))
                <div class="info-row">
                    <div class="info-icon-circle"><i class="fas fa-phone-alt"></i></div>
                    <div class="info-row-text">
                        <p class="info-row-label">{{ __('Call Us') }}</p>
                        <a href="tel:{{ preg_replace('/\s+/', '', $ci['phone']) }}">{{ $ci['phone'] }}</a>
                    </div>
                </div>
                @endif
                @if(!empty($ci['email']))
                <div class="info-row">
                    <div class="info-icon-circle"><i class="fas fa-envelope"></i></div>
                    <div class="info-row-text">
                        <p class="info-row-label">{{ __('Write Us') }}</p>
                        <a href="mailto:{{ $ci['email'] }}">{{ $ci['email'] }}</a>
                    </div>
                </div>
                @endif
                @if(!empty($ci['address']) || !empty($locationTitle2))
                <div class="info-row">
                    <div class="info-icon-circle"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="info-row-text">
                        <p class="info-row-label">{{ __('Visit Us') }}</p>
                        <p>{{ $ci['address'] ?? $locationTitle2 ?? '' }}</p>
                    </div>
                </div>
                @endif
                @if(!empty($ci['business_hours']))
                <div class="info-row">
                    <div class="info-icon-circle"><i class="fas fa-clock"></i></div>
                    <div class="info-row-text">
                        <p class="info-row-label">{{ __('Business Hours') }}</p>
                        <p>{!! nl2br(e($ci['business_hours'])) !!}</p>
                    </div>
                </div>
                @endif
                @if(!empty($ci['linkedin_url']) || !empty($ci['instagram_url']) || !empty($ci['facebook_url']) || !empty($ci['youtube_url']))
                <div style="margin-top:1rem;">
                    <p class="social-label">{{ __('Connect with us') }}</p>
                    @if(!empty($ci['linkedin_url']))<a href="{{ $ci['linkedin_url'] }}" target="_blank" rel="noopener" class="social-link"><i class="fab fa-linkedin-in"></i></a>@endif
                    @if(!empty($ci['instagram_url']))<a href="{{ $ci['instagram_url'] }}" target="_blank" rel="noopener" class="social-link"><i class="fab fa-instagram"></i></a>@endif
                    @if(!empty($ci['facebook_url']))<a href="{{ $ci['facebook_url'] }}" target="_blank" rel="noopener" class="social-link"><i class="fab fa-facebook-f"></i></a>@endif
                    @if(!empty($ci['youtube_url']))<a href="{{ $ci['youtube_url'] }}" target="_blank" rel="noopener" class="social-link"><i class="fab fa-youtube"></i></a>@endif
                </div>
                @endif
            </div>
        </section>

        @if(!empty($locationCoordinate) && $locationCoordinate !== '#')
        <section class="w-full">
            <div class="map-wrapper">
                <iframe src="https://maps.google.com/maps?q={{ urlencode($locationCoordinate) }}&z=14&output=embed" width="100%" height="420" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="Location"></iframe>
            </div>
        </section>
        @endif
    @endsection
</x-layouts.layout>
