<x-layouts.layout seoTitle="{{ __('site.PRODUCTS') ?? 'Products' }}">

    @section('content')
    @php $path = '/products'; @endphp
    <main>
        <x-common.header-image :innerItem="null" :getFromSpacificLink="$path" />

        <section class="py-16 lg:py-24 bg-gray-50 relative" id="productsSection">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                    <aside class="lg:w-72 flex-shrink-0">
                        <div class="lg:sticky lg:top-28">
                            <button id="filterToggle" class="lg:hidden w-full flex items-center justify-between bg-white rounded-2xl px-6 py-4 shadow-md border border-gray-100 mb-4">
                                <span class="font-bold text-gray-800"><i class="fas fa-sliders-h mr-2 text-teal-600"></i>Filters</span>
                                <i class="fas fa-chevron-down text-gray-400 transition-transform" id="filterArrow"></i>
                            </button>
                            <div id="filterPanel" class="hidden lg:block space-y-6">
                                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
                                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                                        <span class="w-8 h-8 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center mr-3"><i class="fas fa-th-list text-white text-xs"></i></span>
                                        {{ __('site.Categories') ?? 'Categories' }}
                                    </h3>
                                    <div class="space-y-1" id="categoryFilters">
                                        @php
                                            $baseUrl = route('products-index', ['locale' => $lng]);
                                            $qAll = array_filter(['brand' => request('brand')]);
                                            $qAllStr = $qAll ? '?' . http_build_query($qAll) : '';
                                        @endphp
                                        <a href="{{ $baseUrl }}{{ $qAllStr }}" class="category-btn w-full text-left px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 flex items-center group {{ !$currentCategory ? 'active' : '' }}" data-category="all">
                                            <span class="w-2 h-2 rounded-full bg-teal-500 mr-3 group-hover:scale-125 transition-transform"></span>
                                            {{ __('site.All_Products') ?? 'All Products' }}
                                            <span class="ml-auto text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full product-count" data-cat="all">{{ $productsTotal }}</span>
                                        </a>
                                        @foreach($productCategories as $cat)
                                        @php $qCat = array_filter(['category' => $cat->id, 'brand' => request('brand')]); @endphp
                                        <a href="{{ $baseUrl }}?{{ http_build_query($qCat) }}" class="category-btn w-full text-left px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 flex items-center group {{ $currentCategory == $cat->id ? 'active' : '' }}" data-category="{{ $cat->id }}">
                                            <span class="w-2 h-2 rounded-full bg-teal-500 mr-3 group-hover:scale-125 transition-transform"></span>
                                            {{ $cat->title }}
                                            <span class="ml-auto text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full product-count" data-cat="{{ $cat->id }}">{{ $categoryCounts[$cat->id] ?? 0 }}</span>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
                                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                                        <span class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3"><i class="fas fa-tag text-white text-xs"></i></span>
                                        {{ __('site.Brand') ?? 'Brand' }}
                                    </h3>
                                    <select id="brandFilter" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-sm font-medium text-gray-700 bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 outline-none transition-all cursor-pointer appearance-none" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2220%22%20height%3D%2220%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20fill%3D%22%236b7280%22%20d%3D%22M7%207l3%203%203-3%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px;">
                                        @php $qNoBrand = array_filter(['category' => request('category')]); @endphp
                                        <option value="{{ $baseUrl }}{{ $qNoBrand ? '?' . http_build_query($qNoBrand) : '' }}" {{ !$currentBrand ? 'selected' : '' }}>{{ __('site.All_Brands') ?? 'All Brands' }}</option>
                                        @foreach($productBrands as $b)
                                        @php $qBrand = array_filter(['category' => request('category'), 'brand' => $b->id]); @endphp
                                        <option value="{{ $baseUrl }}?{{ http_build_query($qBrand) }}" {{ $currentBrand == $b->id ? 'selected' : '' }}>{{ $b->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <div class="flex-1">
                        <div class="relative mb-6">
                            <input type="text" id="productSearch" placeholder="{{ __('site.Search_products') ?? 'Search products...' }}" class="w-full px-5 py-4 pl-12 border-2 border-gray-200 rounded-2xl text-sm font-medium text-gray-700 bg-white focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 outline-none transition-all shadow-md">
                            <i class="fas fa-search absolute left-4.5 top-1/2 -translate-y-1/2 text-gray-400 text-base"></i>
                        </div>
                        <div class="flex flex-wrap items-center justify-between mb-8 gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900" id="activeCategory">
                                    @if($currentCategory && $productCategories->firstWhere('id', $currentCategory))
                                        {{ $productCategories->firstWhere('id', $currentCategory)->title }}
                                    @else
                                        {{ __('site.All_Products') ?? 'All Products' }}
                                    @endif
                                </h2>
                                <p class="text-sm text-gray-500 mt-1"><span id="productCountText">{{ $products->total() }}</span> {{ __('site.products_found') ?? 'products found' }}</p>
                            </div>
                            @if($currentCategory || $currentBrand)
                            <a href="{{ $baseUrl }}" id="resetFilters" class="inline-flex px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:border-teal-300 transition-all shadow-sm"><i class="fas fa-times mr-2"></i>{{ __('site.Clear_Filters') ?? 'Clear Filters' }}</a>
                            @else
                            <span id="resetFilters" class="hidden"></span>
                            @endif
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6" id="productsGrid">
                            @foreach($products as $product)
                            @php
                                $imgUrl = $product->mainImage?->url ?? $product->mainImage?->getUrl() ?? $logo?->url ?? $logo?->getUrl() ?? null;
                                $specsText = $product->specifications ? collect($product->specifications)->map(fn($s) => ($s['key'] ?? '').': '.($s['value'] ?? ''))->implode(' | ') : Str::limit(strip_tags($product->brief ?? ''), 80);
                            @endphp
                            <div class="product-card group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl border border-gray-100 hover:border-teal-200 transition-all duration-500 cursor-pointer transform hover:-translate-y-2" data-id="{{ $product->id }}" data-category-id="{{ $product->category_id ?? '' }}" data-brand-id="{{ $product->brand_id ?? '' }}" data-title="{{ e($product->title) }}" data-specs="{{ e($specsText) }}" data-brand-name="{{ e($product->brand->title ?? '') }}" data-category-name="{{ e($product->category->title ?? '') }}" data-image="{{ $imgUrl }}" data-specs-html="{{ e($specsText) }}">
                                <div class="relative overflow-hidden aspect-[4/3]">
                                    @if($imgUrl)
                                    <img src="{{ $imgUrl }}" alt="{{ $product->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                                    @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center"><i class="fas fa-cube text-4xl text-gray-400"></i></div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="absolute top-3 left-3 product-card-category">
                                        @if($product->category)
                                        <span class="px-2.5 py-1 bg-teal-500/90 backdrop-blur-md text-white text-[10px] font-bold rounded-full uppercase tracking-wider">{{ $product->category->title }}</span>
                                        @endif
                                    </div>
                                    <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                        <span class="w-10 h-10 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg"><i class="fas fa-arrow-right text-teal-600 text-sm"></i></span>
                                    </div>
                                </div>
                                <div class="p-5">
                                    @if($product->brand)
                                    <span class="inline-block px-2 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full mb-2">{{ $product->brand->title }}</span>
                                    @endif
                                    <h3 class="font-bold text-gray-900 text-sm leading-snug mb-2 line-clamp-2 group-hover:text-teal-700 transition-colors">{{ $product->title }}</h3>
                                    <p class="text-xs text-gray-500 line-clamp-1">{{ $specsText }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-8 flex justify-center">
                            {{ $products->links('vendor.pagination.products') }}
                        </div>
                        <div class="hidden text-center py-20" id="noResults">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-search text-3xl text-gray-300"></i></div>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">{{ __('site.No_products_found') ?? 'No products found' }}</h3>
                            <p class="text-gray-500">{{ __('site.Try_adjusting_filters') ?? 'Try adjusting your filters or search query' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div id="productModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modalOverlay"></div>
        <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto" id="modalContent">
                <div class="relative">
                    <div class="aspect-[16/10] bg-gray-100 rounded-t-3xl overflow-hidden">
                        <img id="modalImage" src="" alt="" class="w-full h-full object-cover">
                    </div>
                    <button id="modalClose" class="absolute top-4 right-4 w-10 h-10 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg hover:bg-white hover:scale-110 transition-all" aria-label="Close"><i class="fas fa-times text-gray-700"></i></button>
                </div>
                <div class="p-8">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 id="modalTitle" class="text-2xl lg:text-3xl font-extrabold text-gray-900 mb-2"></h2>
                            <span id="modalBrand" class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full"></span>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 pt-6 mt-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">{{ __('site.Specifications') ?? 'Specifications' }}</h3>
                        <p id="modalSpecs" class="text-gray-700 text-lg leading-relaxed"></p>
                    </div>
                    <div class="border-t border-gray-100 pt-6 mt-6">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">{{ __('site.Category') ?? 'Category' }}</h3>
                        <p id="modalCatName" class="text-gray-700"></p>
                    </div>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('get-a-quote', ['locale' => $lng]) }}" class="flex-1 min-w-[180px] px-6 py-3.5 bg-gradient-to-r from-teal-500 to-blue-500 text-white rounded-xl font-bold text-center hover:from-teal-600 hover:to-blue-600 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5"><i class="fas fa-envelope mr-2"></i>{{ __('site.Get_a_Quote') ?? 'Get a Quote' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('js')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var grid = document.getElementById('productsGrid');
        var noResults = document.getElementById('noResults');
        var brandFilter = document.getElementById('brandFilter');
        var searchInput = document.getElementById('productSearch');
        var productCountText = document.getElementById('productCountText');
        var filterToggle = document.getElementById('filterToggle');
        var filterPanel = document.getElementById('filterPanel');
        var filterArrow = document.getElementById('filterArrow');
        var modal = document.getElementById('productModal');
        var modalOverlay = document.getElementById('modalOverlay');
        var modalClose = document.getElementById('modalClose');
        var modalImage = document.getElementById('modalImage');
        var modalTitle = document.getElementById('modalTitle');
        var modalBrand = document.getElementById('modalBrand');
        var modalSpecs = document.getElementById('modalSpecs');
        var modalCatName = document.getElementById('modalCatName');

        var searchQuery = '';
        var serverCategoryAll = {{ $currentCategory ? 'false' : 'true' }};

        function getVisibleCards() {
            var cards = grid.querySelectorAll('.product-card');
            if (!searchQuery) return Array.from(cards);
            var q = searchQuery.toLowerCase();
            return Array.from(cards).filter(function(card) {
                return (card.dataset.title && card.dataset.title.toLowerCase().indexOf(q) >= 0) || (card.dataset.specs && card.dataset.specs.toLowerCase().indexOf(q) >= 0) || (card.dataset.brandName && card.dataset.brandName.toLowerCase().indexOf(q) >= 0);
            });
        }

        function renderProducts() {
            var visible = getVisibleCards();
            productCountText.textContent = visible.length;
            grid.querySelectorAll('.product-card').forEach(function(card) {
                var show = visible.indexOf(card) >= 0;
                card.style.display = show ? '' : 'none';
                var badge = card.querySelector('.product-card-category');
                if (badge) badge.style.display = serverCategoryAll ? '' : 'none';
            });
            noResults.classList.toggle('hidden', visible.length > 0);
        }

        if (brandFilter) brandFilter.addEventListener('change', function() {
            var url = this.options[this.selectedIndex].value;
            if (url) window.location.href = url;
        });

        var searchTimeout;
        if (searchInput) searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                searchQuery = searchInput.value.trim();
                renderProducts();
            }, 250);
        });

        if (filterToggle && filterPanel) filterToggle.addEventListener('click', function() {
            filterPanel.classList.toggle('hidden');
            if (filterArrow) filterArrow.classList.toggle('rotate-180');
        });

        renderProducts();

        grid.addEventListener('click', function(e) {
            var card = e.target.closest('.product-card');
            if (!card) return;
            modalImage.src = card.dataset.image || '';
            modalImage.alt = card.dataset.title || '';
            modalTitle.textContent = card.dataset.title || '';
            modalBrand.innerHTML = '<i class="fas fa-tag mr-1.5"></i>' + (card.dataset.brandName || '');
            modalSpecs.textContent = card.dataset.specsHtml || card.dataset.specs || '';
            modalCatName.textContent = card.dataset.categoryName || '';
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
        if (modalClose) modalClose.addEventListener('click', closeModal);
        if (modalOverlay) modalOverlay.addEventListener('click', closeModal);
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal(); });
    });
    </script>
    @endpush
</x-layouts.layout>
