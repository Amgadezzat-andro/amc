<x-layouts.layout seoTitle="{{ __('site.InternShip') ?? 'Internship' }}" layoutView="main-inner">

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

<style>
.internships-hero-banner { position: relative; width: 100%; min-height: 90vh; background: #000; display: flex; align-items: center; overflow: hidden; background-size: cover; background-position: center; background-repeat: no-repeat; }
.internships-hero-banner::before { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, rgba(0,0,0,.85) 0%, rgba(0,0,0,.6) 50%, rgba(0,0,0,.3) 100%); z-index: 1; }
.internships-banner-container { max-width: 1400px; margin: 0 auto; padding: 100px 80px; width: 100%; position: relative; z-index: 2; }
.internships-banner-content { position: relative; z-index: 2; max-width: 800px; text-align: left; }
.internships-banner-title { font-size: clamp(36px, 5vw, 64px); font-weight: 300; color: #fff; line-height: 1.2; margin-bottom: 30px; text-align: left; }
.internships-banner-text { font-size: 18px; line-height: 1.8; color: rgba(255,255,255,.95); max-width: 700px; text-align: left; margin-bottom: 40px; }

.internships-content-section { padding: 100px 0; background: #fff; }
.internships-content-section.alt-bg { background: #f5f7fa; }
.internships-container { max-width: 1400px; margin: 0 auto; padding: 0 80px; }
.section-title { font-size: clamp(32px, 4vw, 48px); font-weight: 700; color: #001f2e; text-align: center; margin-bottom: 20px; position: relative; padding-bottom: 20px; }
.section-title::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 80px; height: 4px; background: linear-gradient(135deg, #003d5c 0%, #00849e 100%); border-radius: 2px; }
.section-text { font-size: 18px; line-height: 1.8; color: #5a6c7d; text-align: center; max-width: 900px; margin: 0 auto 60px; }

.why-join-section { background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); }
.why-join-content { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; margin-top: 60px; }
.why-join-text { font-size: 18px; line-height: 1.8; color: #374151; }
.benefits-list { list-style: none; padding: 0; margin: 24px 0; }
.benefits-list li { padding: 16px 0; padding-left: 40px; position: relative; font-size: 16px; line-height: 1.8; color: #374151; border-bottom: 1px solid #e5e7eb; }
.benefits-list li:last-child { border-bottom: none; }
.benefits-list li::before { content: '\2713'; font-family: inherit; font-weight: 700; position: absolute; left: 0; color: #00849e; font-size: 18px; line-height: 1; top: 20px; }
.why-join-image { border-radius: 12px; overflow: hidden; }
.why-join-image img { width: 100%; height: 100%; object-fit: cover; }

.highlights-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; margin-top: 60px; }
.highlight-card { background: #fff; border-radius: 12px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,.08); transition: all .3s ease; opacity: 0; transform: translateY(30px); }
.highlight-card.visible { opacity: 1; transform: translateY(0); }
.highlight-card:hover { transform: translateY(-8px); box-shadow: 0 12px 40px rgba(0,132,158,.2); }
.highlight-icon { width: 60px; height: 60px; background: linear-gradient(135deg, #003d5c 0%, #00849e 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; }
.highlight-icon i { font-size: 28px; color: #fff; }
.highlight-title { font-size: 24px; font-weight: 600; color: #003d5c; margin-bottom: 16px; }
.highlight-text { font-size: 16px; line-height: 1.8; color: #5a6c7d; margin: 0; }

.application-form-section { padding: 100px 0; background: #f5f7fa; }
.application-form-container { max-width: 1000px; margin: 0 auto; padding: 0 80px; }
.application-form { background: #fff; border-radius: 12px; padding: 60px; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
.form-title { font-size: clamp(28px, 4vw, 36px); font-weight: 700; color: #001f2e; margin-bottom: 40px; text-align: center; }
.form-note { font-size: 13px; color: #6b7280; margin-top: 8px; font-style: italic; }
.form-row,
.form-row-2 { display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px; margin-bottom: 24px; }
.form-group { display: flex; flex-direction: column; }
.form-label { font-weight: 600; color: #1f2937; margin-bottom: 10px; font-size: 14px; }
.required { color: #dc2626; }
.form-input,
.form-select,
.form-textarea { width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 12px 14px; font-size: 15px; color: #111827; background: #fff; transition: border-color .2s ease, box-shadow .2s ease; }
.form-input:focus,
.form-select:focus,
.form-textarea:focus { outline: none; border-color: #00849e; box-shadow: 0 0 0 3px rgba(0,132,158,.12); }
.form-textarea { min-height: 130px; resize: vertical; }
.file-upload-wrapper { position: relative; }
.file-upload-input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
.file-upload-label { display: flex; align-items: center; justify-content: space-between; border: 1px dashed #9ca3af; border-radius: 10px; padding: 12px 14px; color: #6b7280; background: #f9fafb; cursor: pointer; }
.form-submit-btn { margin-top: 28px; width: 100%; border: 0; background: linear-gradient(135deg, #003d5c 0%, #00849e 100%); color: #fff; border-radius: 10px; padding: 14px 20px; font-size: 16px; font-weight: 600; transition: transform .2s ease, box-shadow .2s ease; }
.form-submit-btn:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(0,61,92,.2); }
.no-vacancy-message { border: 1px solid #86efac; background: #f0fdf4; color: #166534; border-radius: 10px; padding: 12px 14px; }

@media (max-width: 1024px) {
    .internships-banner-container { padding: 80px 40px; }
    .internships-container { padding: 0 40px; }
    .application-form-container { padding: 0 40px; }
    .why-join-content { grid-template-columns: 1fr; gap: 40px; }
    .form-row,
    .form-row-2 { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .internships-hero-banner { min-height: 70vh; }
    .internships-banner-container { padding: 60px 20px; }
    .internships-content-section { padding: 60px 0; }
    .internships-container { padding: 0 20px; }
    .application-form-container { padding: 0 20px; }
    .application-form { padding: 40px 24px; }
    .highlights-grid { grid-template-columns: 1fr; gap: 24px; }
    .form-row,
    .form-row-2 { grid-template-columns: 1fr; }
}
@media (max-width: 480px) {
    .internships-hero-banner { min-height: 60vh; }
    .internships-banner-title { font-size: 28px; }
}
</style>

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
