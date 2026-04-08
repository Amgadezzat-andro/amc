<x-layouts.layout seoTitle="{{ __('site.Culture') ?? 'Culture' }}" layoutView="main-inner">

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

<style>
.culture-hero-banner {
    position: relative;
    width: 100%;
    min-height: 90vh;
    background: #000;
    display: flex;
    align-items: center;
    overflow: hidden;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
.culture-hero-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(0,0,0,.85) 0%, rgba(0,0,0,.6) 50%, rgba(0,0,0,.3) 100%);
    z-index: 1;
}
.culture-banner-container { max-width: 1400px; margin: 0 auto; padding: 100px 80px; width: 100%; position: relative; z-index: 2; }
.culture-banner-content { position: relative; z-index: 2; max-width: 700px; text-align: left; }
.culture-banner-title { font-size: clamp(36px, 5vw, 64px); font-weight: 300; color: #fff; line-height: 1.2; margin-bottom: 30px; text-align: left; }
.culture-banner-text { font-size: 18px; line-height: 1.8; color: rgba(255,255,255,.95); max-width: 600px; text-align: left; }

.culture-content-section { padding: 100px 0; background: #fff; }
.culture-content-section.alt-bg { background: #f5f7fa; }
.culture-container { max-width: 1400px; margin: 0 auto; padding: 0 80px; }
.culture-features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; margin-top: 60px; }
.culture-feature-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); transition: all .4s ease; opacity: 1; transform: translateY(0); }
.culture-feature-card.animate-on-scroll { opacity: 0; transform: translateY(50px); }
.culture-feature-card.animate-on-scroll.visible { opacity: 1; transform: translateY(0); }
.culture-feature-card:hover { transform: translateY(-8px); box-shadow: 0 12px 40px rgba(0,132,158,.2); }
.culture-feature-image { width: 100%; height: 280px; overflow: hidden; background: linear-gradient(135deg, #003d5c 0%, #00849e 100%); }
.culture-feature-image img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s ease; }
.culture-feature-card:hover .culture-feature-image img { transform: scale(1.1); }
.culture-feature-content { padding: 40px; }
.culture-feature-title { font-size: 24px; font-weight: 600; color: #003d5c; margin-bottom: 16px; line-height: 1.3; }
.culture-feature-text { font-size: 16px; line-height: 1.8; color: #5a6c7d; margin: 0; }

.rise-values-section { background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); }
.section-eyebrow { font-size: clamp(32px, 4vw, 48px); font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: #003d5c; margin-bottom: 20px; }
.culture-section-subtitle { font-size: 18px; color: #5a6c7d; text-align: center; max-width: 800px; margin: 0 auto 60px; line-height: 1.8; }
.rise-values-tabs-nav > div { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; max-width: 800px; margin: 0 auto; }
.rise-value-tab { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; padding: 20px 12px; background: #fff; border: 2px solid #e5e7eb; border-radius: 12px; cursor: pointer; transition: all .3s ease; min-height: 100px; text-align: center; }
.rise-value-tab i { font-size: 24px; color: #6b7280; transition: all .3s ease; }
.rise-value-tab span { font-size: 13px; font-weight: 600; color: #374151; line-height: 1.4; transition: all .3s ease; }
.rise-value-tab:hover { border-color: #00849e; background: #f0fdfa; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,132,158,.15); }
.rise-value-tab:hover i { color: #00849e; transform: scale(1.1); }
.rise-value-tab.active { border-color: #00849e; background: #00849e; }
.rise-value-tab.active i,
.rise-value-tab.active span { color: #fff; }
.rise-values-tabs-content { position: relative; min-height: 400px; margin-top: 40px; }
.rise-value-tab-content { display: none; opacity: 0; visibility: hidden; }
.rise-value-tab-content.active { display: block; opacity: 1; visibility: visible; animation: fadeInContent .5s ease-out forwards; }
@keyframes fadeInContent { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: translateY(0);} }
.rise-value-content-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center; }
.rise-value-image { position: relative; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.1); }
.rise-value-image img { width: 100%; height: 400px; object-fit: cover; transition: transform .5s ease; }
.rise-value-image:hover img { transform: scale(1.05); }
.rise-value-text-content h3 { font-size: 32px; font-weight: 300; color: #00849e; margin-bottom: 24px; line-height: 1.3; }
.rise-value-text-content p { font-size: 16px; line-height: 1.8; color: #374151; }

.equity-intro { text-align: center; max-width: 900px; margin: 0 auto 60px; padding: 60px; border-radius: 12px; }
.equity-intro-title { font-size: clamp(28px, 4vw, 42px); font-weight: 700; color: #001f2e; margin-bottom: 24px; }
.equity-intro-text { font-size: 18px; line-height: 1.8; color: #5a6c7d; margin: 0; }

@media (max-width: 1024px) {
    .culture-banner-container { padding: 80px 40px; }
    .culture-container { padding: 0 40px; }
    .rise-value-content-grid { grid-template-columns: 1fr; gap: 32px; }
    .rise-value-image img { height: 300px; }
    .rise-values-tabs-nav > div { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .culture-hero-banner { min-height: 70vh; }
    .culture-banner-container { padding: 60px 20px; }
    .culture-content-section { padding: 60px 0; }
    .culture-container { padding: 0 20px; }
    .culture-features-grid { grid-template-columns: 1fr; gap: 24px; }
    .culture-feature-content { padding: 30px 20px; }
    .rise-value-tab { padding: 16px 8px; min-height: 90px; }
    .rise-value-tab i { font-size: 20px; }
    .rise-value-tab span { font-size: 11px; }
    .rise-value-text-content h3 { font-size: 24px; }
    .rise-value-image img { height: 250px; }
    .rise-values-tabs-nav > div { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .equity-intro { padding: 40px 20px; }
}
@media (max-width: 480px) {
    .culture-hero-banner { min-height: 60vh; }
    .culture-banner-title { font-size: 28px; }
    .culture-banner-text { font-size: 16px; }
    .rise-values-tabs-nav > div { grid-template-columns: 1fr; }
}
</style>

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
