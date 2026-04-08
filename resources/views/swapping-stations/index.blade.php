<x-layouts.layout seoTitle="{{ __('Battery Swapping Stations') ?? 'Swapping Stations' }}">

    @push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <style>
        #swapping-map { height: 600px; width: 100%; border-radius: 1rem; z-index: 1; }
        .leaflet-popup-content-wrapper { border-radius: 0.5rem; }
    </style>
    @endpush

    @section('content')
    @php $path = '/swapping-stations'; @endphp
    <main>
        <x-common.header-image :innerItem="null" :getFromSpacificLink="$path" />

        <section class="py-16 lg:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="mb-12 text-center fade-in">
                    <h2 class="text-4xl lg:text-5xl font-bold mb-4 text-gray-900">{{ __('Find a Station Near You') }}</h2>
                    <p class="text-gray-700 text-xl">{{ __('Locate battery swapping stations across Tanzania') }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-6 lg:p-8 fade-in">
                    <div id="swapping-map"></div>
                </div>
                <div class="mt-12 grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="stationsList">
                    @foreach($stations as $station)
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-start mb-4">
                            <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4 shrink-0">
                                <i class="fas fa-charging-station text-teal-600 text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $station->name }}</h3>
                                @if($station->address)
                                <p class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt text-teal-600 mr-2"></i>{{ $station->address }}</p>
                                @endif
                                @if($station->hours)
                                <p class="text-gray-500 text-sm"><i class="fas fa-clock text-teal-600 mr-2"></i>{{ $station->hours }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
    @endsection

    @push('js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var stations = @json($stationsJson);
        var center = stations.length ? [stations[0].lat, stations[0].lng] : [-6.7924, 39.2083];
        var zoom = stations.length === 0 ? 6 : (stations.length === 1 ? 14 : 7);
        var map = L.map('swapping-map').setView(center, zoom);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(map);
        stations.forEach(function(station) {
            var marker = L.marker([station.lat, station.lng]).addTo(map);
            var popup = '<div class="p-2"><h3 class="font-bold text-lg text-gray-900 mb-2">' + (station.name || '') + '</h3>';
            if (station.address) popup += '<p class="text-gray-700 mb-2"><i class="fas fa-map-marker-alt text-teal-600 mr-2"></i>' + station.address + '</p>';
            if (station.hours) popup += '<p class="text-gray-600"><i class="fas fa-clock text-teal-600 mr-2"></i>' + station.hours + '</p>';
            popup += '</div>';
            marker.bindPopup(popup);
        });
    });
    </script>
    @endpush
</x-layouts.layout>
