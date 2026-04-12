<x-layouts.layout seoTitle="News" layoutView="main-inner">
    @push('css')
        <link rel="stylesheet" href="/css/news-index.css">
    @endpush

    @section('content')

<section class="news-hero-banner">
    <div class="news-hero-bg" @if($newsBanner?->mainImage?->url) style="background-image: url('{{ $newsBanner->mainImage->url }}');" @endif></div>
    <div class="news-hero-overlay"></div>
    <div class="news-hero-stripe"></div>

    <div class="news-hero-container">
        <div class="news-hero-eyebrow">
            <i class="fas fa-newspaper"></i>
            News
        </div>
        <h1 class="news-hero-title">{{ $newsBanner?->title ?? 'News' }}</h1>
        @if($newsBanner?->brief)
            <p class="news-hero-subtitle">{{ $newsBanner->brief }}</p>
        @endif

    </div>
</section>

<section class="news-grid-section">
    <div class="news-grid-container">
        <div class="news-grid-header">
            <div>
                <div class="section-label">Latest Articles</div>
                <h2 class="news-grid-title">Recent News & Insights</h2>
            </div>
        </div>

        <div class="news-grid">
            @forelse($allNews as $news)
                @php
                    $rawCategory = $news->category?->value ?? $news->category?->title ?? 'insights';
                    $slugCategory = \Illuminate\Support\Str::slug(strtolower($rawCategory));
                    $categoryMap = [
                        'audit' => 'audit',
                        'tax' => 'tax',
                        'advisory' => 'advisory',
                        'company' => 'company',
                        'company-news' => 'company',
                    ];
                    $badgeClass = $categoryMap[$slugCategory] ?? 'insights';
                @endphp
                <a href="{{ route('news-view', ['locale' => $lng, 'slug' => $news->slug]) }}" class="article-card visible" data-category="{{ $badgeClass }}">
                    <div class="article-card-image-wrap">
                        @if($news->mainImage?->url)
                            <img src="{{ $news->mainImage->url }}" alt="{{ $news->title }}">
                        @endif
                        @if($news->category?->title)
                            <span class="article-category-badge badge-{{ $badgeClass }}">
                                {{ $news->category->title }}
                            </span>
                        @endif
                    </div>
                    <div class="article-card-body">
                        <div class="article-card-meta">
                            <span class="article-card-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $news->published_at?->format('F d, Y') ?? 'N/A' }}
                            </span>
                            @if($news->reading_time)
                                <span class="article-card-read">
                                    <i class="fas fa-clock"></i>
                                    {{ $news->reading_time }} min
                                </span>
                            @endif
                        </div>
                        <h3 class="article-card-title">{{ $news->title }}</h3>
                        <p class="article-card-excerpt">{{ Str::limit($news->brief, 260) }}</p>
                        <span class="article-card-link">
                            Read More
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            @empty
                <p style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #999;">
                    No news available
                </p>
            @endforelse
        </div>
    </div>
</section>


    @endsection
</x-layouts.layout>

@push('scripts')
<script>
    // Scroll-in animation for article cards
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                cardObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.article-card').forEach(c => cardObserver.observe(c));
</script>
@endpush
