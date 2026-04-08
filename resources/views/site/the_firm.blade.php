<x-layouts.layout seoTitle="{{ __('site.THE_FIRM') }}" layoutView="main-inner">


    @push('css')
        <link href="{{ asset('/css/firm.css') }}" type="text/css" rel="stylesheet"  />
        <link href="{{ asset('/css/forms.css') }}" type="text/css" rel="stylesheet"  />
        <link href="{{ asset('/css/navbar-v2.css') }}" type="text/css" rel="stylesheet"  />
    @endpush



    @section('content')
        {{-- @php($path = '/the-firm') --}}
        {{-- @php($viewName = 'the-firm') --}}
        {{-- <x-common.header-image :innerItem=null :getFromSpacificLink=$path :view=$viewName /> --}}
        @if ($firm_banner)
            <section class="firm-hero-section py-5">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h1 class="firm-hero-title text-center ">{{ $firm_banner->title }}</h1>
                        </div>
                        <div class="col-lg-6">
                            <div class="firm-hero-divider"></div>
                            <div class="firm-hero-description m-auto ">
                                {!! Content::inlineStyleToClasses($firm_banner->content) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- A Dynamic Law Firm Section -->
        @if ($dynamic_laws_firm)
            <section class="dynamic-section py-5">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h2 class="dynamic-title">{{ $dynamic_laws_firm->title }}</h2>
                            <div class="dynamic-text">
                                {!! Content::inlineStyleToClasses($dynamic_laws_firm->content) !!}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <x-common.webp-image :mediaObject='$dynamic_laws_firm->mainImage' alt='{{ $dynamic_laws_firm->title }}'
                                imgClass="default-image-class aspect-ratio-6-4" :allowWebpMobile="false" :allowWebpTablet="false" />
                        </div>
                    </div>
                </div>
            </section>
        @endif


        <!-- Trusted Advisors Section -->
        @if ($trusted_advisors)
            <section class="advisors-section py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="advisors-title">{{ $trusted_advisors->title }}</h2>
                            <p class="advisors-text">
                                {!! Content::inlineStyleToClasses($trusted_advisors->content) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Our Values Section -->
        @if ($our_values)
            <section id="our-values" class="values-section py-5">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <h1 class="values-title">{{ $our_values->title }}</h1>
                        </div>
                        <div class="col-lg-1 d-none d-lg-block text-center">
                            <div class="values-divider"></div>
                        </div>
                        <div class="col-lg-7">
                            <div class="values-content">
                                @foreach ($our_values->bmses as $value)
                                    <div class="value-item">
                                        <h3 class="value-item-title">{{ $value->title }}</h3>
                                        <p class="value-item-text">
                                            {{ $value->brief }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Our Achievements Section -->
        @if ($our_achievements)
            <section id="our-achievements" class="achievements-section py-5">
                <div class="container">
                    <!-- Top Row: Image and Title -->
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="achievements-image-container">
                                <x-common.webp-image :mediaObject='$our_achievements->mainImage' alt='{{ $our_achievements->title }}'
                                    imgClass="default-image-class aspect-ratio-6-4" :allowWebpMobile="false" :allowWebpTablet="false" />
                                <div class="achievements-blue-overlay"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h1 class="achievements-title">{{ $our_achievements->title }}</h1>
                        </div>
                    </div>

                    <!-- Bottom Row: Text Content -->
                    <div class="row">
                        <div class="col-12">
                            <div class="achievements-text-content">
                                {!! Content::inlineStyleToClasses($our_achievements->content) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Awards and Certifications Section -->
        @if ($our_accreditions)
            <section class="awards-section position-relative py-5">
                <div class="container">
                    <div class="awards-grid">
                        @if ($our_accreditions->bmses && $our_accreditions->bmses->count() > 0)
                            @foreach ($our_accreditions->bmses as $accredition)
                                <x-common.webp-image :mediaObject='$accredition->mainImage' alt='{{ $accredition->title }}'
                                    imgClass="award-logo" :allowWebpMobile="false" :allowWebpTablet="false" />
                            @endforeach
                        @endif
                    </div>
                </div>
            </section>
        @endif
    @endsection

</x-layouts.layout>
