<x-layouts.layout seoTitle="{{ __('site.About_US') }}">
    @push('css')
    @endpush

    @section('content')
    @include('site.about_us_content')
    @endsection

    @push('js')
    <script src="{{ asset('js/about-slider.js') }}"></script>
    @endpush
</x-layouts.layout>
