<div class="container">
    <div class="d-flex justify-content-center">

        @if ($paginator->hasPages())
            <nav>
                <ul class="pagination customPagination">
                    {{-- Previous Page Link --}}

                    <li class="page-item @if ($paginator->onFirstPage()) disabled @endif" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <a class="page-link arrow" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">
                                <i class="fa-solid fa-chevron-{{app()->getLocale()== 'ar'?'right':'left'}}"></i>
                            </span>
                        </a>
                    </li>

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)

                                <li class="page-item @if ($page == $paginator->currentPage()) active @endif">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>

                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    <li class="page-item @if (!$paginator->hasMorePages()) disabled @endif">
                        <a class="page-link arrow" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">
                                <i class="fa-solid fa-chevron-{{app()->getLocale()== 'ar'?'left':'right'}}"></i>
                            </span>
                        </a>
                    </li>


                </ul>
            </nav>
        @endif

    </div>
</div>
