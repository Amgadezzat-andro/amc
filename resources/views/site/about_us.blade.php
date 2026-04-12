<x-layouts.layout  seoTitle="{{ __('About Us') }}">
    @push('css')
    <link rel="stylesheet" href="{{ asset('css/about_us.css') }}">
    @endpush

    @section('content')
    @include('site.about_us_content')
    @endsection

    @push('js')
    {{-- <script src="{{ asset('js/about-slider.js') }}"></script> --}}
    @endpush
</x-layouts.layout>
