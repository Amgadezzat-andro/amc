<x-layouts.layout seoTitle="{{ $project->title }}" seoDescription="{{ $project->brief }}"
    seoImage="{{ $project->mainImage?->url ?? $project->mainImage?->getUrl() }}">

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
        @php $heroUrl = $project->mainImage?->url ?? $project->mainImage?->getUrl(); @endphp
        <div class="w-full relative">
            <div class="w-full h-[55vh] lg:h-[70vh] bg-cover bg-center relative" @if($heroUrl) style="background-image: url('{{ $heroUrl }}');" @else style="background: linear-gradient(to right, #0d9488, #2563eb);" @endif>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 px-6 lg:px-16 pb-10">
                    <a href="{{ route('projects-index', ['locale' => $lng]) }}" class="inline-flex items-center text-white/80 hover:text-teal-400 transition mb-4 text-sm">
                        <i class="fas fa-arrow-left mr-2"></i> {{ __('site.Back_to_Projects') ?? 'Back to Projects' }}
                    </a>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-white/70 text-sm">{{ $project->published_at?->format('Y') }}</span>
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-bold text-white drop-shadow-lg">{{ $project->title }}</h1>
                </div>
            </div>
        </div>

        <section class="w-full bg-white py-12">
            <div class="w-full px-6 lg:px-16">
                <div class="grid lg:grid-cols-3 gap-10">
                    <div class="lg:col-span-2">
                        <div class="prose prose-lg max-w-none mb-8">
                            @if($project->brief)
                            <p class="text-xl text-gray-700 leading-relaxed mb-6">{{ $project->brief }}</p>
                            @endif
                            {!! Content::inlineStyleToClasses($project->content ?? '') !!}
                            @php $gallery = $project->galleryMedia(); @endphp
                            @if($gallery->isNotEmpty())
                            <div class="grid md:grid-cols-2 gap-6 my-8">
                                @foreach($gallery as $media)
                                <img src="{{ $media->url ?? $media->getUrl() }}" alt="{{ $project->title }}" class="rounded-xl shadow-lg w-full object-cover lightbox-img cursor-pointer hover:opacity-90 transition" onerror="this.style.display='none';">
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="border-t border-gray-200 pt-6 mt-8">
                            <div class="flex items-center justify-between flex-wrap gap-4">
                                <div class="flex items-center space-x-4">
                                    <span class="text-gray-600 font-medium">{{ __('site.Share') ?? 'Share' }}:</span>
                                    @php $pageUrl = url()->current(); $pageTitle = e($project->title); @endphp
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($pageUrl) }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-teal-600 transition"><i class="fab fa-facebook text-xl"></i></a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode($pageUrl) }}&text={{ urlencode($pageTitle) }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-teal-600 transition"><i class="fab fa-twitter text-xl"></i></a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($pageUrl) }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-teal-600 transition"><i class="fab fa-linkedin text-xl"></i></a>
                                </div>
                                <a href="{{ route('projects-index', ['locale' => $lng]) }}" class="text-teal-600 hover:text-teal-700 transition font-semibold">{{ __('site.View_All_Projects') ?? 'View All Projects' }} →</a>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-1 space-y-6">
                        @if($project->specifications && count($project->specifications) > 0)
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2"><i class="fas fa-cog text-teal-500"></i> {{ __('site.Project_Specifications') ?? 'Project Specifications' }}</h3>
                            <ul class="space-y-3 text-gray-700">
                                @foreach($project->specifications as $spec)
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-teal-500 mt-1"></i><span>@if(!empty($spec['key']))<strong>{{ $spec['key'] }}:</strong> @endif{{ $spec['value'] ?? '' }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if($project->benefits && count($project->benefits) > 0)
                        <div class="bg-teal-50 rounded-2xl p-6 border border-teal-100 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2"><i class="fas fa-leaf text-teal-500"></i> {{ __('site.Project_Benefits') ?? 'Project Benefits' }}</h3>
                            <ul class="space-y-3 text-gray-700">
                                @foreach($project->benefits as $benefit)
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-teal-500 mt-1"></i><span>@if(!empty($benefit['key']))<strong>{{ $benefit['key'] }}:</strong> @endif{{ $benefit['value'] ?? '' }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <a href="{{ route('get-a-quote', ['locale' => $lng]) }}" class="block w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-xl transition shadow-md">{{ __('site.Get_a_Similar_Quote') ?? 'Get a Similar Quote' }}</a>
                    </div>
                </div>
            </div>
        </section>

        @if($project->video_id && $project->video)
        @php $videoUrl = $project->video->url ?? $project->video->getUrl(); @endphp
        <section class="w-full">
            <div class="w-full">
                <div class="relative w-full overflow-hidden" style="max-height:80vh;">
                    <video class="w-full block" controls style="max-height:80vh; object-fit:cover; display:block;" preload="auto">
                        <source src="{{ $videoUrl }}" type="video/mp4">
                    </video>
                </div>
            </div>
        </section>
        @endif
    </main>
    @endsection

    @push('js')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('lightboxModal');
        var lbImg = document.getElementById('lightboxImg');
        var lbCaption = document.getElementById('lightboxCaption');
        var lbClose = document.getElementById('lightboxClose');
        var lbPrev = document.getElementById('lightboxPrev');
        var lbNext = document.getElementById('lightboxNext');
        var galleryImgs = [];
        var currentIndex = 0;
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
        if (modal) modal.addEventListener('click', function(e) { if (e.target === modal) closeLightbox(); });
        if (lbPrev) lbPrev.addEventListener('click', function(e) { e.stopPropagation(); currentIndex = (currentIndex - 1 + galleryImgs.length) % galleryImgs.length; showSlide(currentIndex); });
        if (lbNext) lbNext.addEventListener('click', function(e) { e.stopPropagation(); currentIndex = (currentIndex + 1) % galleryImgs.length; showSlide(currentIndex); });
        document.addEventListener('keydown', function(e) {
            if (!modal.classList.contains('pointer-events-none')) {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') { currentIndex = (currentIndex - 1 + galleryImgs.length) % galleryImgs.length; showSlide(currentIndex); }
                if (e.key === 'ArrowRight') { currentIndex = (currentIndex + 1) % galleryImgs.length; showSlide(currentIndex); }
            }
        });
        Array.from(document.querySelectorAll('.lightbox-img')).forEach(function(img, i, arr) {
            img.addEventListener('click', function() { openLightbox(arr, i); });
        });
    });
    </script>
    @endpush
</x-layouts.layout>
