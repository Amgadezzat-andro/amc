<x-layouts.layout seoTitle="{{ __('site.NEWS') }}">

    @push('css')
        <link href="{{ asset('/css/news.css') }}" type="text/css" rel="stylesheet" />
    @endpush

    @section('content')
    <main class="">
            @php($path = '/news')
              <x-common.header-image :innerItem=null :getFromSpacificLink=$path />


            <section class="bg-white py-16 lg:py-24">
                <div class="max-w-7xl mx-auto px-4 lg:px-8">
                    @if($latestNews->isNotEmpty())
                    <div class="grid lg:grid-cols-3 gap-8 mb-16">
                        @foreach($latestNews as $index => $item)
                            @if($index === 0)
                                <article class="lg:col-span-2 cursor-pointer group" onclick="window.location.href='{{ route('news-view', ['slug' => $item->slug, 'locale' => $lng]) }}'">
                                    <div class="relative w-full h-[500px] lg:h-[600px] mb-6 overflow-hidden rounded-lg">
                                        @if($item->mainImage)
                                            <x-common.webp-image :mediaObject="$item->mainImage" alt="{{ $item->title }}" imgClass="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" :allowWebpMobile="false" :allowWebpTablet="false" />
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center"><i class="fas fa-image text-4xl text-gray-400"></i></div>
                                        @endif
                                    </div>
                                    <div class="space-y-4">
                                        <span class="text-orange-500 font-semibold text-sm">◆ {{ $item->published_at?->format('M d Y') }}</span>
                                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">{{ $item->title }}</h2>
                                        <p class="text-gray-700 text-lg leading-relaxed">{{ Str::limit(strip_tags($item->brief), 200) }}</p>
                                        <a href="{{ route('news-view', ['slug' => $item->slug, 'locale' => $lng]) }}" class="inline-block mt-6 px-8 py-3 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition uppercase">Read More</a>
                                    </div>
                                </article>
                            @else
                                <article class="cursor-pointer group" onclick="window.location.href='{{ route('news-view', ['slug' => $item->slug, 'locale' => $lng]) }}'">
                                    <div class="relative w-full h-[300px] mb-6 overflow-hidden rounded-lg">
                                        @if($item->mainImage)
                                            <x-common.webp-image :mediaObject="$item->mainImage" alt="{{ $item->title }}" imgClass="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" :allowWebpMobile="false" :allowWebpTablet="false" />
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center"><i class="fas fa-image text-4xl text-gray-400"></i></div>
                                        @endif
                                    </div>
                                    <div class="space-y-4">
                                        <h3 class="text-2xl font-bold text-gray-900 leading-tight">{{ $item->title }}</h3>
                                        <p class="text-gray-700 leading-relaxed">{{ Str::limit(strip_tags($item->brief), 120) }}</p>
                                        <a href="{{ route('news-view', ['slug' => $item->slug, 'locale' => $lng]) }}" class="inline-block mt-6 px-8 py-3 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition uppercase">Read More</a>
                                    </div>
                                </article>
                            @endif
                        @endforeach
                    </div>
                    @endif

                    @if($trendingNews->isNotEmpty())
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-8">TODAY'S TRENDING</h2>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($trendingNews as $item)
                            <article class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-6 cursor-pointer" onclick="window.location.href='{{ route('news-view', ['slug' => $item->slug, 'locale' => $lng]) }}'">
                                <span class="text-sm text-gray-500 mb-2 block">{{ $item->published_at?->format('M d Y') }}</span>
                                @if($item->category)
                                <span class="text-xs text-teal-600 font-semibold uppercase mb-2 block">{{ $item->category->title }}</span>
                                @endif
                                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $item->title }}</h3>
                                <a href="{{ route('news-view', ['slug' => $item->slug, 'locale' => $lng]) }}" class="text-teal-600 hover:text-teal-700 font-semibold text-sm inline-flex items-center">Read more <i class="fas fa-arrow-right ml-2"></i></a>
                            </article>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </section>

            <section class="bg-white py-12 lg:py-16">
                <div class="max-w-7xl mx-auto px-4 lg:px-8">
                    <div class="flex flex-wrap gap-4 mb-12 border-b border-gray-200 pb-6">
                        <button class="filter-btn px-4 py-2 text-sm font-medium text-gray-700 hover:text-teal-600 transition border-b-2 border-transparent hover:border-teal-600 active border-teal-600 text-teal-600" data-filter="all">All</button>
                        @foreach($newsCategories as $cat)
                        <button class="filter-btn px-4 py-2 text-sm font-medium text-gray-700 hover:text-teal-600 transition border-b-2 border-transparent hover:border-teal-600" data-filter="{{ $cat->id }}">{{ $cat->title }}</button>
                        @endforeach
                    </div>

                    <div id="newsGrid" class="space-y-8">
                        @forelse($allNews as $item)
                        <article class="news-item border-b border-gray-200 pb-8 cursor-pointer hover:opacity-80 transition" data-category="{{ $item->category_id ?? '' }}" onclick="window.location.href='{{ route('news-view', ['slug' => $item->slug, 'locale' => $lng]) }}'">
                            <div class="flex flex-col lg:flex-row gap-6">
                                <div class="lg:w-1/4">
                                    @if($item->mainImage)
                                    <x-common.webp-image :mediaObject="$item->mainImage" alt="{{ $item->title }}" imgClass="w-full h-48 object-cover rounded-lg" :allowWebpMobile="false" :allowWebpTablet="false" />
                                    @else
                                    <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center"><i class="fas fa-image text-4xl text-gray-400"></i></div>
                                    @endif
                                </div>
                                <div class="lg:w-3/4">
                                    @if($item->category)
                                    <span class="text-xs text-teal-600 font-semibold uppercase mb-2 block">{{ $item->category->title }}</span>
                                    @endif
                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $item->title }}</h3>
                                    <p class="text-gray-700 mb-4 leading-relaxed">{{ Str::limit(strip_tags($item->brief), 200) }}</p>
                                    <a href="{{ route('news-view', ['slug' => $item->slug, 'locale' => $lng]) }}" class="text-teal-600 hover:text-teal-700 font-semibold inline-flex items-center">Read more <i class="fas fa-arrow-right ml-2"></i></a>
                                </div>
                            </div>
                        </article>
                        @empty
                        <p class="text-gray-600 py-8">{{ __('site.NO_NEWS') ?? 'No news yet.' }}</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>
    @endsection

    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const newsFilters = document.querySelectorAll('.filter-btn');
            const newsItems = document.querySelectorAll('.news-item');

            if (!newsFilters.length || !newsItems.length) return;

            newsFilters.forEach(btn => {
                btn.addEventListener('click', () => {
                    const filter = btn.getAttribute('data-filter');

                    newsFilters.forEach(b => {
                        b.classList.remove('active', 'border-teal-600', 'text-teal-600');
                        b.classList.add('border-transparent');
                    });
                    btn.classList.add('active', 'border-teal-600', 'text-teal-600');
                    btn.classList.remove('border-transparent');

                    newsItems.forEach(item => {
                        const category = item.getAttribute('data-category');
                        if (filter === 'all' || category === filter) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
    @endpush
</x-layouts.layout>
