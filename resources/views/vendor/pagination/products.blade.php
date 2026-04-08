@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex justify-center w-full px-4 sm:px-0">
        <div class="w-full max-w-full overflow-x-auto overflow-y-hidden rounded-2xl" style="-webkit-overflow-scrolling: touch;">
            <div class="inline-flex items-center gap-1 rounded-2xl bg-white px-2 py-2 shadow-md border border-gray-100 min-w-min">
            @if ($paginator->onFirstPage())
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-gray-400 cursor-default" aria-hidden="true">
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-sm"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-gray-600 hover:bg-teal-50 hover:text-teal-600 transition-colors" aria-label="Previous">
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-sm"></i>
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex h-10 min-w-[2.5rem] items-center justify-center rounded-xl px-2 text-gray-500">...</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="inline-flex h-10 min-w-[2.5rem] items-center justify-center rounded-xl bg-teal-500 font-bold text-white shadow-sm" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="inline-flex h-10 min-w-[2.5rem] items-center justify-center rounded-xl font-medium text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-colors" aria-label="Page {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-gray-600 hover:bg-teal-50 hover:text-teal-600 transition-colors" aria-label="Next">
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-sm"></i>
                </a>
            @else
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-gray-400 cursor-default" aria-hidden="true">
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-sm"></i>
                </span>
            @endif
            </div>
        </div>
    </nav>
@endif
