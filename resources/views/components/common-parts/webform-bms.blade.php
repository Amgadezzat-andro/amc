            <section class="card bg-soft-white border-0 h-100">
                <div class="row g-0">
                    <div class="col-md-6 m-auto">
                        <div
                            class="card-body d-flex flex-column gap-2 hero-text hero-start-section card-text primary-color">
                            <h3 class="card-title">{{ $targetBMS->title }}</h3>
                            <h6 class="card-text">
                                {{ $targetBMS->brief }}
                            </h6>
                            @if ($targetBMS->buttons?->first()?->url)
                            <div class="mt-4">
                                <a {!! Utility::printAllUrl($targetBMS->buttons?->first()?->url) !!}
                                    class="btn-border-outline d-flex justify-content-evenly align-items-center gap-2 mt-auto">
                                    {{ $targetBMS->buttons?->first()?->label }}
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-common.webp-image :allowWebpMobile="false" :allowWebpTablet="false" :mediaObject='$targetBMS->mainImage' alt='{{ $targetBMS->title }}'
                            imgClass="h-100 w-100 object-fit-cover" />

                    </div>
                </div>
            </section>
