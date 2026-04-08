<x-layouts.layout seoTitle="{{ $vehicle->title }}" seoDescription="{{ $vehicle->brief }}"
    seoImage="{{ $vehicle->mainImage?->url ?? $vehicle->mainImage?->getUrl() }}">

    @section('content')
    @php
        $heroUrl = $vehicle->mainImage?->url ?? $vehicle->mainImage?->getUrl();
        $gallery = $vehicle->galleryMedia();
        $sliderUrls = $gallery->isNotEmpty() ? $gallery->map(fn($m) => $m->url ?? $m->getUrl())->values()->all() : ($heroUrl ? [$heroUrl] : []);
    @endphp
    <main>
        <section class="relative w-full h-[60vh] lg:h-[70vh] overflow-hidden">
            <div class="absolute inset-0">
                @if($heroUrl)
                <img src="{{ $heroUrl }}" alt="{{ $vehicle->title }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full bg-gradient-to-br from-teal-600 to-blue-600"></div>
                @endif
            </div>
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900/70 via-teal-900/60 to-blue-900/70"></div>
            <div class="relative z-10 h-full flex items-center justify-center text-center px-4">
                <div class="fade-in max-w-5xl">
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-white mb-6 leading-tight">{{ $vehicle->title }}</h1>
                    <p class="text-xl lg:text-2xl text-white/90 max-w-3xl mx-auto font-light">{{ __('site.Sustainable_mobility_world') ?? 'Sustainable mobility for the modern world' }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-white to-transparent"></div>
        </section>

        <section class="py-16 lg:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-start">
                    <div class="fade-in">
                        @if(count($sliderUrls) > 0)
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold mb-4 text-gray-900">{{ __('site.Vehicle_Images') ?? 'Vehicle Images' }}</h3>
                            <div class="relative">
                                <div id="vehicleSlider" class="relative w-full h-96 rounded-2xl overflow-hidden shadow-lg">
                                    <div id="sliderImages" class="flex transition-transform duration-500 ease-in-out h-full"></div>
                                </div>
                                @if(count($sliderUrls) > 1)
                                <button type="button" id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-900 rounded-full p-3 shadow-lg transition z-10"><i class="fas fa-chevron-left"></i></button>
                                <button type="button" id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-900 rounded-full p-3 shadow-lg transition z-10"><i class="fas fa-chevron-right"></i></button>
                                <div id="sliderDots" class="flex justify-center mt-4 space-x-2"></div>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if(($vehicle->specifications && count($vehicle->specifications) > 0) || $vehicle->brief)
                        <div class="content-block mb-8 fade-in">
                            <div class="flex items-start space-x-6 mb-6">
                                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-cog text-2xl text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ __('site.Specifications') ?? 'Specifications' }}</h3>
                                    <div class="w-16 h-1 bg-gradient-to-r from-teal-500 to-blue-500 mb-6"></div>
                                </div>
                            </div>
                            @if($vehicle->specifications && count($vehicle->specifications) > 0)
                            <p class="text-gray-700 text-lg leading-relaxed">
                                @foreach($vehicle->specifications as $spec)
                                {{ $spec['key'] ?? '' }}: {{ $spec['value'] ?? '' }}.
                                @endforeach
                            </p>
                            @else
                            <p class="text-gray-700 text-lg leading-relaxed">{{ $vehicle->brief }}</p>
                            @endif
                        </div>
                        @endif
                    </div>
                    <div class="fade-in">
                        @if($vehicle->features && count($vehicle->features) > 0)
                        <div class="bg-gray-50 rounded-2xl p-8 border border-gray-200">
                            <h3 class="text-2xl font-bold mb-6 text-gray-900">{{ __('site.Features') ?? 'Features' }}</h3>
                            <ul class="space-y-4" id="featuresList">
                                @foreach($vehicle->features as $f)
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-teal-500 mr-3 mt-1 text-xl"></i>
                                    <span class="text-gray-800">{{ $f['value'] ?? $f['key'] ?? '' }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="mt-8">
                            <a href="{{ route('get-a-quote', ['locale' => $lng]) }}" class="btn-orange-gradient px-8 py-4 rounded-lg transition font-semibold inline-block text-center w-full">{{ __('site.Get_a_Quote') ?? 'Get a Quote' }}</a>
                            <a href="{{ route('swapping-stations-index', ['locale' => $lng]) }}" class="mt-4 px-8 py-4 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-semibold inline-block text-center w-full">
                                {{ __('site.Find_Swapping_Stations') ?? 'Find Swapping Stations' }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
    @endsection

    @if(count($sliderUrls) > 0)
    @push('js')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var sliderImages = document.getElementById('sliderImages');
        var sliderDots = document.getElementById('sliderDots');
        var prevBtn = document.getElementById('prevBtn');
        var nextBtn = document.getElementById('nextBtn');
        if (!sliderImages) return;
        var images = @json($sliderUrls);
        var title = @json($vehicle->title);
        if (images.length === 0) return;
        sliderImages.innerHTML = images.map(function(img, index) {
            return '<div class="min-w-full h-full"><img src="' + img + '" alt="' + title + ' ' + (index + 1) + '" class="w-full h-full object-cover"></div>';
        }).join('');
        var currentSlide = 0;
        function updateSlider() {
            sliderImages.style.transform = 'translateX(-' + currentSlide * 100 + '%)';
            if (sliderDots) sliderDots.querySelectorAll('button').forEach(function(dot, i) {
                dot.classList.toggle('bg-teal-600', i === currentSlide);
                dot.classList.toggle('bg-gray-300', i !== currentSlide);
            });
        }
        if (images.length > 1 && sliderDots) {
            sliderDots.innerHTML = images.map(function(_, i) {
                return '<button type="button" class="w-3 h-3 rounded-full transition ' + (i === 0 ? 'bg-teal-600' : 'bg-gray-300') + '" data-index="' + i + '"></button>';
            }).join('');
            prevBtn && prevBtn.addEventListener('click', function() { currentSlide = (currentSlide - 1 + images.length) % images.length; updateSlider(); });
            nextBtn && nextBtn.addEventListener('click', function() { currentSlide = (currentSlide + 1) % images.length; updateSlider(); });
            sliderDots.querySelectorAll('button').forEach(function(dot, i) {
                dot.addEventListener('click', function() { currentSlide = i; updateSlider(); });
            });
        }
        updateSlider();
    });
    </script>
    @endpush
    @endif
</x-layouts.layout>
