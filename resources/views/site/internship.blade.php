<x-layouts.layout seoTitle="{{ __('site.InternShip') }}" layoutView="main-inner">


    @push('css')
        <link href="{{ asset('/css/careers.css') }}" type="text/css" rel="stylesheet"  />
        <link href="{{ asset('/css/internship-custom.css') }}" type="text/css" rel="stylesheet"  />
        <link href="{{ asset('/css/news.css') }}" type="text/css" rel="stylesheet"  />
    @endpush



    @section('content')
        @php($path = '/internship')
        <x-common.header-image :innerItem=null :getFromSpacificLink=$path />

        <!-- Team Collaboration Section -->
        @if ($internShip_banner)
            <section class="content-section py-5 my-5">
                <div class="container">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6 mb-4">
                            <div class="section-image-container">
                                <div class="section-decorative-element"></div>
                                <x-common.webp-image :allowWebpMobile="false" :allowWebpTablet="false" :mediaObject='$internShip_banner->mainImage' alt='{{ $internShip_banner->title }}'
                                    imgClass="default-image-class aspect-ratio-6-4" />
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="section-content">
                                {!! Content::inlineStyleToClasses($internShip_banner->content) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Career Accordion Section -->
        @if ($build_new_future)
            <section class="career-accordion-section py-5 my-5">
                <div class="container">
                    <div class="row align-items-start mb-5">
                        <div class="col-lg-6">
                            <h1 class="internships-final-title">{{ $build_new_future->title }}</h1>
                        </div>
                        <div class="col-lg-6">
                            <div class="internships-final-content">
                                {{-- <p class="internships-final-subtitle">For students in their penultimate year of study</p> --}}
                                <p class="internships-final-description">
                                    {{ $build_new_future->brief }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="career-accordion-container">
                        @foreach ($build_new_future_banners as $index => $futureBanner)
                            <div class="career-accordion-item career-item-{{ $index + 1 }} {{ $index == 0 ? 'active' : '' }}"
                                data-item="{{ $index + 1 }}">
                                <x-common.webp-image :allowWebpMobile="false" :allowWebpTablet="false" :mediaObject='$futureBanner->mainImage' alt='{{ $futureBanner->title }}' />

                                <div class="career-item-content">
                                    {{-- <a data-bs-target="#exampleModal-{{ $futureBanner->slug }}" type="button" --}}
                                        {{-- data-bs-toggle="modal" class="career-read-more-btn"> --}}
                                        {{-- <span> --}}
                                            {{-- <i class="fas fa-arrow-right"></i> --}}
                                        {{-- </span> --}}
                                        {{-- {{ __('site.READ_MORE_BTN') }} --}}
                                    {{-- </a> --}}
                                    {!! Content::inlineStyleToClasses($futureBanner->content) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                            @if ($build_new_future->buttons?->first()?->url)
                            <div class="apply-btn-container d-flex justify-content-center align-items-center">
                                <a {!! Utility::printAllUrl($build_new_future->buttons->first()?->url) !!} type="button" class="main-btn mt-5 d-flex ">
                                    {{ $build_new_future->buttons->first()?->label }}
                                </a>
                            </div>
                            @endif
                </div>
            </section>
        @endif



        <!-- Modal -->
        @foreach ($build_new_future_banners as $index => $futureBanner)
            <div class="modal fade" id="exampleModal-{{ $futureBanner->slug }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        {!! Content::inlineStyleToClasses($futureBanner->content) !!}
                        <div class="modal-footer border-0">
                            <button type="button" class="main-btn" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endsection

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const careerSections = document.querySelectorAll('.career-accordion-section');

                careerSections.forEach(section => {
                    const items = section.querySelectorAll('.career-accordion-item');

                    items.forEach(item => {
                        item.addEventListener('click', function() {
                            items.forEach(i => i.classList.remove('active'));
                            this.classList.add('active');
                        });
                    });
                });
            });
        </script>
    @endpush

</x-layouts.layout>
