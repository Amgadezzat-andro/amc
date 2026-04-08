<x-layouts.layout seoTitle="{{ __('site.E-MOBILITY') ?? 'E-Mobility' }}">

    @section('content')
    @php $path = '/emobility'; @endphp
    <main>
        <x-common.header-image :innerItem="null" :getFromSpacificLink="$path" />

        <section class="py-24 section-white relative overflow-hidden w-full">
            <div class="w-full px-4 lg:px-8 relative z-10">
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-4xl lg:text-5xl font-bold mb-4 text-gray-900">{{ __('site.Our_Electric_Vehicles') ?? 'Our Electric Vehicles' }}</h2>
                    <p class="text-gray-700 text-xl">{{ __('site.Sustainable_mobility_solutions') ?? 'Sustainable mobility solutions for modern transportation' }}</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                    @foreach($vehicles as $vehicle)
                    @php $imgUrl = $vehicle->mainImage?->url ?? $vehicle->mainImage?->getUrl(); @endphp
                    <div class="vehicle-card bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 cursor-pointer group" onclick="window.location.href='{{ route('emobility-view', ['locale' => $lng, 'slug' => $vehicle->slug]) }}'">
                        <div class="w-full h-64 bg-cover bg-center group-hover:scale-105 transition-transform duration-500 overflow-hidden">
                            @if($imgUrl)
                            <img src="{{ $imgUrl }}" alt="{{ $vehicle->title }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentNode.style.background='linear-gradient(135deg,#0d9488,#2563eb)';">
                            @else
                            <div class="w-full h-full bg-gradient-to-br from-teal-500 to-blue-600 flex items-center justify-center"><i class="fas fa-bolt text-6xl text-white/80"></i></div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold mb-2 text-gray-900 group-hover:text-teal-600 transition-colors">{{ $vehicle->title }}</h3>
                            <p class="text-gray-700 mb-4">{{ Str::limit(strip_tags($vehicle->brief ?? ''), 100) }}</p>
                            <span class="text-teal-600 hover:text-teal-700 transition font-semibold inline-flex items-center">{{ __('site.View_Details') ?? 'View Details' }} <i class="fas fa-arrow-right ml-2"></i></span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
    @endsection
</x-layouts.layout>
