<main>
    @php
        $hero = $aboutHeader ?? null;
        $history = $aboutHistory ?? null;
        $purpose = $aboutPurpose ?? null;
        $peopleItems = $aboutPeopleItems ?? collect();
        $peopleIntro = $aboutPartners ?? null;
        $partners = $aboutPartners ?? null;
        $ventures = $aboutJointVentures ?? collect();
    @endphp

    @if($hero)
    @php $heroImg = $hero->mainImage?->url ?? $hero->mainImage?->getUrl(); @endphp
    <section class="page-hero">
        <div class="hero-background">
            @if($heroImg)
                <img src="{{ $heroImg }}" alt="{{ $hero->title ?? 'About Us' }}" loading="eager">
            @endif
            <div class="hero-overlay"></div>
        </div>
        <div class="container hero-content">
            <h1 class="hero-title-main">{{ $hero->title ?? 'About A.M.C.' }}</h1>
            <p class="hero-subtitle-main">{{ $hero->brief ?? '' }}</p>
        </div>
    </section>
    @endif

    @if($history)
    <section id="history" class="content-section">
        <div class="container">
            <h2 class="section-title">{{ $history->title ?? 'History & Evolution' }}</h2>
            <div class="section-content">
                {!! \App\Classes\Content::inlineStyleToClasses($history->content ?? '') !!}
            </div>
        </div>
    </section>
    @endif

    @if($purpose)
    <section id="purpose" class="content-section">
        <div class="container">
            <h2 class="section-title">{{ $purpose->title ?? 'Purpose & Future' }}</h2>
            <div class="section-content">
                {!! \App\Classes\Content::inlineStyleToClasses($purpose->content ?? '') !!}
                {!! \App\Classes\Content::inlineStyleToClasses($purpose->content2 ?? '') !!}
            </div>
        </div>
    </section>
    @endif

    @if($peopleIntro || $peopleItems->isNotEmpty())
    <section class="card-reveal-section" id="people">
        <div class="card-reveal-container">
            <div class="card-reveal-content">
                @if($peopleIntro)
                    <div class="section-eyebrow">{{ $peopleIntro->title ?? 'Our People' }}</div>
                    <h2 class="card-reveal-title">{{ $peopleIntro->second_title ?? 'At the heart of every possibility is our team' }}</h2>
                    <div class="card-reveal-description">
                        {!! \App\Classes\Content::inlineStyleToClasses($peopleIntro->content ?? '') !!}
                    </div>
                @endif
            </div>

            <div class="card-reveal-slider">
                <div class="card-reveal-track">
                    @foreach($peopleItems as $person)
                        @php
                            $personImg = $person->mainImage?->url ?? $person->mainImage?->getUrl();
                            $personLink = $person->frontButtons->first()?->url ?? '#people';
                        @endphp
                        <div class="card-reveal-item">
                            <a href="{{ $personLink }}" class="card-item-link">
                                <div class="card-item-image">
                                    @if($personImg)
                                        <img src="{{ $personImg }}" alt="{{ $person->title ?? 'Our People' }}">
                                    @endif
                                </div>
                                <div class="card-item-text">
                                    <h3>{{ $person->title ?? '' }}</h3>
                                    <p>{{ $person->brief ?? '' }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($ventures->isNotEmpty())
    <section id="ventures" class="content-section">
        <div class="container">
            <div class="section-eyebrow" style="text-align:center;">{{ 'Joint Ventures & Alliances' }}</div>
            <p style="text-align: center" >Ecosystems and Trusted Relationships</p>

            <div class="section-content">
                <div class="partnerships-grid">
                    @foreach($ventures as $venture)
                        <div class="partnership-card">
                            <h2>{{ $venture->second_title ?? $venture->title }}</h2>
                            <div>{!! \App\Classes\Content::inlineStyleToClasses($venture->content ?? '') !!}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cardRevealItems = document.querySelectorAll('.card-reveal-item');
            if (!cardRevealItems.length) return;

            const cardRevealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.2,
                rootMargin: '0px 0px -100px 0px'
            });

            cardRevealItems.forEach(item => cardRevealObserver.observe(item));
        });
    </script>
</main>
