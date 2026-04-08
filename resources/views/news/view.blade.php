<x-layouts.layout seoTitle="{{ $targetItem->title }}" seoDescription="{{ $targetItem->brief }}"
    seoImage="{{ $targetItem->mainImage?->url }}">

    @section('content')
    <div id="lightboxModal" class="fixed inset-0 z-[999] flex items-center justify-center bg-black/90 opacity-0 pointer-events-none transition-opacity duration-300">
        <button id="lightboxClose" class="absolute top-5 right-6 text-white text-4xl leading-none hover:text-teal-400 transition z-10" aria-label="Close">&times;</button>
        <button id="lightboxPrev" class="absolute left-4 top-1/2 -translate-y-1/2 text-white text-4xl hover:text-teal-400 transition z-10 px-2"><i class="fas fa-chevron-left"></i></button>
        <button id="lightboxNext" class="absolute right-16 top-1/2 -translate-y-1/2 text-white text-4xl hover:text-teal-400 transition z-10 px-2"><i class="fas fa-chevron-right"></i></button>
        <div class="max-w-5xl w-full mx-4 flex flex-col items-center">
            <img id="lightboxImg" src="" alt="" class="max-h-[80vh] w-auto rounded-xl shadow-2xl object-contain" style="max-width:100%;">
            <p id="lightboxCaption" class="text-white/70 text-sm mt-4"></p>
        </div>
    </div>

    <main>
        @php
            $heroUrl = $targetItem->mainImage?->url ?? null;
        @endphp
        <div class="w-full relative">
            <div class="w-full h-[55vh] lg:h-[70vh] bg-cover bg-center relative" @if($heroUrl) style="background-image: url('{{ $heroUrl }}');" @else style="background: linear-gradient(to right, #0d9488, #2563eb);" @endif>
                <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-black/10 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 px-6 lg:px-16 pb-10">
                    <a href="{{ route('news-index', ['locale' => $lng]) }}" class="inline-flex items-center text-white/80 hover:text-teal-400 transition mb-4 text-sm">
                        <i class="fas fa-arrow-left mr-2"></i> {{ __('site.Back_to_NEWS') ?? 'Back to News' }}
                    </a>
                    <div class="flex items-center gap-3 mb-3">
                        @if($targetItem->category)
                        <span class="inline-block px-4 py-1.5 bg-teal-500 text-white rounded-full text-sm font-semibold">{{ $targetItem->category->title }}</span>
                        @endif
                        <span class="text-white/70 text-sm">{{ $targetItem->published_at?->format('M d, Y') }}</span>
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-bold text-white drop-shadow-lg">{{ $targetItem->title }}</h1>
                </div>
            </div>
        </div>

        <section class="w-full bg-white py-12">
            <div class="w-full px-6 lg:px-16">
                <div class="grid lg:grid-cols-3 gap-10">
                    <div class="lg:col-span-2">
                        <div class="prose prose-lg max-w-none mb-8">
                            @if($targetItem->brief)
                            <p class="text-xl text-gray-700 leading-relaxed mb-6">{{ Str::limit(strip_tags($targetItem->brief), 300) }}</p>
                            @endif
                            {!! Content::inlineStyleToClasses($targetItem->content) !!}
                            @php $gallery = $targetItem->galleryMedia(); @endphp
                            @if($gallery->isNotEmpty())
                            <div class="grid md:grid-cols-2 gap-6 my-8">
                                @foreach($gallery as $media)
                                <img src="{{ $media->url ?? $media->getUrl() }}" alt="{{ $targetItem->title }}" class="rounded-xl shadow-lg w-full object-cover lightbox-img cursor-pointer hover:opacity-90 transition" onerror="this.style.display='none';">
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="border-t border-gray-200 pt-6 mt-8">
                            <div class="flex items-center justify-between flex-wrap gap-4">
                                <div class="flex items-center space-x-4">
                                    <span class="text-gray-600 font-medium">{{ __('site.Share') ?? 'Share' }}:</span>
                                    @php $pageUrl = url()->current(); $pageTitle = e($targetItem->title); @endphp
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($pageUrl) }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-teal-600 transition"><i class="fab fa-facebook text-xl"></i></a>
                                    <a href="https://x.com/intent/tweet?url={{ urlencode($pageUrl) }}&text={{ urlencode($pageTitle) }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-teal-600 transition inline-flex items-center justify-center w-8 h-8" aria-label="Share on X"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($pageUrl) }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-teal-600 transition"><i class="fab fa-linkedin text-xl"></i></a>
                                    <a href="https://wa.me/?text={{ urlencode($pageTitle . ' ' . $pageUrl) }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-teal-600 transition"><i class="fab fa-whatsapp text-xl"></i></a>
                                </div>
                                <a href="{{ route('news-index', ['locale' => $lng]) }}" class="text-teal-600 hover:text-teal-700 transition font-semibold">{{ __('site.View_All_News') ?? 'View All News' }} →</a>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2"><i class="fas fa-newspaper text-teal-500"></i> {{ __('site.Article_Info') ?? 'Article Info' }}</h3>
                            <ul class="space-y-3 text-gray-700">
                                @if($targetItem->category)
                                <li class="flex items-start gap-2"><i class="fas fa-tag text-teal-500 mt-1"></i><span>{{ __('site.Category') ?? 'Category' }}: <strong>{{ $targetItem->category->title }}</strong></span></li>
                                @endif
                                <li class="flex items-start gap-2"><i class="fas fa-calendar text-teal-500 mt-1"></i><span>{{ __('site.Published') ?? 'Published' }}: <strong>{{ $targetItem->published_at?->format('M d, Y') }}</strong></span></li>
                            </ul>
                        </div>
                        @if($targetItem->video_id && $targetItem->video)
                        @php $videoUrl = $targetItem->video->url ?? $targetItem->video->getUrl(); @endphp
                        <div class="bg-teal-50 rounded-2xl p-6 border border-teal-100 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2"><i class="fas fa-play-circle text-teal-500"></i> {{ __('site.Video') ?? 'Video' }}</h3>
                            <div class="rounded-xl overflow-hidden shadow-lg aspect-video bg-black">
                                <video class="w-full h-full object-contain" controls src="{{ $videoUrl }}"></video>
                            </div>
                        </div>
                        @endif
                        @if($gallery->isNotEmpty())
                        <div class="bg-teal-50 rounded-2xl p-6 border border-teal-100 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2"><i class="fas fa-images text-teal-500"></i> {{ __('site.Photo_Gallery') ?? 'Photo Gallery' }}</h3>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($gallery as $media)
                                <img src="{{ $media->url ?? $media->getUrl() }}" alt="{{ $targetItem->title }}" class="rounded-lg w-full h-20 object-cover lightbox-img cursor-pointer hover:opacity-90 transition" onerror="this.style.display='none';">
                                @endforeach
                            </div>
                        </div>
                        @endif
                        {{-- <a href="{{ route('contact-us', ['locale' => $lng]) }}" class="block w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-xl transition shadow-md">{{ __('site.Get_a_Free_Quote') ?? 'Get a Free Quote' }}</a> --}}
                    </div>
                </div>
            </div>
        </section>
    </main>
    @endsection

    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('lightboxModal');
            const lbImg = document.getElementById('lightboxImg');
            const lbCaption = document.getElementById('lightboxCaption');
            const lbClose = document.getElementById('lightboxClose');
            const lbPrev = document.getElementById('lightboxPrev');
            const lbNext = document.getElementById('lightboxNext');
            let galleryImgs = [];
            let currentIndex = 0;
            function openLightbox(imgs, index) {
                galleryImgs = imgs;
                currentIndex = index;
                showSlide(currentIndex);
                modal.classList.remove('opacity-0', 'pointer-events-none');
                document.body.style.overflow = 'hidden';
            }
            function closeLightbox() {
                modal.classList.add('opacity-0', 'pointer-events-none');
                document.body.style.overflow = '';
            }
            function showSlide(i) {
                lbImg.src = galleryImgs[i].src;
                lbImg.alt = galleryImgs[i].alt || '';
                lbCaption.textContent = galleryImgs[i].alt || '';
                lbPrev.style.display = galleryImgs.length > 1 ? '' : 'none';
                lbNext.style.display = galleryImgs.length > 1 ? '' : 'none';
            }
            if (lbClose) lbClose.addEventListener('click', closeLightbox);
            if (modal) modal.addEventListener('click', (e) => { if (e.target === modal) closeLightbox(); });
            if (lbPrev) lbPrev.addEventListener('click', (e) => { e.stopPropagation(); currentIndex = (currentIndex - 1 + galleryImgs.length) % galleryImgs.length; showSlide(currentIndex); });
            if (lbNext) lbNext.addEventListener('click', (e) => { e.stopPropagation(); currentIndex = (currentIndex + 1) % galleryImgs.length; showSlide(currentIndex); });
            document.addEventListener('keydown', (e) => {
                if (!modal.classList.contains('pointer-events-none')) {
                    if (e.key === 'Escape') closeLightbox();
                    if (e.key === 'ArrowLeft') { currentIndex = (currentIndex - 1 + galleryImgs.length) % galleryImgs.length; showSlide(currentIndex); }
                    if (e.key === 'ArrowRight') { currentIndex = (currentIndex + 1) % galleryImgs.length; showSlide(currentIndex); }
                }
            });
            Array.from(document.querySelectorAll('.lightbox-img')).forEach((img, i, arr) => {
                img.addEventListener('click', () => openLightbox(arr, i));
            });
        });
    </script>
    @endpush
</x-layouts.layout>
