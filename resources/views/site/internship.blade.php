<x-layouts.layout seoTitle="{{ __('Internship') ?? 'Internship' }}" layoutView="main-inner">

@push('css')
<link rel="stylesheet" href="{{ asset('css/internship.css') }}">
@endpush

@section('content')
@php
    $header = $internshipHeader ?? null;
    $whyJoin = $internshipWhyJoin ?? null;
    $programCards = $internshipProgramCards ?? collect();

    $headerImg = data_get($header, 'mainImage.url') ?: (data_get($header, 'mainImage') ? data_get($header, 'mainImage')->getUrl() : null);
    $headerTitle = data_get($header, 'title') ?: 'Welcome to our Internship Program!';
    $headerBrief = data_get($header, 'brief') ?: '';

    $whyTitle = data_get($whyJoin, 'title') ?: 'Why Join?';
    $whyBrief = data_get($whyJoin, 'brief') ?: 'Our program offers a unique opportunity to:';
    $whyContent = data_get($whyJoin, 'content') ?: '';
    $whyImg = data_get($whyJoin, 'mainImage.url') ?: (data_get($whyJoin, 'mainImage') ? data_get($whyJoin, 'mainImage')->getUrl() : null);

    $highlightIcons = [
        'fas fa-calendar-alt',
        'fas fa-user-tie',
        'fas fa-chart-line',
        'fas fa-graduation-cap',
        'fas fa-briefcase',
        'fas fa-lightbulb',
    ];
@endphp

<section id="internships-hero" class="internships-hero-banner" @if($headerImg) style="background-image: url('{{ $headerImg }}');" @endif>
    <div class="internships-banner-container">
        <div class="internships-banner-content">
            <h1 class="internships-banner-title">{!! $headerTitle !!}</h1>
            <div class="internships-banner-text">
                <p>{{ $headerBrief }}</p>
            </div>
        </div>
    </div>
</section>

<section id="why-join" class="internships-content-section why-join-section">
    <div class="internships-container">
        <h2 class="section-title">{{ $whyTitle }}</h2>
        <p class="section-text">{{ $whyBrief }}</p>

        <div class="why-join-content">
            <div class="why-join-text">
                @if(str_contains($whyContent, '<li'))
                    {!! \App\Classes\Content::inlineStyleToClasses($whyContent) !!}
                @elseif(!empty(trim(strip_tags($whyContent))))
                    <ul class="benefits-list">
                        @foreach(preg_split('/\r\n|\r|\n/', trim(strip_tags($whyContent))) as $line)
                            @if(trim($line) !== '')
                                <li>{{ trim($line) }}</li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <ul class="benefits-list">
                        <li>Gain Hands-On Experience</li>
                        <li>Learn from Experts</li>
                        <li>Build Skills and Networks</li>
                        <li>Bridge Education with practice</li>
                    </ul>
                @endif
            </div>
            <div class="why-join-image">
                @if($whyImg)
                    <img src="{{ $whyImg }}" alt="{{ $whyTitle }}">
                @endif
            </div>
        </div>
    </div>
</section>

<section id="program-highlights" class="internships-content-section">
    <div class="internships-container">
        <h2 class="section-title">Program Highlights</h2>

        <div class="highlights-grid">
            @foreach($programCards as $card)
                <div class="highlight-card">
                    <div class="highlight-icon">
                        <i class="{{ $highlightIcons[$loop->index % count($highlightIcons)] }}"></i>
                    </div>
                    <h2 class="highlight-title">{{ $card->title }}</h2>
                    <p class="highlight-text">{{ $card->brief ?? strip_tags($card->content ?? '') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="apply" class="application-form-section">
    <div class="application-form-container">
        <livewire:internship-application-form />
    </div>
</section>

@endsection

@push('js')
<script>
(function() {
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.highlight-card').forEach(card => observer.observe(card));
})();
</script>
@endpush

</x-layouts.layout>
