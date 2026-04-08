<x-layouts.layout seoTitle="{{ $product->title }}" seoDescription="{{ $product->brief }}"
    seoImage="{{ $product->mainImage?->url ?? $product->mainImage?->getUrl() }}">

    @section('content')
    @php
        $imgUrl = $product->mainImage?->url ?? $product->mainImage?->getUrl();
        $specsText = $product->specifications ? collect($product->specifications)->map(fn($s) => ($s['key'] ?? '').': '.($s['value'] ?? ''))->implode(' | ') : $product->brief;
    @endphp
    <main class="py-12 lg:py-16">
        <div class="max-w-4xl mx-auto px-4 lg:px-8">
            <a href="{{ route('products-index', ['locale' => $lng]) }}" class="inline-flex items-center text-teal-600 hover:text-teal-700 mb-8 text-sm font-medium"><i class="fas fa-arrow-left mr-2"></i>{{ __('site.Back_to_Products') ?? 'Back to Products' }}</a>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <div class="aspect-[16/10] bg-gray-100">
                    @if($imgUrl)
                    <img src="{{ $imgUrl }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center"><i class="fas fa-cube text-6xl text-gray-300"></i></div>
                    @endif
                </div>
                <div class="p-8">
                    @if($product->category)
                    <span class="inline-block px-3 py-1.5 bg-teal-500 text-white text-xs font-bold rounded-full uppercase mb-4">{{ $product->category->title }}</span>
                    @endif
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $product->title }}</h1>
                    @if($product->brand)
                    <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full mb-4"><i class="fas fa-tag mr-1.5"></i>{{ $product->brand->title }}</span>
                    @endif
                    @if($product->brief)
                    <p class="text-gray-700 text-lg mb-6">{{ $product->brief }}</p>
                    @endif
                    @if($specsText)
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">{{ __('site.Specifications') ?? 'Specifications' }}</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $specsText }}</p>
                    </div>
                    @endif
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('get-a-quote', ['locale' => $lng]) }}" class="px-6 py-3.5 bg-gradient-to-r from-teal-500 to-blue-500 text-white rounded-xl font-bold hover:from-teal-600 hover:to-blue-600 transition-all">{{ __('site.Get_a_Quote') ?? 'Get a Quote' }}</a>
                        <a href="tel:+255746022022" class="px-6 py-3.5 border-2 border-gray-200 text-gray-700 rounded-xl font-bold hover:border-teal-400 hover:text-teal-600 transition-all">{{ __('site.Call_Us') ?? 'Call Us' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @endsection
</x-layouts.layout>
