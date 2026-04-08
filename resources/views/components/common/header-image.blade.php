@php $imgUrl = isset($image) && $image ? (method_exists($image, 'getUrl') ? $image->getUrl() : ($image->url ?? null)) : null; @endphp
<section class="relative w-full h-[50vh] lg:h-[60vh] overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-r from-teal-600 to-blue-600"></div>
        @if($imgUrl)
            <img src="{{ $imgUrl }}" alt="{{ $title ?? '' }}" class="absolute inset-0 w-full h-full object-cover" onerror="this.style.display='none'">
        @endif
    </div>
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/70 via-teal-900/60 to-blue-900/70"></div>
    <div class="relative z-10 h-full flex items-center justify-center text-center px-4">
        <div class="fade-in max-w-5xl">
            @if(!empty($title))
            <h1 class="text-5xl lg:text-7xl font-extrabold text-white mb-6 leading-tight">
                <span class="bg-gradient-to-r from-white via-teal-100 to-blue-100 bg-clip-text text-transparent">{{ $title }}</span>
            </h1>
            @endif
            @if(!empty($brief))
            <p class="text-xl lg:text-2xl text-white/90 max-w-3xl mx-auto font-light">{{ $brief }}</p>
            @endif
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-white to-transparent"></div>
</section>
