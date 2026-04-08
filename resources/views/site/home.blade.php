<x-layouts.layout seoTitle="{{ __('site.HOME_PAGE') }}" layoutView="main-inner">
    @push('css')
    @endpush


    @section('content')
    <main>
        <section id="home" class="hero-slider">
            <div class="slider-container">
                @php $sliderBmses = isset($HomePageSlider) && $HomePageSlider && $HomePageSlider->bmses ? $HomePageSlider->bmses : collect(); @endphp
                @foreach($sliderBmses as $idx => $slideBms)
                @php $bgUrl = $slideBms->mainImage ? ($slideBms->mainImage->url ?? $slideBms->mainImage->getUrl()) : ''; @endphp
                <div class="slide {{ $idx === 0 ? 'active' : '' }}" @if($bgUrl) style="background-image: url('{{ asset($bgUrl) }}');" @endif>
                    <div class="slider-overlay"></div>
                    <div class="slide-content">
                        @if($slideBms->title)<h1 class="emptytext">{{ $slideBms->title }}</h1>@endif
                        @if($slideBms->brief)<p>{{ $slideBms->brief }}</p>@endif
                        @if($slideBms->content)<div class="slide-html">{!! \App\Classes\Content::inlineStyleToClasses($slideBms->content) !!}</div>@endif
                    </div>
                </div>
                @endforeach
                @if($sliderBmses->isEmpty())
                <div class="slide active" style="background-image: url('{{ asset('assets/home/168311769237734.jpg') }}');">
                    <div class="slider-overlay"></div>
                    <div class="slide-content">
                        <h1 class="emptytext">Meaningful Impact</h1>
                        <p>Every action we take, every step we make, is filled with purpose.</p>
                    </div>
                </div>
                @endif
            </div>
            <button class="slider-arrows prev" id="prevSlide" aria-label="Previous slide">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="slider-arrows next" id="nextSlide" aria-label="Next slide">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="slider-nav" id="sliderNav"></div>
        </section>

        <section id="services" class="pt-16 lg:pt-24 pb-0 relative overflow-hidden bg-white">
            <div class="grid lg:grid-cols-3 gap-0 lg:gap-6">
                @php $energyCards = isset($HomePageEnergyCards) && $HomePageEnergyCards && $HomePageEnergyCards->bmses ? $HomePageEnergyCards->bmses : collect(); @endphp
                @foreach($energyCards as $card)
                @php $cardImg = $card->mainImage ? ($card->mainImage->url ?? $card->mainImage->getUrl()) : asset('assets/project/168700312228111.jpg'); @endphp
                <div class="service-column relative group cursor-pointer">
                    <div class="service-image-wrapper bg-cover bg-center" style="background-image: url('{{ $cardImg }}');"></div>
                    <div class="service-title-bar text-white">
                        <div class="text-5xl mb-3">@if($card->brief){!! \App\Classes\Content::inlineStyleToClasses($card->brief) !!}@else<i class="fas fa-bolt"></i>@endif</div>
                        <h3 class="text-3xl font-bold mb-2">{{ $card->title ?? '' }}</h3>
                        <p class="text-xl text-white/90">{{ $card->second_title ?? '' }}</p>
                    </div>
                    <div class="service-overlay text-white">
                        <div class="service-overlay-icon">@if($card->brief){!! \App\Classes\Content::inlineStyleToClasses($card->brief) !!}@else<i class="fas fa-bolt"></i>@endif</div>
                        <h3>{{ $card->title ?? '' }}</h3>
                        <div class="service-overlay-content">{!! \App\Classes\Content::inlineStyleToClasses($card->content ?? '') !!}</div>
                    </div>
                </div>
                @endforeach
                @if($energyCards->isEmpty())
                <div class="service-column relative group cursor-pointer">
                    <div class="service-image-wrapper bg-cover bg-center" style="background-image: url('{{ asset('assets/project/168700312228111.jpg') }}');"></div>
                    <div class="service-title-bar text-white">
                        <div class="text-5xl mb-3"><i class="fas fa-file-invoice"></i></div>
                        <h3 class="text-3xl font-bold mb-2">Energy Contracting</h3>
                        <p class="text-xl text-white/90">EPC & O&M</p>
                    </div>
                    <div class="service-overlay text-white">
                        <div class="service-overlay-icon"><i class="fas fa-file-invoice"></i></div>
                        <h3>Energy Contracting</h3>
                        <p>Comprehensive EPC & O&M services tailored to meet your energy infrastructure needs.</p>
                    </div>
                </div>
                @endif
            </div>
        </section>

        @if(isset($PoweringAfricaFuture) && $PoweringAfricaFuture)
        <section id="video-section" class="py-0 relative overflow-hidden w-full">
            <div class="relative w-full h-[600px] lg:h-[700px]">
                @php
                    $pafVideo = $PoweringAfricaFuture->mainVideo ? ($PoweringAfricaFuture->mainVideo->url ?? $PoweringAfricaFuture->mainVideo->getUrl()) : null;
                    $pafImg = $PoweringAfricaFuture->mainImage ? ($PoweringAfricaFuture->mainImage->url ?? $PoweringAfricaFuture->mainImage->getUrl()) : asset('assets/home/168578898435724.jpg');
                @endphp
                @if($pafVideo)
                <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline src="{{ $pafVideo }}"></video>
                @else
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $pafImg }}');"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/50 to-black/60 z-10"></div>
                <div class="absolute inset-0 flex items-center justify-center z-20">
                    <div class="text-center px-4">
                        @if($PoweringAfricaFuture->title)<h2 class="text-4xl lg:text-6xl font-bold text-white mb-6 emptytext">{{ $PoweringAfricaFuture->title }}</h2>@endif
                        @if($PoweringAfricaFuture->brief)<p class="text-xl lg:text-2xl text-white/90 max-w-3xl mx-auto">{{ $PoweringAfricaFuture->brief }}</p>@endif
                        @if($PoweringAfricaFuture->content)<div class="text-white/90 max-w-3xl mx-auto mt-4">{!! \App\Classes\Content::inlineStyleToClasses($PoweringAfricaFuture->content) !!}</div>@endif
                    </div>
                </div>
            </div>
        </section>
        @endif

        @if(isset($InvestingCleanEnergy) && $InvestingCleanEnergy)
        <section id="about" class="py-24 relative overflow-hidden section-white w-full">
            <div class="w-full px-4 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="fade-in">
                        @if($InvestingCleanEnergy->title)<h2 class="text-4xl lg:text-5xl font-bold mb-6 text-gray-900" id="aboutTitle">{{ $InvestingCleanEnergy->title }}</h2>@endif
                        <div class="text-xl text-gray-700 mb-6 leading-relaxed">{!! \App\Classes\Content::inlineStyleToClasses($InvestingCleanEnergy->content ?? '') !!}</div>
                        @if($InvestingCleanEnergy->content2)<div class="text-lg text-gray-600 mb-8">{!! \App\Classes\Content::inlineStyleToClasses($InvestingCleanEnergy->content2) !!}</div>@endif
                        <a href="{{ route('about-us', ['locale' => $lng ?? 'en']) }}" class="btn-orange-gradient px-8 py-4 rounded-lg transition font-semibold inline-block">Learn More</a>
                    </div>
                    <div class="relative slide-in-right">
                        @if($InvestingCleanEnergy->mainImage)
                        <x-common.webp-image :mediaObject="$InvestingCleanEnergy->mainImage" :alt="$InvestingCleanEnergy->title ?? 'About AG Energies'" imgClass="rounded-2xl w-full h-auto shadow-2xl" />
                        @else
                        <div class="glass rounded-2xl w-full aspect-video flex items-center justify-center"><i class="fas fa-image text-6xl text-white/20"></i></div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        @endif

        @php $counterBmses = isset($HomePageCounters) && $HomePageCounters && $HomePageCounters->bmses ? $HomePageCounters->bmses : collect(); @endphp
        @if($counterBmses->isNotEmpty())
        <section id="stats" class="py-16 bg-gradient-to-r from-teal-600 to-blue-600 relative overflow-hidden w-full">
            <div class="w-full px-4 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 text-center">
                    @foreach($counterBmses as $stat)
                    <div class="stat-item">
                        <div class="text-5xl md:text-6xl font-bold text-white mb-2" data-count="{{ $stat->title ?? '0' }}">0</div>
                        <div class="text-white/90 text-sm md:text-base">{!! \App\Classes\Content::inlineStyleToClasses($stat->brief ?? $stat->content ?? '') !!}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @else
        <section id="stats" class="py-16 bg-gradient-to-r from-teal-600 to-blue-600 relative overflow-hidden w-full">
            <div class="w-full px-4 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 text-center">
                    <div class="stat-item"><div class="text-5xl md:text-6xl font-bold text-white mb-2" data-count="12">0</div><div class="text-white/90 text-sm md:text-base">African Countries</div></div>
                    <div class="stat-item"><div class="text-5xl md:text-6xl font-bold text-white mb-2" data-count="200">0</div><div class="text-white/90 text-sm md:text-base">Projects Across Africa</div></div>
                    <div class="stat-item"><div class="text-5xl md:text-6xl font-bold text-white mb-2" data-count="1000">0</div><div class="text-white/90 text-sm md:text-base">Megawatts Operational<br>Capacity</div></div>
                    <div class="stat-item"><div class="text-5xl md:text-6xl font-bold text-white mb-2" data-count="200">0</div><div class="text-white/90 text-sm md:text-base">Jobs Created</div></div>
                    <div class="stat-item"><div class="text-5xl md:text-6xl font-bold text-white mb-2" data-count="4">0</div><div class="text-white/90 text-sm md:text-base">Ongoing Projects</div></div>
                    <div class="stat-item"><div class="text-5xl md:text-6xl font-bold text-white mb-2" data-count="500">0</div><div class="text-white/90 text-sm md:text-base">CO₂ Reduction</div></div>
                </div>
            </div>
        </section>
        @endif

        @php $whyBmses = isset($HomePageWhyChooseUs) && $HomePageWhyChooseUs && $HomePageWhyChooseUs->bmses ? $HomePageWhyChooseUs->bmses : collect(); @endphp
        @if($whyBmses->isNotEmpty() || !isset($HomePageWhyChooseUs))
        <section id="why-choose" class="py-24 section-white relative overflow-hidden w-full">
            <div class="w-full px-4 lg:px-8 relative z-10">
                @if(isset($HomePageWhyChooseUs) && $HomePageWhyChooseUs && $HomePageWhyChooseUs->title)<h2 class="text-4xl lg:text-5xl font-bold text-center mb-4 text-gray-900" id="whyTitle">{{ $HomePageWhyChooseUs->title }}</h2>@else<h2 class="text-4xl lg:text-5xl font-bold text-center mb-4 text-gray-900" id="whyTitle">Why Choose Us?</h2>@endif
                @if(isset($HomePageWhyChooseUs) && $HomePageWhyChooseUs && $HomePageWhyChooseUs->second_title)<p class="text-center text-gray-700 text-xl mb-16">{{ $HomePageWhyChooseUs->second_title }}</p>@else<p class="text-center text-gray-700 text-xl mb-16">We're building a better future</p>@endif
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($whyBmses as $why)
                    <div class="why-card bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-gray-100 fade-in">
                        @if($why->mainImage)<div class="text-5xl text-teal-500 mb-6"><x-common.webp-image :mediaObject="$why->mainImage" :alt="$why->title" imgClass="mx-auto w-16 h-16 object-contain" /></div>@else<div class="text-5xl text-teal-500 mb-6"><i class="fas fa-shield-alt"></i></div>@endif
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">{{ $why->title ?? '' }}</h3>
                        <div class="text-gray-700">{!! \App\Classes\Content::inlineStyleToClasses($why->content ?? $why->brief ?? '') !!}</div>
                    </div>
                    @endforeach
                    @if($whyBmses->isEmpty())
                    <div class="why-card bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-gray-100 fade-in"><div class="text-5xl text-teal-500 mb-6"><i class="fas fa-shield-alt"></i></div><h3 class="text-2xl font-bold mb-4 text-gray-900">Quality Assurance</h3><p class="text-gray-700">As approved distributors, we provide top-notch PV panels, inverters, and spare parts.</p></div>
                    <div class="why-card bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-gray-100 fade-in"><div class="text-5xl text-teal-500 mb-6"><i class="fas fa-heart"></i></div><h3 class="text-2xl font-bold mb-4 text-gray-900">Customer Care</h3><p class="text-gray-700">We prioritize your experience. With extended warranties and on-ground support.</p></div>
                    <div class="why-card bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-gray-100 fade-in"><div class="text-5xl text-teal-500 mb-6"><i class="fas fa-cogs"></i></div><h3 class="text-2xl font-bold mb-4 text-gray-900">Comprehensive Services</h3><p class="text-gray-700">We offer the best services in systems design, products, and installation.</p></div>
                    @endif
                </div>
            </div>
        </section>
        @endif

        <section id="projects" class="py-24 relative overflow-hidden section-white w-full">
            <div class="w-full px-4 lg:px-8 relative z-10">
                <h2 class="text-4xl lg:text-5xl font-bold text-center mb-4 text-gray-900 fade-in" id="projectsTitle">{{ __('site.PROJECTS') ?? 'Our Projects' }}</h2>
                <p class="text-center text-gray-700 text-xl mb-12 fade-in">Showcasing our successful implementations</p>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="projectsGrid">
                    @foreach($latestProjects ?? [] as $project)
                    @php $pImg = $project->mainImage ? ($project->mainImage->url ?? $project->mainImage->getUrl()) : ''; @endphp
                    <div class="project-card bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 cursor-pointer" data-category="{{ $project->category_id ?? '' }}" onclick="window.location.href='{{ route('projects-view', ['locale' => $lng ?? 'en', 'slug' => $project->slug]) }}'">
                        <div class="w-full h-48 bg-cover bg-center" @if($pImg) style="background-image: url('{{ asset($pImg) }}');" @endif></div>
                        <div class="p-6">
                            @if($project->category)<span class="inline-block px-3 py-1 bg-teal-100 text-teal-600 rounded-full text-sm mb-3 font-semibold">{{ $project->category->title }}</span>@endif
                            <h3 class="text-2xl font-bold mb-2 text-gray-900">{{ $project->title }}</h3>
                            <p class="text-gray-700 mb-4">{{ Str::limit(strip_tags($project->brief ?? ''), 80) }}</p>
                            <span class="text-teal-600 hover:text-teal-700 transition font-semibold">View Details →</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center mt-12">
                    <a href="{{ route('projects-index', ['locale' => $lng ?? 'en']) }}" class="inline-block px-8 py-4 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition font-semibold shadow-md">{{ __('site.View_All') ?? 'View All Projects' }}</a>
                </div>
            </div>
        </section>

        <section id="news" class="py-24 section-white relative overflow-hidden w-full">
            <div class="w-full px-4 lg:px-8 relative z-10">
                <h2 class="text-4xl lg:text-5xl font-bold text-center mb-4 text-gray-900 fade-in" id="newsTitle">{{ __('site.NEWS') ?? 'Our Stories' }}</h2>
                <p class="text-center text-gray-700 text-xl mb-16 fade-in">Latest news and updates</p>
                <div class="grid md:grid-cols-3 gap-8 mb-12">
                    @foreach($latestNews ?? [] as $item)
                    @php $nImg = $item->mainImage ? ($item->mainImage->url ?? $item->mainImage->getUrl()) : ''; @endphp
                    <div class="news-card bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 cursor-pointer" onclick="window.location.href='{{ route('news-view', ['slug' => $item->slug, 'locale' => $lng ?? 'en']) }}'">
                        <div class="w-full h-48 bg-cover bg-center" @if($nImg) style="background-image: url('{{ asset($nImg) }}');" @endif></div>
                        <div class="p-6">
                            <span class="text-sm text-gray-500 mb-2 block">{{ $item->published_at?->format('M d, Y') }}</span>
                            <h3 class="text-2xl font-bold mb-3 text-gray-900">{{ $item->title }}</h3>
                            <p class="text-gray-700 mb-4">{{ Str::limit(strip_tags($item->brief ?? ''), 120) }}</p>
                            <span class="text-teal-600 hover:text-teal-700 transition font-semibold inline-flex items-center">Read More <i class="fas fa-arrow-right ml-2"></i></span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <a href="{{ route('news-index', ['locale' => $lng ?? 'en']) }}" class="inline-block px-8 py-4 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition font-semibold shadow-md">View All News</a>
                </div>
            </div>
        </section>

        @php $partnerBmses = isset($HomePageOurPartners) && $HomePageOurPartners && $HomePageOurPartners->bmses ? $HomePageOurPartners->bmses : collect(); @endphp
        <section id="partners" class="py-16 bg-white relative overflow-hidden w-full">
            <div class="w-full px-4 lg:px-8">
                <h2 class="text-3xl lg:text-4xl font-bold text-center mb-12 text-gray-900 fade-in">Our Partners</h2>
                <div class="partners-slider-container relative overflow-hidden">
                    <div class="partners-slider flex gap-8 animate-scroll">
                        @foreach($partnerBmses as $partner)
                        @if($partner->mainImage)
                        <div class="partner-slide flex-shrink-0 w-56 lg:w-64 h-40 lg:h-48 bg-white rounded-xl shadow-lg flex items-center justify-center p-6 border border-gray-100 hover:shadow-xl transition-all duration-300">
                            <x-common.webp-image :mediaObject="$partner->mainImage" :alt="$partner->title ?? 'Partner'" imgClass="w-full h-full object-contain filter grayscale hover:grayscale-0 transition-all duration-300" />
                        </div>
                        @endif
                        @endforeach
                        @if($partnerBmses->isEmpty())
                        <div class="partner-slide flex-shrink-0 w-56 lg:w-64 h-40 lg:h-48 bg-white rounded-xl shadow-lg flex items-center justify-center p-6 border border-gray-100"><img src="{{ asset('assets/partnerLogo/16915764622758.png') }}" alt="Partner" class="w-full h-full object-contain filter grayscale hover:grayscale-0" onerror="this.style.display='none';"></div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section id="newsletter" class="py-20 relative overflow-hidden w-full" style="background: linear-gradient(to bottom, #ffffff 0%, #ffffff 50%, #14b8a6 50%, #0d9488 100%);">
            <div class="w-full px-4 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div class="relative flex items-center justify-center">
                        @if(isset($HomePageNewsLetterImage) && $HomePageNewsLetterImage && $HomePageNewsLetterImage->mainImage)
                        @php $nlImg = $HomePageNewsLetterImage->mainImage->url ?? $HomePageNewsLetterImage->mainImage->getUrl() @endphp
                        <div class="relative newsletter-tablet" style="transform: perspective(1000px) rotateY(-8deg) rotateX(3deg);">
                            <x-common.webp-image :mediaObject="$HomePageNewsLetterImage->mainImage" :alt="$HomePageNewsLetterImage->title ?? 'Newsletter'" imgClass="w-full h-auto rounded-2xl shadow-2xl max-w-[280px] border-4 border-slate-900" />
                        </div>
                        @else
                        <div class="relative newsletter-tablet flex items-center justify-center rounded-2xl shadow-2xl bg-gradient-to-br from-teal-100 to-blue-100 border-4 border-slate-900 max-w-[280px] aspect-[2/3]" style="transform: perspective(1000px) rotateY(-8deg) rotateX(3deg);">
                            <i class="fas fa-envelope-open-text text-6xl text-teal-400"></i>
                        </div>
                        @endif
                    </div>
                    <div class="p-8 lg:p-12 flex flex-col justify-center rounded-2xl lg:rounded-none lg:rounded-l-2xl shadow-xl">
                        <h2 class="text-3xl lg:text-5xl font-bold mb-12 leading-tight">{{ isset($HomePageNewsLetterImage) && $HomePageNewsLetterImage && $HomePageNewsLetterImage->title ? $HomePageNewsLetterImage->title : 'Get the latest news straight to your inbox' }}</h2>
                        <form class="flex flex-col sm:flex-row gap-4" id="newsletterForm" action="{{ route('newsletter-subscribe', ['locale' => $lng ?? 'en']) }}" method="POST" onsubmit="if(window.handleNewsletterSubmit){window.handleNewsletterSubmit(event);} return false;">
                            @csrf
                            <input type="email" name="email" placeholder="Your Email Address" class="flex-1 px-6 py-4 bg-white border-2 border-orange-300 rounded-lg focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-300 text-gray-900 placeholder-gray-400 shadow-md transition" required>
                            <button type="submit" class="newsletter-button px-8 py-4 rounded-lg transition font-semibold shadow-lg whitespace-nowrap font-bold">Subscribe</button>
                        </form>
                        <p id="newsletterMessage" class="mt-4 text-sm font-medium hidden"></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- <section id="cta" class="py-20 relative overflow-hidden bg-gradient-to-r from-teal-500 to-blue-600">
            <div class="container mx-auto px-4 lg:px-8 relative z-10 text-center">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6 text-white">Ready to Go Solar?</h2>
                <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">Get in touch with us today and discover how we can help power your future with clean energy.</p>
                <button class="px-10 py-5 bg-white text-teal-600 rounded-lg hover:bg-gray-100 transition font-semibold text-lg shadow-lg">
                    Contact Us
                </button>
            </div>
        </section> -->
    </main>
    @endsection


    @push('js')
    <script>
        (function() {
            const statsSection = document.getElementById('stats');
            if (!statsSection) return;

            let countersAnimated = false;

            const animateCounters = () => {
                if (countersAnimated) return;
                countersAnimated = true;

                const counters = document.querySelectorAll('#stats [data-count]');
                counters.forEach((counter, index) => {
                    const target = parseInt(counter.getAttribute('data-count'));
                    if (isNaN(target) || target === 0) return;

                    const duration = 2000;
                    const steps = 100;
                    const increment = target / steps;
                    let current = 0;
                    const needsPlus = index !== 4;

                    const updateCounter = () => {
                        current += increment;
                        if (current < target) {
                            const value = Math.floor(current);
                            counter.textContent = needsPlus ? '+' + value.toLocaleString() : value.toLocaleString();
                            setTimeout(updateCounter, duration / steps);
                        } else {
                            counter.textContent = needsPlus ? '+' + target.toLocaleString() : target.toLocaleString();
                        }
                    };

                    setTimeout(() => updateCounter(), 100 * (index + 1));
                });
            };

            if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.create({
                    trigger: statsSection,
                    start: 'top 85%',
                    onEnter: animateCounters,
                    once: true
                });
            }

            const checkVisibility = () => {
                const rect = statsSection.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
                if (isVisible && !countersAnimated) {
                    animateCounters();
                }
            };

            checkVisibility();
            window.addEventListener('scroll', checkVisibility);
            window.addEventListener('load', checkVisibility);
        })();
    </script>
    @endpush
</x-layouts.layout>

