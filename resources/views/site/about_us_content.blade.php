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

    <style>
        .page-hero {
            position: relative;
            width: 100%;
            height: 60vh;
            min-height: 400px;
            max-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .hero-background img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 61, 92, 0.85) 0%, rgba(13, 148, 136, 0.75) 100%);
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            text-align: center;
            color: white;
            padding: 0 20px;
        }

        .hero-title-main {
            font-size: clamp(36px, 6vw, 64px);
            font-weight: 300;
            margin-bottom: 20px;
            line-height: 1.2;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease-out forwards;
        }

        .hero-subtitle-main {
            font-size: clamp(16px, 2vw, 22px);
            font-weight: 400;
            max-width: 700px;
            margin: 0 auto;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease-out 0.2s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-section {
            padding: 80px 0;
        }

        .content-section:nth-child(even) {
            background: #f8fafc;
        }

        .section-title {
            margin-bottom: 30px;
            text-align: center;
            font-size: clamp(32px, 4vw, 48px);
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #003d5c;
        }

        .section-content {
            max-width: 900px;
            margin: 0 auto;
            font-size: 18px;
            line-height: 1.8;
            color: #2c3e50;
        }

        .card-reveal-section {
            min-height: 220vh;
            background: white;
            position: relative;
            padding: 100px 0;
        }

        .card-reveal-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 80px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 100px;
            align-items: start;
            position: sticky;
            top: 100px;
        }

        .card-reveal-content {
            position: sticky;
            top: 100px;
        }

        .section-eyebrow {
            font-size: clamp(32px, 4vw, 48px);
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #003d5c;
            margin-bottom: 20px;
        }

        .card-reveal-title {
            font-size: 28px;
            font-weight: 400;
            color: #001f2e;
            margin-bottom: 30px;
            line-height: 1.3;
        }

        .card-reveal-description {
            font-size: 18px;
            line-height: 1.8;
            color: #2c3e50;
            margin-bottom: 40px;
        }

        .card-reveal-track {
            display: flex;
            flex-direction: column;
            gap: 80px;
        }

        .card-reveal-item {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease-out;
        }

        .card-reveal-item.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .card-item-link {
            display: block;
            position: relative;
            text-decoration: none;
            min-height: 520px;
        }

        .card-item-image {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        .card-item-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .card-item-text {
            position: absolute;
            bottom: 40px;
            right: 40px;
            width: 42%;
            max-width: 480px;
            padding: 30px;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .card-item-text h3 {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .card-item-text p {
            font-size: 13px;
            color: #5a6c7d;
            margin-bottom: 0;
            line-height: 1.5;
            font-weight: 500;
        }

        .partnerships-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .partnership-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(2, 12, 27, 0.08);
            border-left: 4px solid #00849e;
        }

        .partnership-card h2 {
            margin-bottom: 12px;
            color: #003d5c;
        }

        .partnership-card p {
            color: #5a6c7d;
            line-height: 1.8;
        }

        @media (max-width: 1024px) {
            .card-reveal-container {
                grid-template-columns: 1fr;
                gap: 60px;
                padding: 0 40px;
                position: static;
            }

            .card-reveal-content {
                position: static;
            }

            .card-reveal-section {
                min-height: auto;
                padding: 80px 0;
            }
        }

        @media (max-width: 768px) {
            .page-hero {
                height: 50vh;
                min-height: 350px;
            }

            .card-reveal-container {
                padding: 0 20px;
            }

            .card-item-link {
                min-height: auto;
                display: flex;
                flex-direction: column;
            }

            .card-item-image {
                position: relative;
                height: 320px;
            }

            .card-item-text {
                position: static;
                width: 100%;
                max-width: none;
                padding: 24px;
            }
        }
    </style>

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
            <div class="section-eyebrow" style="text-align:center;">{{ $ventures->first()?->title ?? 'Joint Ventures & Alliances' }}</div>
            <h2 class="section-title" style="text-align:center;">{{ $ventures->first()?->second_title ?? 'Ecosystems and Trusted Relationships' }}</h2>

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
