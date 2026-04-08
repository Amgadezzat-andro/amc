<main>
    @php $path = '/about-us'; @endphp
    <x-common.header-image :innerItem="null" :getFromSpacificLink="$path" />

    @if(isset($who_we_are) && $who_we_are)
    <section class="py-32 relative overflow-hidden w-full bg-gradient-to-b from-white via-gray-50/50 to-white">
        <div class="w-full px-4 lg:px-8 relative z-10">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-20 items-center mb-32">
                    <div class="fade-in order-2 lg:order-1">
                        <div class="mb-8">
                            @if($who_we_are->title)
                            <span class="text-sm font-semibold text-teal-600 uppercase tracking-wider mb-4 block">{{ $who_we_are->title }}</span>
                            @endif
                            @if($who_we_are->second_title)
                            <h2 class="text-5xl lg:text-6xl font-extrabold mb-6 text-gray-900 leading-tight">
                                <span class="bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent">{{ $who_we_are->second_title }}</span>
                            </h2>
                            @endif
                            <div class="w-20 h-1 bg-gradient-to-r from-teal-500 to-blue-500 mb-8"></div>
                        </div>
                        <div class="space-y-6 text-lg text-gray-700 leading-relaxed">
                            {!! \App\Classes\Content::inlineStyleToClasses($who_we_are->content ?? '') !!}
                        </div>
                    </div>
                    <div class="relative slide-in-right order-1 lg:order-2">
                        <div class="relative group">
                            <div class="absolute -inset-4 bg-gradient-to-r from-teal-400 to-blue-400 rounded-3xl blur-2xl opacity-30 group-hover:opacity-50 transition-opacity"></div>
                            @if($who_we_are->mainImage)
                            <x-common.webp-image :mediaObject="$who_we_are->mainImage" :alt="$who_we_are->title" imgClass="relative rounded-3xl w-full h-auto shadow-2xl transform group-hover:scale-[1.02] transition-transform duration-500" />
                            @else
                            <div class="glass rounded-3xl w-full aspect-video flex items-center justify-center">
                                <i class="fas fa-image text-6xl text-white/20"></i>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if(isset($why_choose_us) && $why_choose_us)
    <section class="relative overflow-hidden w-full bg-gradient-to-b from-white via-gray-50/30 to-white">
        <div class="w-full px-4 lg:px-8 relative z-10">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-20 fade-in">
                    @if($why_choose_us->title)
                    <span class="text-sm font-semibold text-teal-600 uppercase tracking-wider mb-4 block">{{ $why_choose_us->title }}</span>
                    @endif
                    @if($why_choose_us->second_title)
                    <h2 class="text-5xl lg:text-6xl font-extrabold mb-6 text-gray-900">
                        <span class="bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent">{{ $why_choose_us->second_title }}</span>
                    </h2>
                    @endif
                    <div class="w-20 h-1 bg-gradient-to-r from-teal-500 to-blue-500 mx-auto"></div>
                </div>
                @php
                    $whyIcons = ['fas fa-eye', 'fas fa-bullseye', 'fas fa-flag-checkered', 'fas fa-heart'];
                    $whyGradients = ['from-teal-500 to-teal-600', 'from-orange-500 to-orange-600', 'from-yellow-400 to-yellow-500', 'from-slate-700 to-slate-800'];
                    $whyUnderline = ['from-teal-500 to-blue-500', 'from-orange-500 to-red-500', 'from-yellow-400 to-orange-500', 'from-slate-600 to-gray-700'];
                @endphp
                @foreach(isset($why_choose_us->bmses) ? $why_choose_us->bmses : [] as $index => $block)
                <div class="content-block mb-24 fade-in">
                    <div class="flex items-start space-x-6 mb-6">
                        <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br {{ $whyGradients[min($index, 3)] }} rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="{{ $whyIcons[min($index, 3)] }} text-2xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            @if($block->title)
                            <h3 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ $block->title }}</h3>
                            <div class="w-16 h-1 bg-gradient-to-r {{ $whyUnderline[min($index, 3)] }} mb-6"></div>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-4 pl-24 text-lg lg:text-xl text-gray-700 leading-relaxed">
                        {!! \App\Classes\Content::inlineStyleToClasses($block->content ?? '') !!}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(isset($our_partners) && $our_partners)
    <section class="py-24 bg-gradient-to-b from-white to-gray-50 relative overflow-hidden w-full">
        <div class="w-full px-4 lg:px-8 relative z-10">
            <div class="max-w-7xl mx-auto">
                @if($our_partners->title)
                <h2 class="text-4xl lg:text-5xl font-bold text-center mb-4 text-gray-900 fade-in">{{ $our_partners->title }}</h2>
                @endif
                @if(isset($our_partners->second_title) && $our_partners->second_title)
                <p class="text-center text-gray-700 text-xl mb-16 fade-in">{{ $our_partners->second_title }}</p>
                @else
                <p class="text-center text-gray-700 text-xl mb-16 fade-in">Trusted by leading organizations</p>
                @endif
                <div class="partners-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 lg:gap-12">
                    @foreach(isset($our_partners->bmses) ? $our_partners->bmses : [] as $partner)
                    <div class="partner-card bg-white rounded-xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 flex items-center justify-center h-48 lg:h-56 fade-in hover:scale-105">
                        @if($partner->mainImage)
                        <x-common.webp-image :mediaObject="$partner->mainImage" :alt="$partner->title ?? 'Partner'" imgClass="w-full h-full object-contain filter grayscale hover:grayscale-0 transition-all duration-300" />
                        @else
                        <span class="text-gray-400">{{ $partner->title ?? 'Partner' }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    @php
        $teamBmses = isset($ag_energies_team) && $ag_energies_team->bmses ? $ag_energies_team->bmses : collect();
    @endphp
    @if($teamBmses->isNotEmpty())
    <section class="py-20 w-full bg-white">
        <div class="w-full px-4 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="about-image-slider relative overflow-hidden mb-20 fade-in">
                    <div class="slider-wrapper flex transition-transform duration-700 ease-in-out">
                        @foreach($teamBmses as $teamItem)
                            @if($teamItem->mainImage)
                            <div class="slide">
                                <x-common.webp-image :mediaObject="$teamItem->mainImage" :alt="$teamItem->title ?? 'AG Energies Team'" imgClass="slide-image" />
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
</main>
