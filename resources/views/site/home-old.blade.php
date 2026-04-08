<x-layouts.layout seoTitle="{{ __('site.HOME_PAGE') }}" layoutView="main-inner">

    @push('css')
        {{-- <link href="{{ asset('/css/home.css') }}" type="text/css" rel="stylesheet" />
        <link href="{{ asset('/css/slick.css') }}" type="text/css" rel="stylesheet" />
        <link href="{{ asset('/css/slick-theme.css') }}" type="text/css" rel="stylesheet" /> --}}
    @endpush




    @section('content')
        <!-- Hero Section -->
        @if ($homepage_banner)
            <div class="hero-section-home py-5">
                <!-- Vertical Text -->
                    {{-- <x-common.webp-image :mediaObject='$homepage_banner->coverImage' alt='{{ $homepage_banner->title }}'
                        imgClass="default-image-class vertical-logo d-none d-lg-block" :allowWebpMobile="false" :allowWebpTablet="false" /> --}}
                <div class="container">
                    <!-- Main Content -->
                    <div class="main-content">
                        <div class="row justify-content-center align-items-center ">
                            {{-- <div class="col-lg-5 mb-lg-0 mb-3">
                                <!-- Image Section -->
                                <div class="image-section">
                                    <x-common.webp-image :mediaObject='$homepage_banner->mainImage' alt='{{ $homepage_banner->title }}'
                                        imgClass="default-image-class" :allowWebpMobile="false" :allowWebpTablet="false" />
                                    <div class="blue-overlay"></div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <!-- Text Content -->
                                <div class="text-content">
                                    <h1 class="text-center mb-0">{{ $homepage_banner->title }}</h1>
                                    <div class="divider-line"></div>
                                    @if ($homepage_banner->buttons?->first()?->url)
                                        <a {!! Utility::printAllUrl($homepage_banner->buttons->first()?->url) !!} class="main-btn">
                                            {{ $homepage_banner->buttons->first()?->label }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- The Firm Section -->
        @if ($homepage_firm_banner)
            <section  class="firm-section">
                <div class="container">
                    <div  class="row">
                        <!-- Left Column - Image -->
                        <div id="home_firm" class="col-lg-5 firm-image-col py-5">
                            <div class="firm-image-container">
                                <x-common.webp-image :mediaObject='$homepage_firm_banner->mainImage' alt='{{ $homepage_firm_banner->title }}'
                                    imgClass="firm-image" :allowWebpMobile="false" :allowWebpTablet="false" />
                                <div class="firm-blue-overlay"></div>
                            </div>
                        </div>

                        <div class="col-1 d-flex justify-content-center">
                            <div class="firm-divider-line"></div>
                        </div>

                        <!-- Right Column - Text -->
                        <div class="col-lg-6 firm-text-col">
                            <div class="firm-text-content">
                                <p class="firm-subtitle">{{ $homepage_firm_banner->title }}</p>
                                {!! Content::inlineStyleToClasses($homepage_firm_banner->content) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Text Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="firm-description">
                                {!! Content::inlineStyleToClasses($homepage_firm_banner->content2) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Strategic Section -->
        @if ($homepage_legal_advice)
            <section class="strategic-section">
                <div class="container">
                    <div class="row strategic-row">
                        <!-- Left Column - Image -->
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <x-common.webp-image :mediaObject='$homepage_legal_advice->mainImage' alt='{{ $homepage_legal_advice->title }}'
                                imgClass="default-image-class aspect-ratio-6-4" :allowWebpMobile="false" :allowWebpTablet="false" />
                        </div>

                        <!-- Right Column - Text -->
                        <div class="col-lg-6 d-flex justify-content-end  ">
                            <div class="strategic-text-content ">
                                <h1 class="strategic-title text-white mt-0">
                                    {{ $homepage_legal_advice->title }}
                                </h1>

                                <div class="strategic-menu">
                                    @foreach ($homepage_legal_advice->buttons as $button)
                                        <a {!! Utility::printAllUrl($button->url) !!} class="menu-item">
                                            <p class="menu-text mb-0 text-white ">{{ $button->label }}</p>
                                            <i class="fa-solid fa-chevron-right text-white "></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Client Satisfaction Section -->
        @if ($homepage_client_satification)
            <section class="satisfaction-section py-5">
                <div class="container">
                    <div class="row">
                        <!-- Left Column - Text -->
                        <div class="col-lg-5 d-flex align-items-center pe-lg-0">
                            <div class="satisfaction-text-content">
                                <h1 class="satisfaction-title">
                                    {{ $homepage_client_satification->title }}
                                </h1>
                            </div>
                        </div>

                        <!-- Right Column - Image -->
                        <div class="col-lg-7">
                            <x-common.webp-image :mediaObject='$homepage_client_satification->mainImage' alt='{{ $homepage_client_satification->title }}'
                                imgClass="default-image-class aspect-ratio-22-9" :allowWebpMobile="false" :allowWebpTablet="false" />
                        </div>
                    </div>
                    <div class="quote-content d-flex justify-content-end flex-column ms-auto position-relative ">
                        <x-common.webp-image :allowWebpMobile="false" :allowWebpTablet="false" pictureClass="position-absolute " :imagePath="asset('/assets/images/quote.png')" :alt="__('site.Quote_ALT')" />

                        <p class="quote-content-dec mb-5">{{ $homepage_client_satification->brief }}</p>
                        <p class="sat-name">
                            {{ $homepage_client_satification->second_title }}
                        </p>
                    </div>
                </div>
            </section>
        @endif

        <!-- News Content Section -->
        @if ($News)
            <section class="news-content-section py-5 my-5">
                <div class="container">
                    <div class="main-title-head">
                        <p class="news-section-label">{{ __('site.News') }}</p>
                        <h1 class="news-content-title mb-5">{{ __('site.KB_IN_FOCUS') }}</h1>
                    </div>
                    <div class="row gy-3 news-articles-grid mb-5">
                        @foreach ($News as $new)
                            <div class="col-lg-4 col-md-12">
                                <a href="{{ route('news-view', ['slug' => $new->slug, 'locale' => $lng]) }}"
                                    class="news-article-card d-block ">
                                    <div class="news-article-card-container">
                                        <div class="news-article-img">
                                            <x-common.webp-image :mediaObject='$new->mainImage' alt='{{ $new->title }}'
                                                imgClass="cover-image-class aspect-ratio-16-9" :allowWebpMobile="false" :allowWebpTablet="false" />
                                        </div>
                                        <div class="news-article-content-container">
                                            <div class="news-article-content">
                                                <h3 class="news-article-title title-only-2-lines">{{ $new->title }}</h3>
                                                <div class="news-title-divider"></div>
                                                <p class="news-article-excerpt only-3-lines mb-0">
                                                    {{ $new->brief }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('news-index', ['locale' => $lng]) }}"
                        class="main-btn d-flex m-auto px-5">{{ __('site.SEE_ALL') }}</a>
                </div>
            </section>
        @endif
    @endsection

    @push('js')
        {{-- <script src="{{ asset('/js/slick.min.js') }}"></script> --}}

        {{-- <script>
            let direction = $('body').hasClass("arabic-version");
            $(".team-slider").slick({
                rtl: direction,
                dots: false,
                arrows: false,
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            dots: true,
                            slidesToShow: 1
                        }
                    }
                ]
            });
        </script> --}}
    @endpush

</x-layouts.layout>
