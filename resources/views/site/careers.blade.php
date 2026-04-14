<x-layouts.layout seoTitle="{{ __('Careers') }}" layoutView="main-inner">

@push('css')
<link rel="stylesheet" href="{{ asset('css/careers.css') }}">
@endpush

@section('content')
@php
    $header = $careersHeader ?? null;
    $jobs = $jobs ?? collect();
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

        @if($jobs->isEmpty())
            <div class="no-vacancy-message">
                <p>No vacancy available now</p>
            </div>
        @else
            <div class="jobs-list" id="jobs-list">
                @foreach($jobs as $job)
                    <article class="job-card" id="job-{{ $job->id }}">
                        <div class="job-header">
                            <div>
                                <h3 class="job-title">{{ $job->title }}</h3>
                                <div class="job-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $job->location }}</span>
                                </div>
                            </div>
                            <div class="job-date">Posted on {{ optional($job->posted_at)->format('d-M-Y') }}</div>
                        </div>

                        <div class="job-meta">
                            <div class="job-meta-item">
                                <i class="fas fa-briefcase"></i>
                                <span>{{ $job->department }}</span>
                            </div>
                            <div class="job-meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span>{{ $job->experience_level }}</span>
                            </div>
                            <div class="job-meta-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ $job->employment_type }}</span>
                            </div>
                        </div>

                        <div class="job-actions">
                            <a href="#apply" class="job-apply-btn" data-job-id="{{ $job->id }}" data-job-title="{{ e($job->title) }}">
                                Apply Now
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>

@if($jobs->isNotEmpty())
<section id="apply" class="application-form-section">
    <div class="application-form-container">
        <livewire:career-application-form />
    </div>
</section>
@endif

@endsection

@push('js')
<script>
(function() {
    const hasJobs = {{ $jobs->isNotEmpty() ? 'true' : 'false' }};

    document.querySelectorAll('a[href="#jobs"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#jobs')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    if (!hasJobs) {
        return;
    }

    document.querySelectorAll('.job-apply-btn').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const applySection = document.querySelector('#apply');
            const jobId = Number(this.dataset.jobId);
            const jobTitle = this.dataset.jobTitle || '';

            if (window.Livewire && Number.isInteger(jobId)) {
                window.Livewire.dispatch('career-job-selected', {
                    jobId,
                    jobTitle,
                });
            }

            applySection?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
})();
</script>
@endpush

</x-layouts.layout>
