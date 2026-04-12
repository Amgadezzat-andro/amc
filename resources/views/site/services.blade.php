<x-layouts.layout seoTitle="{{ __('Services') ?? 'Services' }}" layoutView="main-inner">

@section('content')
@php
    $overview = $servicesHeader ?? null;
    $industries = $servicesIndustries ?? null;
    $tabs = $serviceTabs ?? [];
    $connectBanner = $servicesConnectBanner ?? null;
    $heroImg = $overview ? ($overview->mainImage?->url ?? $overview->mainImage?->getUrl()) : null;
    $overviewTitle = $overview?->title ?? 'Our Services';
    $overviewBrief = $overview?->brief ?? 'Comprehensive Audit, Tax, and Financial Advisory Solutions';
    $overviewSecondTitle = $overview?->second_title ?? 'Overview';
    $overviewContent = $overview?->content ?? '';
    $overviewBodyHtml = preg_replace('/^\s*<p[^>]*>.*?<\/p>\s*<p[^>]*>.*?<\/p>\s*/is', '', $overviewContent) ?: $overviewContent;
    $industriesImg = $industries ? ($industries->mainImage?->url ?? $industries->mainImage?->getUrl()) : null;
    $industriesTitle = $industries?->title ?? 'Industries';
    $industriesContent = $industries?->content ?? '';
    $industriesDescription = $industries?->brief ?? 'Tailored Solutions for Every Sector';
    $overviewLocations = 'Lebanon, UAE, Iraq, Germany, UK, France, Monaco, Congo, Tunisia';

    $tabMeta = [
        'company-setup' => ['icon' => 'fas fa-building', 'label' => 'Company Setup<br><small>Lebanon & UAE</small>'],
        'audit' => ['icon' => 'fas fa-clipboard-check', 'label' => 'Audit &<br>Assurance'],
        'accounting' => ['icon' => 'fas fa-calculator', 'label' => 'Accounting &<br>Bookkeeping'],
        'payroll' => ['icon' => 'fas fa-money-check-alt', 'label' => 'Payroll'],
        'tax' => ['icon' => 'fas fa-file-invoice-dollar', 'label' => 'Tax Advisory<br>& Filing'],
        'internal-control' => ['icon' => 'fas fa-shield-alt', 'label' => 'Internal Control<br>Assessment'],
        'ma' => ['icon' => 'fas fa-handshake', 'label' => 'Mergers &<br>Acquisitions'],
        'human-capital' => ['icon' => 'fas fa-users-cog', 'label' => 'Human<br>Capital'],
    ];
@endphp

