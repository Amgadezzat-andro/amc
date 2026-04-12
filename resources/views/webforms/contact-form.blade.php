<x-layouts.layout seoTitle="Contact Us" layoutView="main-inner">

@section('content')
@php
    $ci = $contactInfo ?? [];
    $mapQuery = $mapQuery ?? null;
@endphp

<style>
.contact-hero-banner { position: relative; width: 100%; min-height: 70vh; background: #000; display: flex; align-items: center; justify-content: center; overflow: hidden; background-image: url('{{ asset('assets/contact-us.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; }
.contact-hero-banner::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(0,61,92,.9) 0%, rgba(0,132,158,.85) 100%); z-index: 1; }
.contact-hero-content { max-width: 1400px; margin: 0 auto; padding: 100px 80px; width: 100%; text-align: center; position: relative; z-index: 2; }
.contact-hero-title { font-size: clamp(36px, 5vw, 64px); font-weight: 300; color: #fff; line-height: 1.2; margin-bottom: 20px; }
.contact-hero-title strong { font-weight: 600; }

.contact-details-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; max-width: 1400px; margin: -80px auto 0; padding: 0 80px; position: relative; z-index: 3; }
.contact-detail-card { background: #fff; border-radius: 12px; padding: 40px 30px; text-align: center; box-shadow: 0 8px 24px rgba(0,0,0,.1); transition: all .3s ease; text-decoration: none; color: inherit; display: block; }
.contact-detail-card:hover { transform: translateY(-8px); box-shadow: 0 12px 40px rgba(0,132,158,.2); }
.contact-detail-icon { width: 70px; height: 70px; background: linear-gradient(135deg, #003d5c 0%, #00849e 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; }
.contact-detail-icon i { font-size: 32px; color: #fff; }
.contact-detail-title { font-size: 18px; font-weight: 600; color: #003d5c; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 1px; }
.contact-detail-text { font-size: 15px; line-height: 1.8; color: #5a6c7d; margin: 0; }

.contact-form-section { padding: 120px 0 100px; background: #f5f7fa; }
.contact-form-container { max-width: 1200px; margin: 0 auto; padding: 0 80px; }
.contact-form-wrapper { width: 100%; padding: 40px; background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(2,6,23,.06); box-sizing: border-box; }
.contact-form-title { font-size: 32px; font-weight: 700; color: #001f2e; margin-bottom: 30px; }
.form-group { margin-bottom: 24px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-label { display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px; }
.required { color: #ef4444; margin-left: 4px; }
.form-input,
.form-select,
.form-textarea { width: 100%; padding: 14px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 15px; color: #374151; transition: all .3s ease; font-family: inherit; }
.form-input:focus,
.form-select:focus,
.form-textarea:focus { outline: none; border-color: #00849e; box-shadow: 0 0 0 3px rgba(0,132,158,.1); }
.form-textarea { min-height: 120px; resize: vertical; }
.form-submit-btn { width: 100%; padding: 16px; background: linear-gradient(135deg, #003d5c 0%, #00849e 100%); color: #fff; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all .3s ease; margin-top: 10px; }
.form-submit-btn:hover { background: linear-gradient(135deg, #002d44 0%, #006d84 100%); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,132,158,.3); }

.google-map-section { width: 100%; position: relative; margin-top: 60px; padding: 80px 0 0; background: #fff; }
.google-map-header { text-align: center; margin-bottom: 50px; padding: 0 80px; }
.google-map-title { font-size: clamp(32px, 4vw, 48px); font-weight: 700; color: #001f2e; margin-bottom: 20px; position: relative; padding-bottom: 20px; }
.google-map-title::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 80px; height: 4px; background: linear-gradient(135deg, #003d5c 0%, #00849e 100%); border-radius: 2px; }
.google-map-subtitle { font-size: 18px; color: #5a6c7d; line-height: 1.8; }
.google-map-container iframe { width: 100%; height: 500px; border: 0; display: block; }

@media (max-width: 1024px) {
    .contact-hero-content { padding: 80px 40px; }
    .contact-details-grid { grid-template-columns: repeat(2, 1fr); padding: 0 40px; margin-top: -60px; }
    .contact-form-container { padding: 0 40px; }
    .google-map-header { padding: 0 40px; margin-bottom: 40px; }
}
@media (max-width: 768px) {
    .contact-hero-banner { min-height: 60vh; }
    .contact-hero-content { padding: 60px 20px; }
    .contact-details-grid { grid-template-columns: 1fr; padding: 0 20px; margin-top: -40px; gap: 20px; }
    .contact-form-section { padding: 80px 0 60px; }
    .contact-form-container { padding: 0 20px; }
    .contact-form-wrapper { padding: 30px 24px; }
    .form-row { grid-template-columns: 1fr; }
    .google-map-section { margin-top: 40px; padding: 40px 0 0; }
    .google-map-header { padding: 0 20px; margin-bottom: 30px; }
    .google-map-container iframe { height: 350px; }
}
</style>

<section class="contact-hero-banner">
    <div class="contact-hero-content">
        <h1 class="contact-hero-title">Our <strong>contact details</strong></h1>
    </div>
</section>

<div class="contact-details-grid">
    <a href="{{ $ci['location_url'] ?: '#' }}" target="_blank" class="contact-detail-card">
        <div class="contact-detail-icon"><i class="fas fa-map-marker-alt"></i></div>
        <h2 class="contact-detail-title">our location</h2>
        <p class="contact-detail-text">{{ $ci['address'] ?: '-' }}</p>
    </a>

    <a href="tel:{{ preg_replace('/\s+/', '', $ci['phone'] ?? '') }}" class="contact-detail-card">
        <div class="contact-detail-icon"><i class="fas fa-phone"></i></div>
        <h2 class="contact-detail-title">phone</h2>
        <p class="contact-detail-text">
            Tel/Fax<br>
            <span style="color: #00849e;">{{ $ci['fax'] ?: ($ci['phone'] ?: '-') }}</span><br><br>
            Mobile<br>
            <span style="color: #00849e;">{{ $ci['phone'] ?: '-' }}</span>
        </p>
    </a>

    <a href="mailto:{{ $ci['email'] ?? '' }}" class="contact-detail-card">
        <div class="contact-detail-icon"><i class="fas fa-envelope"></i></div>
        <h2 class="contact-detail-title">e-mail</h2>
        <p class="contact-detail-text"><span style="color:#00849e;">{{ $ci['email'] ?: '-' }}</span></p>
    </a>

    <div class="contact-detail-card">
        <div class="contact-detail-icon"><i class="fas fa-clock"></i></div>
        <h2 class="contact-detail-title">opening days</h2>
        <p class="contact-detail-text">{!! nl2br(e($ci['business_hours'] ?: '-')) !!}</p>
    </div>
</div>

<section class="contact-form-section">
    <div class="contact-form-container">
        <div class="contact-form-wrapper">
            <h2 class="contact-form-title">Get in Touch</h2>
            <p style="color:#5a6c7d; margin-bottom:30px;">Please don't hesitate to contact us regarding any questions and enquiries you may have!</p>
            <livewire:contact-us-form />
        </div>
    </div>
</section>

@if(!empty($mapQuery))
<section class="google-map-section">
    <div class="google-map-header">
        <h2 class="google-map-title">Find Us Here</h2>
        <p class="google-map-subtitle">{{ $ci['address'] ? 'Visit our offices at ' . $ci['address'] : 'Visit our office location' }}</p>
    </div>
    <div class="google-map-container">
        <iframe src="https://maps.google.com/maps?q={{ urlencode($mapQuery) }}&z=14&output=embed" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="Location"></iframe>
    </div>
</section>
@endif

@endsection

</x-layouts.layout>
