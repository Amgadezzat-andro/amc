<x-layouts.layout seoTitle="{{ __('site.PROJECTS') ?? 'Our Projects' }}">

    @section('content')
    @php $path = '/projects'; @endphp
    <main>
        <x-common.header-image :innerItem="null" :getFromSpacificLink="$path" />

        <section class="py-16 lg:py-24 bg-white">
            <div class="w-full px-4 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="projectsGrid">
                        @foreach($projects as $project)
                        @php $imgUrl = $project->mainImage?->url ?? $project->mainImage?->getUrl(); @endphp
                        <div class="project-card bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 cursor-pointer" onclick="window.location.href='{{ route('projects-view', ['locale' => $lng, 'slug' => $project->slug]) }}'">
                            <div class="w-full h-64 bg-cover bg-center" @if($imgUrl) style="background-image: url('{{ $imgUrl }}');" @else style="background: linear-gradient(135deg, #0d9488 0%, #2563eb 100%);" @endif></div>
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-2 text-gray-900">{{ $project->title }}</h3>
                                <p class="text-gray-700 mb-4">{{ Str::limit(strip_tags($project->brief ?? ''), 80) }}</p>
                                <span class="text-teal-600 hover:text-teal-700 transition font-semibold inline-flex items-center">{{ __('site.View_Details') ?? 'View Details' }} <i class="fas fa-arrow-right ml-2"></i></span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
    @endsection

</x-layouts.layout>
