<x-layouts.layout seoTitle="{{ __('Home') }}" layoutView="main-inner">

    @section('content')
    {{-- ==================== HERO SLIDER ==================== --}}
    @if($slider && $slider->isNotEmpty())
    <section id="hero-section" class="hero-section" style="min-height: 500px; display: flex; align-items: center; justify-content: center;">

        <div class="anniversary-badge">
            <div class="anniversary-icon"><i class="fas fa-trophy"></i></div>
            <div class="anniversary-content">
                <span class="anniversary-number">33</span>
                <span class="anniversary-label">Years of Excellence</span>
            </div>
            <div class="anniversary-sparkle"></div>
        </div>

        <div class="hero-slider">
            @foreach($slider as $slide)
            @php
                $slideImg = $slide->mainImage?->url ?? $slide->mainImage?->getUrl();
                $slideBtn = $slide->frontButtons->first();
                $isFirst = $loop->first;
            @endphp
            <div class="hero-slide {{ $isFirst ? 'active' : '' }}" data-slide="{{ $loop->iteration }}">
                <div class="hero-background">
                    @if($slideImg)
                        <img src="{{ $slideImg }}" alt="{{ $slide->title }}">
                    @endif
                    <div class="overlay"></div>
                </div>
                <div class="container">
                    <div class="hero-content">
                        <div class="hero-text">
                            @if($slide->title)
                                <h1 class="hero-title">{{ $slide->title }}</h1>
                            @endif
                            @if($slide->brief)
                                <p class="hero-description">{{ $slide->brief }}</p>
                            @endif
                            @if($slideBtn)
                                <a {!! Utility::printAllUrl($slideBtn->url) !!} class="btn-hero"
                                   @if($loop->first) id="openConsultationModalHero" @endif>
                                    {{ $slideBtn->label ?? $slide->button_text }}
                                </a>
                            @elseif($slide->button_text)
                                <a href="#" class="btn-hero"
                                   @if($loop->first) id="openConsultationModalHero" @endif>
                                    {{ $slide->button_text }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="slider-controls">
            <button class="slider-arrow prev" aria-label="Previous slide">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="slider-dots">
                @foreach($slider as $slide)
                    <button class="dot {{ $loop->first ? 'active' : '' }}" data-slide="{{ $loop->iteration }}"></button>
                @endforeach
            </div>
            <button class="slider-arrow next" aria-label="Next slide">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

    </section>
    @endif

    {{-- ==================== ABOUT US ==================== --}}
    @if($aboutUs && $aboutUs->isNotEmpty())
    <section id="about-section" class="about-section">
        <div class="section-header fade-in-animation">
            <h2 class="section-title">{{ __('About Us') }}</h2>
            <p class="section-subtitle">{{ __('Over three decades of Excellence in Audit and Consultancy') }}</p>
        </div>
        <div class="about-grid">
            @foreach($aboutUs as $card)
            @php
                $cardImg = $card->mainImage?->url ?? $card->mainImage?->getUrl();
                $cardBtn = $card->frontButtons->first();
                $cardLink = $cardBtn ? ($cardBtn->url ?? '#') : ($card->code ?? '#');
                $cardClass = ($loop->index % 4 === 0 || $loop->index % 4 === 3) ? 'about-card-tall' : 'about-card-short';
            @endphp
            <a href="{{ $cardLink }}" class="about-card {{ $cardClass }} fade-in-up">
                <div class="about-card-content">
                    <h2>{{ $card->title }}</h2>
                    @if($card->brief)
                        <p>{{ $card->brief }}</p>
                    @endif
                    <span class="read-more">{{ __('Learn more') }} <i class="fas fa-arrow-right"></i></span>
                </div>
                @if($cardImg)
                <div class="about-image">
                    <img src="{{ $cardImg }}" alt="{{ $card->title }}">
                </div>
                @endif
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ==================== SERVICES ==================== --}}
    @if($servicesOverview || $servicesCore || $servicesIndustries)
    <section id="services-section" class="services-section fade-in-animation" style="position: relative;">
        <div class="section-header fade-in-animation">
            <h2 class="section-title">{{ __('Services') }}</h2>
            @if($servicesOverview?->second_title)
                <p class="section-subtitle">{{ $servicesOverview->second_title }}</p>
            @else
                <p class="section-subtitle">{{ __('Comprehensive solutions tailored to your business needs') }}</p>
            @endif
        </div>

        <div class="services-slider-container">
            <div class="services-slider">

                {{-- Slide 1: Overview --}}
                @if($servicesOverview)
                @php
                    $svcOvImg  = $servicesOverview->mainImage?->url ?? $servicesOverview->mainImage?->getUrl();
                    $svcOvBtn  = $servicesOverview->frontButtons->first();
                @endphp
                <div class="service-slide active" data-service="1">
                    <div class="service-slide-content">
                        <div class="service-slide-text">
                            <h3>{{ $servicesOverview->title }}</h3>
                            {!! Content::inlineStyleToClasses($servicesOverview->content ?? '') !!}
                            @if($svcOvBtn)
                                <a {!! Utility::printAllUrl($svcOvBtn->url) !!} class="btn-service">
                                    {{ $svcOvBtn->label ?? __('Learn more') }} <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                        @if($svcOvImg)
                        <div class="service-slide-image">
                            <img src="{{ $svcOvImg }}" alt="{{ $servicesOverview->title }}">
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Slide 2: Core Competencies --}}
                @if($servicesCore)
                @php
                    $svcCoreImg = $servicesCore->mainImage?->url ?? $servicesCore->mainImage?->getUrl();
                    $svcCoreBtn = $servicesCore->frontButtons->first();
                @endphp
                <div class="service-slide" data-service="2">
                    <div class="service-slide-content">
                        <div class="service-slide-text">
                            <h3>{{ $servicesCore->title }}</h3>
                            {!! Content::inlineStyleToClasses($servicesCore->content ?? '') !!}
                            @if($svcCoreBtn)
                                <a {!! Utility::printAllUrl($svcCoreBtn->url) !!} class="btn-service">
                                    {{ $svcCoreBtn->label ?? __('Explore our services') }} <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                        @if($svcCoreImg)
                        <div class="service-slide-image">
                            <img src="{{ $svcCoreImg }}" alt="{{ $servicesCore->title }}">
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Slide 3: Industries --}}
                @if($servicesIndustries)
                @php
                    $svcIndImg = $servicesIndustries->mainImage?->url ?? $servicesIndustries->mainImage?->getUrl();
                    $svcIndBtn = $servicesIndustries->frontButtons->first();
                @endphp
                <div class="service-slide" data-service="3">
                    <div class="service-slide-content">
                        <div class="service-slide-text">
                            <h3>{{ $servicesIndustries->title }}</h3>
                            {!! Content::inlineStyleToClasses($servicesIndustries->content ?? '') !!}
                            @if($svcIndBtn)
                                <a {!! Utility::printAllUrl($svcIndBtn->url) !!} class="btn-service">
                                    {{ $svcIndBtn->label ?? __('View all industries') }} <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                        @if($svcIndImg)
                        <div class="service-slide-image">
                            <img src="{{ $svcIndImg }}" alt="{{ $servicesIndustries->title }}">
                        </div>
                        @endif
                    </div>
                </div>
                @endif

            </div>

            <div class="services-slider-nav">
                @if($servicesOverview)
                <button class="service-nav-btn active" data-service="1">
                    <span class="nav-number">01</span>
                    <span class="nav-title">{{ $servicesOverview->title }}</span>
                </button>
                @endif
                @if($servicesCore)
                <button class="service-nav-btn" data-service="2">
                    <span class="nav-number">02</span>
                    <span class="nav-title">{{ $servicesCore->title }}</span>
                </button>
                @endif
                @if($servicesIndustries)
                <button class="service-nav-btn" data-service="3">
                    <span class="nav-number">03</span>
                    <span class="nav-title">{{ $servicesIndustries->title }}</span>
                </button>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- ==================== CULTURE ==================== --}}
    @if($cultureHowWeDo || $cultureRiseValues || $cultureEquityDriven)
    @php
        $cultureSlides = array_filter([$cultureHowWeDo, $cultureRiseValues, $cultureEquityDriven]);
        $cultureCount  = count($cultureSlides);
    @endphp
    <section id="culture-section" class="culture-section fade-in-animation" style="position: relative;">
        <div class="culture-slider-container">
            <div class="section-header fade-in-animation">
                <h2 class="section-title">{{ __('Culture') }}</h2>
                <p class="section-subtitle">{{ __('Building a workplace where everyone thrives') }}</p>
            </div>

            <div class="culture-slider">

                {{-- Culture Slide 1: How We Do --}}
                @if($cultureHowWeDo)
                @php
                    $cHowImg = $cultureHowWeDo->mainImage?->url ?? $cultureHowWeDo->mainImage?->getUrl();
                    $cHowBtn = $cultureHowWeDo->frontButtons->first();
                @endphp
                <div class="culture-slide active" data-culture="1">
                    <div class="culture-slide-content">
                        <div class="culture-slide-text">
                            <h3>{{ $cultureHowWeDo->title }}</h3>
                            {!! Content::inlineStyleToClasses($cultureHowWeDo->content ?? '') !!}
                            @if($cHowBtn)
                                <a {!! Utility::printAllUrl($cHowBtn->url) !!} class="btn-culture">
                                    {{ $cHowBtn->label ?? __('Learn More') }} <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                        @if($cHowImg)
                        <div class="culture-slide-image">
                            <img src="{{ $cHowImg }}" alt="{{ $cultureHowWeDo->title }}">
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Culture Slide 2: RISE Values --}}
                @if($cultureRiseValues)
                @php
                    $cRiseImg = $cultureRiseValues->mainImage?->url ?? $cultureRiseValues->mainImage?->getUrl();
                    $cRiseBtn = $cultureRiseValues->frontButtons->first();
                @endphp
                <div class="culture-slide" data-culture="2">
                    <div class="culture-slide-content">
                        <div class="culture-slide-text">
                            <h3>{{ $cultureRiseValues->title }}</h3>
                            @if($cultureRiseValues->brief)
                                <p class="culture-intro">{{ $cultureRiseValues->brief }}</p>
                            @endif
                            {!! Content::inlineStyleToClasses($cultureRiseValues->content ?? '') !!}
                            @if($cRiseBtn)
                                <a {!! Utility::printAllUrl($cRiseBtn->url) !!} class="btn-culture">
                                    {{ $cRiseBtn->label ?? __('Explore Our Values') }} <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                        @if($cRiseImg)
                        <div class="culture-slide-image">
                            <img src="{{ $cRiseImg }}" alt="{{ $cultureRiseValues->title }}">
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Culture Slide 3: Equity Driven --}}
                @if($cultureEquityDriven)
                @php
                    $cEqImg = $cultureEquityDriven->mainImage?->url ?? $cultureEquityDriven->mainImage?->getUrl();
                    $cEqBtn = $cultureEquityDriven->frontButtons->first();
                @endphp
                <div class="culture-slide" data-culture="3">
                    <div class="culture-slide-content">
                        <div class="culture-slide-text">
                            <h3>{{ $cultureEquityDriven->title }}</h3>
                            @if($cultureEquityDriven->brief)
                                <p class="culture-intro">{{ $cultureEquityDriven->brief }}</p>
                            @endif
                            {!! Content::inlineStyleToClasses($cultureEquityDriven->content ?? '') !!}
                            @if($cEqBtn)
                                <a {!! Utility::printAllUrl($cEqBtn->url) !!} class="btn-culture">
                                    {{ $cEqBtn->label ?? __('Discover More') }} <i class="fas fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                        @if($cEqImg)
                        <div class="culture-slide-image">
                            <img src="{{ $cEqImg }}" alt="{{ $cultureEquityDriven->title }}">
                        </div>
                        @endif
                    </div>
                </div>
                @endif

            </div>

            <div class="culture-progress-container">
                <div class="culture-progress-wrapper">
                    <div class="culture-progress-bar">
                        <div class="culture-progress-fill" style="width: {{ $cultureCount > 0 ? round(100 / $cultureCount) : 33 }}%"></div>
                    </div>
                    <button class="culture-progress-arrow prev-culture" aria-label="Previous slide">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="culture-progress-info">
                        <span class="progress-current">1</span>
                        <span class="progress-separator">/</span>
                        <span class="progress-total">{{ $cultureCount }}</span>
                    </div>
                </div>
                <button class="culture-progress-arrow next-culture" aria-label="Next slide">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>
    @endif

    {{-- ==================== CAREERS ==================== --}}
    @if($careers || $internship)
    <section id="careers-section" class="careers-section fade-in-animation" style="position: relative;">
        <div class="careers-container">
            <div class="section-header fade-in-animation">
                <h2 class="section-title">{{ __('Careers') }}</h2>
                <p class="section-subtitle">{{ __('Build Your Future With Us') }}</p>
            </div>

            {{-- Jobs Block --}}
            @if($careers)
            @php
                $careersImg = $careers->mainImage?->url ?? $careers->mainImage?->getUrl();
                $careersBtn = $careers->frontButtons->first();
            @endphp
            <div class="career-content-block">
                <div class="career-split-layout">
                    <div class="career-text-side">
                        <h3 class="career-block-title">{{ $careers->title }}</h3>
                        @if($careers->brief)
                            <p class="career-block-text">{{ $careers->brief }}</p>
                        @endif
                        {!! Content::inlineStyleToClasses($careers->content ?? '') !!}
                        @if($careersBtn)
                            <a {!! Utility::printAllUrl($careersBtn->url) !!} class="btn-career">
                                {{ $careersBtn->label ?? __('Explore Opportunities') }} <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                    @if($careersImg)
                    <div class="career-image-side">
                        <img src="{{ $careersImg }}" alt="{{ $careers->title }}">
                        <div class="career-image-overlay"></div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Internship Block --}}
            @if($internship)
            @php
                $internImg = $internship->mainImage?->url ?? $internship->mainImage?->getUrl();
                $internBtn = $internship->frontButtons->first();
            @endphp
            <div class="career-content-block career-reverse">
                <div class="career-split-layout">
                    <div class="career-text-side">
                        <h3 class="career-block-title">{{ $internship->title }}</h3>
                        @if($internship->brief)
                            <p class="career-block-text">{{ $internship->brief }}</p>
                        @endif
                        {!! Content::inlineStyleToClasses($internship->content ?? '') !!}
                        @if($internBtn)
                            <a {!! Utility::printAllUrl($internBtn->url) !!} class="btn-career">
                                {{ $internBtn->label ?? __('Apply for Internship') }} <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                    @if($internImg)
                    <div class="career-image-side">
                        <img src="{{ $internImg }}" alt="{{ $internship->title }}">
                        <div class="career-image-overlay"></div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </section>
    @endif

    @endsection

    @push('js')
    <script>
        // ---- Hero Slider ----
        (function () {
            const slides = document.querySelectorAll('.hero-slide');
            const dots   = document.querySelectorAll('.slider-dots .dot');
            if (!slides.length) return;
            let current = 0, timer;

            function goTo(idx) {
                slides[current].classList.remove('active');
                dots[current]?.classList.remove('active');
                current = (idx + slides.length) % slides.length;
                slides[current].classList.add('active');
                dots[current]?.classList.add('active');
            }

            function start() { timer = setInterval(() => goTo(current + 1), 5000); }
            function reset()  { clearInterval(timer); start(); }

            document.querySelector('.slider-arrow.next')?.addEventListener('click', () => { goTo(current + 1); reset(); });
            document.querySelector('.slider-arrow.prev')?.addEventListener('click', () => { goTo(current - 1); reset(); });
            dots.forEach((d, i) => d.addEventListener('click', () => { goTo(i); reset(); }));
            start();
        })();

        // ---- Services Slider ----
        (function () {
            const navBtns  = document.querySelectorAll('.service-nav-btn');
            const slides   = document.querySelectorAll('.service-slide');
            if (!navBtns.length) return;

            navBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const target = this.dataset.service;
                    navBtns.forEach(b => b.classList.remove('active'));
                    slides.forEach(s => s.classList.remove('active'));
                    this.classList.add('active');
                    document.querySelector(`.service-slide[data-service="${target}"]`)?.classList.add('active');
                });
            });
        })();

        // ---- Culture Slider ----
        (function () {
            const slides  = document.querySelectorAll('.culture-slide');
            const fill    = document.querySelector('.culture-progress-fill');
            const current = document.querySelector('.progress-current');
            if (!slides.length) return;
            let idx = 0;

            function goTo(n) {
                slides[idx].classList.remove('active');
                idx = (n + slides.length) % slides.length;
                slides[idx].classList.add('active');
                if (fill)    fill.style.width = ((idx + 1) / slides.length * 100) + '%';
                if (current) current.textContent = idx + 1;
            }

            document.querySelector('.next-culture')?.addEventListener('click', () => goTo(idx + 1));
            document.querySelector('.prev-culture')?.addEventListener('click', () => goTo(idx - 1));
        })();

        // ---- Floating Scroll Arrow ----
        (function () {
            const arrow = document.getElementById('scrollDownArrow');
            if (!arrow) return;
            const sectionIds = ['hero-section', 'about-section', 'services-section', 'culture-section', 'careers-section', 'footer-section'];

            arrow.addEventListener('click', function (e) {
                e.preventDefault();
                const scrollPos = window.scrollY + window.innerHeight / 2;
                let next = null;
                for (const id of sectionIds) {
                    const el = document.getElementById(id);
                    if (el && el.offsetTop > window.scrollY + 60) { next = el; break; }
                }
                (next || document.body).scrollIntoView({ behavior: 'smooth' });
            });
        })();
    </script>
    @endpush

</x-layouts.layout>

