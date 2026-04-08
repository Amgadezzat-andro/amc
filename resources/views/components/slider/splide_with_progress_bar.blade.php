@push('css')
    @once('splide_css')
        <link href="{{ asset('/css/splide.min.css') }}" type="text/css" rel="stylesheet"  />
        <link href="{{ asset('/css/splide-progress.css') }}" type="text/css" rel="stylesheet"  />
        <link href="{{ asset('/css/splide-pagination.css') }}" type="text/css" rel="stylesheet"
 />
    @endonce
@endpush

<div class="slider-wrapper splide-progress-wrapper">
    <div id="{{ $splideId }}"
        class="{{ $splideClass ?? '' }} splide splide--slide splide--ltr splide--draggable is-active is-overflow is-initialized "
        aria-label="{{ $splideId }} Slider" aria-roledescription="carousel" data-splide-pages="{{ $pages ?? 4 }}">

        @if (isset($brief) && $brief)
        <div class="main-title-section text-center primary-color">
            <h3 class="">{{ $brief }}</h3>
        </div>
        @endif

        <div id="{{ $splidTrackId }}"
            class="{{ $splideTrackClass ?? '' }} splide__track splide__track--slide splide__track--ltr splide__track--draggable doctors-splide-custom"
            aria-live="polite" aria-atomic="true" aria-busy="false">
            <ul id="{{ $ulSplideId }}" class="splide__list splide__list_custom {{ $ulSplideClass ?? '' }}"
                role="presentation">
                @foreach ($items as $index => $item)
                    <li id="progress-slide-{{ $item->slug }}-{{ $index }}"
                        class="splide__slide is-active is-visible {{ $liSplideClass ?? '' }}" role="group"
                        aria-roledescription="slide" aria-label="{{ $index }} of {{ count($items) }}">
                        {!! $splideContent($item) !!}
                    </li>
                @endforeach

            </ul>
        </div>

    </div>


    <div class="splide-progress-container position-relative container" data-items-number="{{ count($items) }}">
        <div class="d-flex gap-3">
            <button class="splide__arrow splide__arrow--prev" disabled="">
                <i class="fa-solid fa-chevron-{{$app->getLocale() === 'ar' ? 'right' : 'left'}}"></i>
            </button>
            <button class="splide__arrow splide__arrow--next">
                <i class="fa-solid fa-chevron-{{$app->getLocale() === 'ar' ? 'left' : 'right'}}"></i>
            </button>
        </div>

        <div class="splide-progress">
            <div class="splide-progress-bar w-5"></div>
        </div>
    </div>


</div>


@push('js')
    @once('splide_js')
        <script src="{{ asset('/js/splide-progress.js') }}" ></script>
        <script src="{{ asset('/js/splide.min.js') }}" ></script>
    @endonce

    @once('splide_script_progress')
        <script >
            $(document).ready(function() {

                let isRTL = $("body").hasClass("arabic-version") ? "rtl" : "ltr";

                document.querySelectorAll(".splide-progress-wrapper").forEach((wrapper) => {
                    const splideElement = wrapper.querySelector(".splide");
                    const progressBar = wrapper.querySelector(".splide-progress-bar");
                    const prevBtn = wrapper.querySelector(".splide__arrow--prev");
                    const nextBtn = wrapper.querySelector(".splide__arrow--next");

                    const pages = parseFloat(splideElement.dataset.splidePages) || 4;

                    // console.log(pages);

                    const splide = new Splide(splideElement, {
                        type: "slide",
                        gap: "1rem",
                        focus: "start",
                        pagination: false,
                        direction: isRTL,
                        arrows: false,
                        autoplay: true,
                        interval: 3200,
                        perPage: pages,
                        perMove: 1,
                        breakpoints: {
                            1199.98: {
                                perPage: 3
                            },
                            991.98: {
                                perPage: 2
                            },
                            767.98: {
                                perPage: 1
                            }, // md
                        },
                    });

                    function updateProgressAndButtons() {
                        const total = splide.length;
                        const index = splide.index;
                        const perPage = splide.options.perPage;

                        const maxIndex = total - perPage;

                        let percentage = 5 + (index / maxIndex) * 95;
                        if (percentage > 100) percentage = 100;
                        progressBar.style.width = `${percentage}%`;

                        prevBtn.disabled = index <= 0;
                        nextBtn.disabled = index >= maxIndex;
                    }

                    splide.on("mounted move", updateProgressAndButtons);

                    prevBtn.addEventListener("click", () => splide.go("<"));
                    nextBtn.addEventListener("click", () => splide.go(">"));

                    splide.mount();
                });


                $(".splide-progress-container").each(function() {
                    let counter = $(this).attr("data-items-number");
                    let screenWidth = $(window).width();
                    if (
                        (counter <= 4 && screenWidth > 1199) ||
                        (counter <= 3 && screenWidth > 991) ||
                        (counter <= 2 && screenWidth > 767) ||
                        (counter <= 1 && screenWidth > 0)
                    ) {
                        $(this).addClass("d-none");
                    }
                });

            });
        </script>
    @endonce
@endpush
