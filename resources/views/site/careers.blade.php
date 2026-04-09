<x-layouts.layout seoTitle="{{ __('Careers') }}" layoutView="main-inner">

@section('content')
@php
    $header = $careersHeader ?? null;
    $headerImg = data_get($header, 'mainImage.url') ?: (data_get($header, 'mainImage') ? data_get($header, 'mainImage')->getUrl() : null);
    $headerTitle = data_get($header, 'title') ?: 'Why AMC?';
    $headerBrief = data_get($header, 'brief') ?: '';
    $headerButtons = collect(data_get($header, 'frontButtons', []));
    $internshipUrl = '/' . app()->getLocale() . '/internship';
@endphp

<style>
.careers-hero-banner { position: relative; width: 100%; min-height: 90vh; background: #000; display: flex; align-items: center; overflow: hidden; background-size: cover; background-position: center; background-repeat: no-repeat; }
.careers-hero-banner::before { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, rgba(0,0,0,.85) 0%, rgba(0,0,0,.6) 50%, rgba(0,0,0,.3) 100%); z-index: 1; }
.careers-banner-container { max-width: 1400px; margin: 0 auto; padding: 100px 80px; width: 100%; position: relative; z-index: 2; }
.careers-banner-content { position: relative; z-index: 2; max-width: 800px; text-align: left; }
.careers-banner-title { font-size: clamp(36px, 5vw, 64px); font-weight: 300; color: #fff; line-height: 1.2; margin-bottom: 30px; text-align: left; }
.careers-banner-text { font-size: 18px; line-height: 1.8; color: rgba(255,255,255,.95); max-width: 700px; text-align: left; margin-bottom: 40px; }
.careers-cta-button { display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #003d5c 0%, #0d9488 100%); color: #fff; text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 16px; transition: all .3s ease; margin-top: 20px; margin-right: 10px; }
.careers-cta-button:hover { background: #006d84; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,132,158,.3); }

.jobs-section { padding: 100px 0; background: #fff; }
.jobs-container { max-width: 1400px; margin: 0 auto; padding: 0 80px; }
.jobs-header { text-align: center; margin-bottom: 30px; }
.no-vacancy-message { text-align: center; margin-bottom: 60px; padding: 20px; background: #fef3c7; border: 1px solid #fbbf24; border-radius: 8px; color: #92400e; }
.no-vacancy-message p { margin: 0; font-size: 16px; font-weight: 500; }
.jobs-section-title { font-size: clamp(32px, 4vw, 48px); font-weight: 700; color: #001f2e; margin-bottom: 20px; position: relative; padding-bottom: 20px; }
.jobs-section-title::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 80px; height: 4px; background: linear-gradient(135deg, #003d5c 0%, #00849e 100%); border-radius: 2px; }
.jobs-section-subtitle { font-size: 18px; color: #5a6c7d; text-align: center; max-width: 800px; margin: 0 auto; line-height: 1.8; }

.application-form-section { padding: 100px 0; background: #f5f7fa; }
.application-form-container { margin: 0 auto; padding: 0 80px; }
.application-form { background: #fff; border-radius: 12px; padding: 60px; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
.form-title { font-size: clamp(28px, 4vw, 36px); font-weight: 700; color: #001f2e; margin-bottom: 40px; text-align: center; }
.form-group { margin-bottom: 24px; }
.form-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px; }
.form-label { display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px; }
.form-label .required { color: #ef4444; margin-left: 4px; }
.form-input, .form-textarea { width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 15px; color: #374151; transition: all .3s ease; font-family: inherit; }
.form-input:focus, .form-textarea:focus { outline: none; border-color: #00849e; box-shadow: 0 0 0 3px rgba(0,132,158,.1); }
.form-textarea { min-height: 120px; resize: vertical; }
.file-upload-wrapper { position: relative; }
.file-upload-input { position: absolute; opacity: 0; width: 0; height: 0; }
.file-upload-label { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border: 2px dashed #d1d5db; border-radius: 8px; cursor: pointer; transition: all .3s ease; background: #f9fafb; }
.file-upload-label:hover { border-color: #00849e; background: #f0fdfa; }
.file-upload-label i { color: #00849e; font-size: 20px; }
.file-upload-text { font-size: 14px; color: #6b7280; }
.form-note { font-size: 13px; color: #6b7280; margin-top: 8px; font-style: italic; }
.form-submit-btn { width: 100%; padding: 16px; background: #00849e; color: #fff; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all .3s ease; margin-top: 32px; }
.form-submit-btn:hover { background: #006d84; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,132,158,.3); }

@media (max-width: 1024px) {
    .careers-banner-container { padding: 80px 40px; }
    .jobs-container { padding: 0 40px; }
    .application-form-container { padding: 0 40px; }
    .form-row { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .careers-hero-banner { min-height: 70vh; }
    .careers-banner-container { padding: 60px 20px; }
    .careers-banner-title { font-size: 32px; }
    .careers-banner-text { font-size: 16px; }
    .jobs-section { padding: 60px 0; }
    .jobs-container { padding: 0 20px; }
    .application-form-container { padding: 0 20px; }
    .application-form { padding: 40px 24px; }
    .form-row { grid-template-columns: 1fr; gap: 0; }
}
@media (max-width: 480px) {
    .careers-hero-banner { min-height: 60vh; }
    .careers-banner-title { font-size: 28px; }
    .application-form { padding: 32px 20px; }
    .form-title { font-size: 24px; }
}
</style>

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