<style>
.page-hero { position: relative; width: 100%; height: 60vh; min-height: 400px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
.hero-background { position: absolute; inset: 0; z-index: 1; }
.hero-background img { width: 100%; height: 100%; object-fit: cover; }
.hero-overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(0,61,92,.85) 0%, rgba(13,148,136,.75) 100%); z-index: 2; }
.hero-content { position: relative; z-index: 3; text-align: center; color: #fff; padding: 0 20px; }
.hero-title-main { font-size: clamp(36px, 6vw, 64px); font-weight: 300; margin-bottom: 20px; line-height: 1.2; }
.hero-subtitle-main { font-size: clamp(16px, 2vw, 22px); font-weight: 400; max-width: 700px; margin: 0 auto; }

.services-overview-slider-container { position: relative; }
.services-overview-slider { position: relative; overflow: hidden; }
.service-overview-slide { display: none; opacity: 0; transition: opacity .6s ease-in-out; }
.service-overview-slide.active { display: block; opacity: 1; }
.service-overview-image #clientWorldMap { min-height: 400px; }
.custom-pin-marker svg { filter: drop-shadow(0 3px 6px rgba(0,0,0,0.25)); }
.overview-reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity .8s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform .8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.overview-reveal.revealed { opacity: 1; transform: translateY(0); }
.overview-nav-btn { display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 16px 24px; background: transparent; border: 2px solid #e5e7eb; border-radius: 12px; cursor: pointer; transition: all .3s ease; }
.overview-nav-btn:hover { border-color: #0d9488; background: #f0fdfa; }
.overview-nav-btn.active { border-color: #0d9488; background: linear-gradient(135deg, #003d5c 0%, #0d9488 100%); }
.overview-nav-btn .nav-number { font-size: 1.25rem; font-weight: 700; color: #6b7280; }
.overview-nav-btn .nav-title { font-size: .875rem; font-weight: 600; color: #374151; }
.overview-nav-btn.active .nav-number,
.overview-nav-btn.active .nav-title { color: #fff; }

.section-eyebrow {
    font-size: clamp(32px, 4vw, 48px);
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #003d5c;
    margin-bottom: 20px;
}

.what-we-do-section { background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); }
.competency-tab { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; padding: 20px 12px; background: #fff; border: 2px solid #e5e7eb; border-radius: 12px; cursor: pointer; transition: all .3s ease; min-height: 100px; text-align: center; }
.competency-tab i { font-size: 24px; color: #6b7280; }
.competency-tab span { font-size: 13px; font-weight: 600; color: #374151; line-height: 1.4; }
.competency-tab small { font-size: 11px; font-weight: 400; }
.competency-tab:hover { border-color: #0d9488; background: #f0fdfa; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(13, 148, 136, 0.15); }
.competency-tab:hover i { color: #0d9488; transform: scale(1.1); }
.competency-tab.active { border-color: transparent; background: linear-gradient(135deg,#003d5c 0%,#005a7a 25%,#00849e 50%,#00a8c2 75%,#00b8b8 100%); }
.competency-tab.active i,
.competency-tab.active span { color: #fff; }
.competencies-tabs-content { position: relative; min-height: 400px; }
.competency-tab-content { display: none; opacity: 0; animation: fadeInContent .5s ease-out forwards; }
.competency-tab-content.active { display: block; }
@keyframes fadeInContent { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: translateY(0);} }
.competency-image img { width: 100%; height: 400px; object-fit: cover; transition: transform .5s ease; }
.competency-image:hover img { transform: scale(1.05); }
.competency-text h3 { color: #0d9488; line-height: 1.3; }

.ecosystems-content-reveal { opacity: 1; transform: translateY(0); }
</style>

<section class="page-hero">
    <div class="hero-background">
        @if($heroImg)
            <img src="{{ $heroImg }}" alt="{{ $overviewTitle }}" loading="eager">
        @endif
        <div class="hero-overlay"></div>
    </div>
    <div class="container hero-content">
        <h1 class="hero-title-main">{{ $overviewTitle }}</h1>
        <p class="hero-subtitle-main">{{ $overviewBrief }}</p>
    </div>
</section>

<section id="overview" class="services-overview-section relative py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="services-overview-slider-container">
            <div class="services-overview-slider">
                <div class="service-overview-slide active" data-overview="1">
                    <div class="service-overview-content grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div class="service-overview-text overview-reveal" data-delay="0">
                            <h3 class="inline-block text-3xl lg:text-4xl font-bold tracking-widest uppercase mb-4">
                                {{ $overviewSecondTitle }}
                            </h3>
                            <p class="text-sm text-gray-500 mb-6">{{ $overviewLocations }}</p>
                            <h5 class="font-light text-gray-900 mb-6 leading-tight">{{ $overviewBrief }}</h5>
                            <div class="text-gray-600 text-base leading-relaxed space-y-4 mb-8">
                                {!! \App\Classes\Content::inlineStyleToClasses($overviewBodyHtml) !!}
                            </div>
                        </div>

                        <div class="service-overview-image overview-reveal" data-delay="100">
                            <h4 class="text-2xl lg:text-3xl font-semibold text-gray-900 mb-4 text-center">250 Clients served Worldwide</h4>
                            <div class="relative rounded-2xl shadow-2xl overflow-hidden h-[400px] lg:h-[500px]">
                                <div id="clientWorldMap" class="w-full h-full rounded-2xl"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="overview2" class="service-overview-slide" data-overview="2">
                    <div class="service-overview-content grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div class="service-overview-image overview-reveal lg:order-1" data-delay="0">
                            @if($industriesImg)
                                <div class="relative rounded-2xl shadow-2xl overflow-hidden h-[400px] lg:h-[500px]">
                                    <img src="{{ $industriesImg }}" alt="{{ $industriesTitle }}" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700" loading="lazy">
                                </div>
                            @endif
                        </div>
                        <div class="service-overview-text overview-reveal lg:order-2" data-delay="100">
                            <h3 class="inline-block text-3xl lg:text-4xl font-bold tracking-widest uppercase mb-4">
                                {{ $industriesTitle }}
                            </h3>
                            <h4 class="font-light text-gray-900 mb-6 leading-tight">Tailored Solutions for Every Sector</h4>
                            <div class="text-gray-600 text-base leading-relaxed mb-8">
                                <p>{{ $industriesDescription }}</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                {!!  \App\Classes\Content::inlineStyleToClasses($industriesContent) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="services-overview-nav flex justify-center items-center gap-6 mt-12">
                <button class="overview-nav-btn active" data-overview="1">
                    <span class="nav-number">01</span>
                    <span class="nav-title">Overview</span>
                </button>
                <div class="h-px w-16 bg-gray-300"></div>
                <button class="overview-nav-btn" data-overview="2">
                    <span class="nav-number">02</span>
                    <span class="nav-title">Industries</span>
                </button>
            </div>
        </div>
    </div>
</section>

<section id="what-we-do" class="what-we-do-section py-20 lg:py-32 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-header text-center mb-16">
            <div class="section-eyebrow">What We Do</div>
            <h2 class="section-subtitle text-lg font-light text-gray-900 mb-4">Core Competencies</h2>
        </div>

        <div class="competencies-tabs-nav mb-12">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mx-auto">
                @foreach($tabMeta as $key => $meta)
                    <button class="competency-tab {{ $loop->first ? 'active' : '' }}" data-tab="{{ $key }}">
                        <i class="{{ $meta['icon'] }}"></i>
                        <span>{!! $meta['label'] !!}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="competencies-tabs-content">
            @foreach($tabMeta as $key => $meta)
                @php
                    $item = $tabs[$key] ?? null;
                    $img = $item?->mainImage?->url ?? $item?->mainImage?->getUrl();
                @endphp
                <div class="competency-tab-content {{ $loop->first ? 'active' : '' }}" data-content="{{ $key }}">
                    <div class="grid lg:grid-cols-2 gap-10 items-center">
                        <div class="competency-image">
                            @if($img)
                                <img src="{{ $img }}" alt="{{ $item?->title ?? $meta['label'] }}" class="w-full rounded-xl shadow-xl">
                            @endif
                        </div>
                        <div class="competency-text">
                            <h3 class="text-3xl font-light text-gray-900 mb-6">{{ $item?->title ?? strip_tags($meta['label']) }}</h3>
                            <div class="text-gray-700 leading-relaxed space-y-4">
                                {!! \App\Classes\Content::inlineStyleToClasses($item?->content ?? '') !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@if($connectBanner)
@php
    $bannerImg = $connectBanner->mainImage?->url ?? $connectBanner->mainImage?->getUrl();
    $bannerBtn = $connectBanner->frontButtons->first();
@endphp
<section class="ecosystems-section relative py-32 lg:py-40 overflow-hidden">
    <div class="absolute inset-0">
        @if($bannerImg)
            <img src="{{ $bannerImg }}" alt="{{ $connectBanner->title ?? 'Connect Us' }}" class="w-full h-full object-cover" loading="lazy">
        @endif
        <div class="absolute inset-0 bg-gradient-to-br from-[#1a1a1a]/90 via-[#1f1f1f]/85 to-[#262626]/90 opacity-60"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="ecosystems-content-reveal">
            <span class="inline-block text-sm font-bold tracking-widest text-white uppercase mb-6 opacity-95">
                {{ $connectBanner->title ?? 'Connect With Us' }}
            </span>
            <p class="text-white text-lg sm:text-xl leading-relaxed mb-10 opacity-95 max-w-3xl mx-auto">
                {{ $connectBanner->brief ?? '' }}
            </p>
            @if($bannerBtn)
                <a {!! Utility::printAllUrl($bannerBtn->url) !!} class="inline-flex items-center px-8 py-4 bg-white font-semibold text-base rounded-full hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    {{ $bannerBtn->label ?? 'Contact Us' }}
                </a>
            @endif
        </div>
    </div>
</section>
@endif

@endsection

@push('css')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
.text-teal-600 {
    background: linear-gradient(135deg, #003d5c 0%, #005a7a 25%, #00849e 50%, #00a8c2 75%, #00b8b8 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
@endpush

@push('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
(function() {
    const overviewSlides = document.querySelectorAll('.service-overview-slide');
    const overviewNavBtns = document.querySelectorAll('.overview-nav-btn');

    function showOverviewSlide(slideNum) {
        overviewSlides.forEach(slide => slide.classList.remove('active'));
        overviewNavBtns.forEach(btn => btn.classList.remove('active'));

        const targetSlide = document.querySelector(`.service-overview-slide[data-overview="${slideNum}"]`);
        const targetBtn = document.querySelector(`.overview-nav-btn[data-overview="${slideNum}"]`);

        if (targetSlide && targetBtn) {
            targetSlide.classList.add('active');
            targetBtn.classList.add('active');

            const revealElements = targetSlide.querySelectorAll('.overview-reveal');
            revealElements.forEach((el) => {
                el.classList.remove('revealed');
                const delay = parseInt(el.dataset.delay || '0', 10);
                setTimeout(() => el.classList.add('revealed'), delay);
            });
        }
    }

    overviewNavBtns.forEach(btn => btn.addEventListener('click', () => showOverviewSlide(parseInt(btn.dataset.overview))));

    function navigateToIndustries() {
        const overviewSection = document.getElementById('overview');
        if (overviewSection) {
            overviewSection.scrollIntoView({ behavior: 'smooth' });
        }

        setTimeout(() => {
            showOverviewSlide(2);
        }, 300);
    }

    if (window.location.hash === '#industries' || window.location.hash === '#overview2') {
        navigateToIndustries();
    } else {
        showOverviewSlide(1);
    }

    window.addEventListener('hashchange', () => {
        if (window.location.hash === '#industries' || window.location.hash === '#overview2') {
            navigateToIndustries();
        } else if (window.location.hash === '#overview') {
            showOverviewSlide(1);
        }
    });
})();

(function() {
    const tabs = document.querySelectorAll('.competency-tab');
    const contents = document.querySelectorAll('.competency-tab-content');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.tab;
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
            tab.classList.add('active');
            document.querySelector(`.competency-tab-content[data-content="${target}"]`)?.classList.add('active');
        });
    });
})();

(function() {
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof L === 'undefined') return;

        const mapContainer = document.getElementById('clientWorldMap');
        if (!mapContainer) return;

        const clientLocations = [
            { name: 'Lebanon', lat: 33.8547, lng: 35.8623 },
            { name: 'Jordan', lat: 31.9454, lng: 35.9284 },
            { name: 'UAE', lat: 23.4241, lng: 53.8478 },
            { name: 'Iraq', lat: 33.2232, lng: 43.6793 },
            { name: 'Germany', lat: 51.1657, lng: 10.4515 },
            { name: 'UK', lat: 55.3781, lng: -3.4360 },
            { name: 'France', lat: 46.2276, lng: 2.2137 },
            { name: 'Monaco', lat: 43.7384, lng: 7.4246 },
            { name: 'Congo', lat: -4.0383, lng: 21.7587 },
            { name: 'Tunisia', lat: 33.8869, lng: 9.5375 }
        ];

        const map = L.map('clientWorldMap', {
            center: [35.0, 20.0],
            zoom: 3,
            zoomControl: true,
            scrollWheelZoom: true
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18,
            minZoom: 3
        }).addTo(map);

        const redIcon = L.divIcon({
            className: 'custom-pin-marker',
            html: '<svg width="32" height="45" viewBox="0 0 32 45" xmlns="http://www.w3.org/2000/svg"><path d="M16 0C7.163 0 0 7.163 0 16c0 13 16 29 16 29s16-16 16-29c0-8.837-7.163-16-16-16z" fill="#EA4335"></path><circle cx="16" cy="15" r="6" fill="white"></circle></svg>',
            iconSize: [32, 45],
            iconAnchor: [16, 45],
            popupAnchor: [0, -45]
        });

        clientLocations.forEach(location => {
            L.marker([location.lat, location.lng], {
                icon: redIcon,
                title: location.name
            }).addTo(map).bindPopup('<strong>' + location.name + '</strong>');

            const label = L.divIcon({
                className: 'country-label',
                html: '<div style="border-radius:4px;font-family:-apple-system,BlinkMacSystemFont,Segoe UI,sans-serif;font-size:12px;font-weight:600;color:#1f2937;box-shadow:0 2px 6px rgba(0,0,0,0.2);white-space:nowrap;border:1px solid #e5e7eb;background:#fff;padding:2px 8px;">' + location.name + '</div>',
                iconSize: [0, 0],
                iconAnchor: [0, 10]
            });

            L.marker([location.lat, location.lng], {
                icon: label,
                interactive: false
            }).addTo(map);
        });

        const bounds = L.latLngBounds(clientLocations.map(loc => [loc.lat, loc.lng]));
        map.fitBounds(bounds, { padding: [80, 80], maxZoom: 5 });
    });
})();
</script>
@endpush

</x-layouts.layout>
