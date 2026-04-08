<x-layouts.layout seoTitle="Get a Quote" layoutView="main-inner">

    @push('css')
        <style>
            :root {
                --quote-orange: #f97316;
                --quote-teal: #0d9488;
                --quote-border: #e5e7eb;
                --quote-text: #111827;
                --quote-muted: #6b7280;
                --quote-bg: #f8fafc;
            }
            .quote-page-wrap {
                background: linear-gradient(140deg, #f8fafc 0%, #e0f2fe 55%, #fef3c7 100%);
                min-height: 100vh;
                padding: 3rem 0 5rem;
            }
            .quote-shell {
                max-width: 1050px;
                margin: 0 auto;
                padding: 0 1rem;
            }
            .quote-card {
                background: #fff;
                border-radius: 18px;
                border: 1px solid rgba(17,24,39,0.06);
                box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
                padding: 2rem;
            }
            .quote-title {
                color: var(--quote-text);
                font-size: clamp(1.6rem, 2.8vw, 2.4rem);
                font-weight: 800;
                margin-bottom: 0.5rem;
            }
            .quote-subtitle {
                color: var(--quote-muted);
                margin-bottom: 2rem;
                max-width: 680px;
            }
            .quote-input {
                width: 100%;
                border: 1.5px solid var(--quote-border);
                border-radius: 10px;
                padding: 0.78rem 0.95rem;
                color: var(--quote-text);
                outline: none;
                background: #fff;
            }
            .quote-input:focus {
                border-color: var(--quote-orange);
                box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.16);
            }
            .form-label {
                display: block;
                color: var(--quote-text);
                font-size: 0.88rem;
                font-weight: 600;
                margin-bottom: 0.45rem;
            }
            .project-type-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 0.75rem;
            }
            .project-card {
                border: 1.5px solid var(--quote-border);
                border-radius: 10px;
                min-height: 80px;
                padding: 1rem 0.9rem;
                font-weight: 700;
                color: #334155;
                display: inline-flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                cursor: pointer;
                transition: all 0.2s ease;
                background: #fff;
                text-align: center;
            }
            .project-card-icon {
                width: 34px;
                height: 34px;
                border-radius: 999px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: rgba(249, 115, 22, 0.12);
                color: var(--quote-orange);
                flex-shrink: 0;
                transition: inherit;
            }
            .project-card:hover {
                border-color: var(--quote-orange);
                color: var(--quote-orange);
            }
            .project-card.active {
                border-color: var(--quote-teal);
                background: var(--quote-teal);
                color: #fff;
            }
            .project-card.active .project-card-icon {
                background: rgba(255, 255, 255, 0.16);
                color: #fff;
            }
            .section-box {
                margin-top: 1.5rem;
                padding: 1.2rem;
                border-radius: 12px;
                background: var(--quote-bg);
                border: 1px solid #dbeafe;
            }
            .section-title {
                color: var(--quote-text);
                font-size: 1.05rem;
                font-weight: 800;
                margin-bottom: 1rem;
            }
            .checkbox-card {
                display: inline-flex;
                align-items: center;
                gap: 0.55rem;
                border: 1.5px solid var(--quote-border);
                border-radius: 9px;
                padding: 0.65rem 0.8rem;
                background: #fff;
                font-size: 0.9rem;
                color: #334155;
                cursor: pointer;
            }
            .btn-quote-submit {
                border: none;
                border-radius: 10px;
                background: linear-gradient(140deg, var(--quote-orange), #ea580c);
                color: #fff;
                font-weight: 700;
                padding: 0.85rem 1.4rem;
                min-width: 220px;
                box-shadow: 0 10px 24px rgba(249, 115, 22, 0.28);
            }
            .btn-quote-submit:hover {
                filter: brightness(0.97);
            }
            .utility-call-box {
                text-align: center;
                padding: 1.4rem 1rem;
            }
            .utility-call-icon {
                width: 68px;
                height: 68px;
                margin: 0 auto 1rem;
                border-radius: 999px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(140deg, var(--quote-orange), #ea580c);
                color: #fff;
                font-size: 1.6rem;
                box-shadow: 0 12px 26px rgba(249, 115, 22, 0.28);
            }
            .utility-call-text {
                color: var(--quote-text);
                font-size: 1.02rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }
            .utility-call-link {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.8rem 1.4rem;
                border-radius: 10px;
                background: var(--quote-orange);
                color: #fff;
                font-weight: 700;
                text-decoration: none;
                box-shadow: 0 10px 22px rgba(249, 115, 22, 0.24);
            }
            .utility-call-link:hover {
                color: #fff;
                filter: brightness(0.96);
            }
            .form-success-toast {
                position: fixed;
                top: 5.5rem;
                right: 1.5rem;
                z-index: 80;
                width: min(420px, calc(100vw - 2rem));
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem 1.1rem;
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.96);
                border: 1px solid rgba(13, 148, 136, 0.16);
                box-shadow: 0 22px 55px rgba(15, 23, 42, 0.18);
                backdrop-filter: blur(12px);
                animation: successToastIn .35s ease, successToastOut .35s ease 5.15s forwards;
            }
            .form-success-toast__icon {
                width: 46px;
                height: 46px;
                min-width: 46px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(145deg, #10b981, #0d9488);
                color: #fff;
                box-shadow: 0 10px 24px rgba(13, 148, 136, 0.28);
            }
            .form-success-toast__content {
                flex: 1;
            }
            .form-success-toast__eyebrow {
                margin: 0 0 0.2rem;
                color: #0f766e;
                font-size: 0.78rem;
                font-weight: 800;
                letter-spacing: 0.12em;
                text-transform: uppercase;
            }
            .form-success-toast__message {
                margin: 0;
                color: var(--quote-text);
                font-size: 0.96rem;
                line-height: 1.55;
            }
            .form-success-toast__close {
                border: none;
                background: transparent;
                color: #64748b;
                padding: 0.15rem;
                line-height: 1;
            }
            .form-success-toast__close:hover {
                color: #0f172a;
            }
            @keyframes successToastIn {
                from { opacity: 0; transform: translate3d(0, -12px, 0) scale(0.98); }
                to { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
            }
            @keyframes successToastOut {
                from { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
                to { opacity: 0; transform: translate3d(0, -10px, 0) scale(0.98); pointer-events: none; }
            }
            @media (max-width: 900px) {
                .project-type-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
                .quote-card {
                    padding: 1.25rem;
                }
            }
            @media (max-width: 900px) {
                .form-success-toast {
                    top: 5rem;
                    right: 1rem;
                    left: 1rem;
                    width: auto;
                }
            }
            @media (max-width: 520px) {
                .project-type-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush

    @section('content')
        @php $path = '/get-a-quote'; @endphp
        <x-common.header-image :innerItem="null" :getFromSpacificLink="$path" />

        <section class="quote-page-wrap">
            <div class="quote-shell">
                <div class="quote-card">
                    <h2 class="quote-title">Solar Energy Project Assessment</h2>
                    <p class="quote-subtitle">Fill in your information to get a customized solar solution based on your project type.</p>
                    <livewire:quote-form />
                </div>
            </div>
        </section>
    @endsection
</x-layouts.layout>
