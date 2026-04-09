<x-layouts.layout seoTitle="{{ $targetItem->title }}" seoDescription="{{ $targetItem->brief }}"
    seoImage="{{ $targetItem->mainImage?->url }}">
    @push('css')
        <link rel="stylesheet" href="/css/news-view.css">
    @endpush

    @section('content')
        <section class="article-hero">
            <div class="article-hero-bg"
                @if ($targetItem->mainImage?->url) style="background-image: url('{{ $targetItem->mainImage->url }}');" @endif>
            </div>
            <div class="article-hero-overlay"></div>

            <div class="article-hero-content">
                <nav class="article-breadcrumb">
                    <a href="{{ route('home', ['locale' => $lng]) }}">Home</a>
                    <i class="fas fa-chevron-right"></i>
                    <a href="{{ route('news-index', ['locale' => $lng]) }}">News</a>
                    <i class="fas fa-chevron-right"></i>
                    <span>{{ $targetItem->title }}</span>
                </nav>

                @if ($targetItem->category?->title)
                    <div class="article-hero-category">
                        <i class="fas fa-tag"></i>
                        {{ $targetItem->category->title }}
                    </div>
                @endif

                <h1 class="article-hero-title">{{ $targetItem->title }}</h1>

                <div class="article-hero-meta">
                    <div class="article-hero-meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $targetItem->published_at?->format('F d, Y') ?? 'N/A' }}
                    </div>
                    @if ($targetItem->reading_time)
                        <div class="article-hero-meta-item">
                            <i class="fas fa-clock"></i>
                            {{ $targetItem->reading_time }} min read
                        </div>
                    @endif
                    <div class="article-hero-meta-item">
                        <i class="fas fa-eye"></i>
                        {{ $targetItem->views ?? 0 }} views
                    </div>
                </div>
            </div>
        </section>

        <div class="article-layout">
            <main class="article-main">
                @if ($targetItem->brief)
                    <p class="article-lead">{{ $targetItem->brief }}</p>
                @endif

                @if ($targetItem->mainImage?->url)
                    <div class="article-image-block">
                        <img src="{{ $targetItem->mainImage->url }}" alt="{{ $targetItem->title }}">
                    </div>
                @endif

                <div class="article-body">
                    {!! $targetItem->content !!}
                </div>
            </main>
        </div>

        @if ($relatedNews->isNotEmpty())
            <section class="related-section">
                <div class="related-container">
                    <div class="related-header">
                        <div class="section-label">Keep Reading</div>
                        <h2 class="related-title">More from AMC Insights</h2>
                    </div>

                    <div class="related-grid">
                        @foreach ($relatedNews->take(3) as $related)
                            @php
                                $badge = strtolower($related->category?->value ?? 'default');
                                $allowedBadges = ['audit', 'tax', 'advisory', 'company'];
                                $badgeClass = in_array($badge, $allowedBadges, true) ? $badge : 'default';
                            @endphp
                            <a href="{{ route('news-view', ['locale' => $lng, 'slug' => $related->slug]) }}"
                                class="article-card">
                                <div class="article-card-image-wrap">
                                    <img src="{{ $related->mainImage?->url ?? 'https://via.placeholder.com/600x400?text=News' }}"
                                        alt="{{ $related->title }}">
                                    <span
                                        class="article-category-badge badge-{{ $badgeClass }}">{{ $related->category?->title ?? 'News' }}</span>
                                </div>
                                <div class="article-card-body">
                                    <div class="article-card-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $related->published_at?->format('F d, Y') ?? 'N/A' }}
                                    </div>
                                    <h3 class="article-card-title">{{ $related->title }}</h3>
                                    <p class="article-card-excerpt">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($related->brief ?? ''), 150) }}</p>
                                    <span class="article-card-link">Read More <i class="fas fa-arrow-right"></i></span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endsection
</x-layouts.layout>
