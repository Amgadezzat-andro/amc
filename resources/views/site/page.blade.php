<x-layouts.layout seoTitle="{{ $taregtPage->title }}" seoDescription="{{ $taregtPage->brief }}"
    seoKeywords="{{ $taregtPage->keywords }}" seoImage="{{ $taregtPage->mainImage?->url }}">

    @push('css')
        <link href="{{ asset('/css/firm.css') }}" type="text/css" rel="stylesheet"  />
        <link href="{{ asset('/css/forms.css') }}" type="text/css" rel="stylesheet"  />
        <link href="{{ asset('/css/navbar.css') }}" type="text/css" rel="stylesheet"  />
        <link href="{{ asset('/css/custom.css') }}" type="text/css" rel="stylesheet"  />
    @endpush







    @section('content')
        <x-common.header-image :innerItem=$taregtPage />

        <!-- A Dynamic Law Firm Section -->
        <section class="dynamic-section privacy-policy-section py-5">
            <div class="container">
                <div class="row align-items-center">
                    @if ($taregtPage->mainImage)
                    <div class="col-lg-6">
                        <h2 class="dynamic-title">{{ $taregtPage->title }}</h2>
                        <div class="dynamic-text">
                            {!! Content::inlineStyleToClasses($taregtPage->content) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <x-common.webp-image :mediaObject='$taregtPage->mainImage' alt='{{ $taregtPage->title }}'
                            imgClass="default-image-class" :allowWebpMobile="false" :allowWebpTablet="false" />
                    </div>
                    @else
                    <div class="col-12">
                        <h2 class="dynamic-title">{{ $taregtPage->title }}</h2>
                        <div class="dynamic-text">
                            {!! Content::inlineStyleToClasses($taregtPage->content) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    @endsection

</x-layouts.layout>
