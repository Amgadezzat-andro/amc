    @foreach ($links as $link)
        <a {!! Utility::printAllUrl($link->url) !!} class="d-flex align-items-center gap-2 text-white text-decoration-none">
            <div class="virtual-tour">
                <x-common.webp-image :mediaObject='$link->mainImage' :alt='__('site.TRANSLATE')' imgClass="default-image-class" :allowWebpMobile="false"
                    :allowWebpTablet="false" />
            </div>
            <h6> {{ $link->label }} </h6>
        </a>
    @endforeach
