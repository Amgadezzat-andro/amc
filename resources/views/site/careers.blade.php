<x-layouts.layout seoTitle="{{ __('Careers') }}" layoutView="main-inner">

@push('css')
<link rel="stylesheet" href="{{ asset('css/careers.css') }}">
@endpush

@section('content')
@php
    $header = $careersHeader ?? null;
    $headerImg = data_get($header, 'mainImage.url') ?: (data_get($header, 'mainImage') ? data_get($header, 'mainImage')->getUrl() : null);
    $headerTitle = data_get($header, 'title') ?: 'Why AMC?';
    $headerBrief = data_get($header, 'brief') ?: '';
    $headerButtons = collect(data_get($header, 'frontButtons', []));
    $internshipUrl = '/' . app()->getLocale() . '/internship';
@endphp

<section id="careers-hero" class="careers-hero-banner" @if($headerImg) style="background-image: url('{{ $headerImg }}');" @endif>
    <div class="careers-banner-container">
        <div class="careers-banner-content">
            <h1 class="careers-banner-title">{!! $headerTitle !!}</h1>
            <div class="careers-banner-text">
                <p>{{ $headerBrief }}</p>
            </div>
            @if($headerButtons->isNotEmpty())
                @foreach($headerButtons as $index => $button)
                    @php
                        $buttonUrl = data_get($button, 'url');
                        if (!$buttonUrl) {
                            $buttonUrl = $index === 0 ? '#jobs' : $internshipUrl;
                        }
                        $buttonLabel = data_get($button, 'label') ?: ($index === 0 ? 'Explore Jobs' : 'Explore Internships');
                    @endphp
                    <a {!! \App\Classes\Utility::printAllUrl($buttonUrl) !!} class="careers-cta-button">{{ $buttonLabel }}</a>
                @endforeach
            @else
                <a href="#jobs" class="careers-cta-button">Explore Jobs</a>
                <a {!! \App\Classes\Utility::printAllUrl($internshipUrl) !!} class="careers-cta-button">Explore Internships</a>
            @endif
        </div>
    </div>
</section>

<section id="jobs" class="jobs-section">
    <div class="jobs-container">
        <div class="jobs-header">
            <h2 class="jobs-section-title">Search for open positions</h2>
            <p class="jobs-section-subtitle">Join our team and make an impact. Explore current opportunities below.</p>
        </div>
        <div class="no-vacancy-message">
            <p>No vacancy available now</p>
        </div>
    </div>
</section>

<section id="apply" class="application-form-section">
    <div class="application-form-container">
        <livewire:career-application-form />
    </div>
</section>

@endsection

@push('js')
<script>
(function() {
    document.querySelectorAll('a[href="#jobs"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#jobs')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
})();
</script>
@endpush

</x-layouts.layout>
