<x-layouts.layout seoTitle="{{ __('Culture') }}" layoutView="main-inner">

@push('css')
<link rel="stylesheet" href="{{ asset('css/culture.css') }}">
@endpush

@section('content')
@php
    $header = $cultureHeader ?? null;
    $features = $cultureFeatureCards ?? collect();
    $riseValues = $cultureRiseValues ?? [];
    $equityIntro = $cultureEquityIntro ?? null;
    $equityCards = $cultureEquityCards ?? collect();

    $headerImg = data_get($header, 'mainImage.url') ?: (data_get($header, 'mainImage') ? data_get($header, 'mainImage')->getUrl() : null);
    $headerTitle = data_get($header, 'title') ?: 'Possibility starts with our people';
    $headerBrief = data_get($header, 'brief') ?: '';

    $riseMeta = [
        'respect' => ['icon' => 'fas fa-handshake', 'label' => 'Respect'],
        'integrity' => ['icon' => 'fas fa-shield-alt', 'label' => 'Integrity'],
        'skills' => ['icon' => 'fas fa-graduation-cap', 'label' => 'Skills'],
        'equality' => ['icon' => 'fas fa-balance-scale', 'label' => 'Equality'],
    ];

    $riseActiveKey = collect(['respect', 'integrity', 'skills', 'equality'])
        ->first(fn ($key) => !empty($riseValues[$key])) ?? 'respect';
@endphp

<section id="how-we-do" class="culture-hero-banner" @if($headerImg) style="background-image: url('{{ $headerImg }}');" @endif>
    <div class="culture-banner-container">
        <div class="culture-banner-content">
            <h1 class="culture-banner-title">{{ $headerTitle }}</h1>
            <div class="culture-banner-text">
                <p>{{ $headerBrief }}</p>
            </div>
        </div>
    </div>
</section>

<section class="culture-content-section">
    <div class="culture-container">
        <div class="culture-features-grid">
            @foreach($features as $feature)
                @php $img = $feature->mainImage?->url ?? $feature->mainImage?->getUrl(); @endphp
                <div class="culture-feature-card">
                    <div class="culture-feature-image">
                        @if($img)
                            <img src="{{ $img }}" alt="{{ $feature->title ?? 'Culture Feature' }}">
                        @endif
                    </div>
                    <div class="culture-feature-content">
                        <h4 class="culture-feature-title">{{ $feature->title ?? '' }}</h4>
                        <p class="culture-feature-text">{{ $feature->brief ?? strip_tags($feature->content ?? '') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="rise-values" class="culture-content-section rise-values-section">
    <div class="culture-container">
        <div class="section-header text-center mb-12">
            <div class="section-eyebrow">RISE Values</div>
            <h2 style="font-weight:300; margin-bottom:16px; font-size:28px; text-align:center;">Core Values</h2>
            <p class="culture-section-subtitle" style="margin-bottom:0;">Our culture forms the foundation of our success and for promoting a dynamic, inclusive, and positive work environment.</p>
        </div>

        <div class="rise-values-tabs-nav" style="margin-top:40px; margin-bottom:40px;">
            <div>
                @foreach($riseMeta as $key => $meta)
                    @if(!empty($riseValues[$key]))
                        <button type="button" class="rise-value-tab {{ $key === $riseActiveKey ? 'active' : '' }}" data-tab="{{ $key }}">
                            <i class="{{ $meta['icon'] }}"></i>
                            <span>{{ $meta['label'] }}</span>
                        </button>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="rise-values-tabs-content">
            @foreach($riseMeta as $key => $meta)
                @php
                    $item = $riseValues[$key] ?? null;
                    if (!$item) {
                        continue;
                    }
                    $img = $item->mainImage?->url ?? $item->mainImage?->getUrl();
                @endphp
                <div class="rise-value-tab-content {{ $key === $riseActiveKey ? 'active' : '' }}" data-content="{{ $key }}">
                    <div class="rise-value-content-grid">
                        <div class="rise-value-image">
                            @if($img)
                                <img src="{{ $img }}" alt="{{ $item->title ?? $meta['label'] }}">
                            @endif
                        </div>
                        <div class="rise-value-text-content">
                            <h3>{{ $item->title ?? $meta['label'] }}</h3>
                            <p>{{ $item->brief ?? strip_tags($item->content ?? '') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="equity" class="culture-content-section">
    <div class="culture-container">
        <div class="equity-intro">
            <h2 class="section-eyebrow">{{ data_get($equityIntro, 'title') ?: 'Equity-Driven Culture' }}</h2>
            <p class="equity-intro-text">{{ data_get($equityIntro, 'brief') ?: strip_tags((string) data_get($equityIntro, 'content')) }}</p>
        </div>

        <div class="culture-features-grid">
            @foreach($equityCards as $card)
                @php $img = $card->mainImage?->url ?? $card->mainImage?->getUrl(); @endphp
                <div class="culture-feature-card">
                    <div class="culture-feature-image">
                        @if($img)
                            <img src="{{ $img }}" alt="{{ $card->title ?? 'Equity Card' }}">
                        @endif
                    </div>
                    <div class="culture-feature-content">
                        <h4 class="culture-feature-title">{{ $card->title ?? '' }}</h4>
                        <p class="culture-feature-text">{{ $card->brief ?? strip_tags($card->content ?? '') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('js')
<script>
(function() {
    const tabs = document.querySelectorAll('.rise-value-tab');
    const contents = document.querySelectorAll('.rise-value-tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            this.classList.add('active');
            document.querySelector(`.rise-value-tab-content[data-content="${targetTab}"]`)?.classList.add('active');
        });
    });
})();

(function() {
    const animationObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    document.querySelectorAll('.culture-feature-card').forEach(card => {
        card.classList.add('animate-on-scroll');
        animationObserver.observe(card);
    });
})();
</script>
@endpush

</x-layouts.layout>
