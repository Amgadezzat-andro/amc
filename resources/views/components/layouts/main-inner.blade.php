<!doctype html>
<html lang="en">

@include('layouts.head')


<body>

    <a href="#" class="floating-scroll-arrow" id="scrollDownArrow" aria-label="Scroll to next section">
        <i class="fas fa-chevron-down"></i>
    </a>


    <style>
        /* Fixed Floating Scroll Arrow */
        .floating-scroll-arrow {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0d9488;
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 24px;
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.4);
            animation: floatBounce 2s ease-in-out infinite;
            text-decoration: none;
        }

        .floating-scroll-arrow:hover {
            background: #0f766e;
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(13, 148, 136, 0.6);
        }

        .floating-scroll-arrow:active {
            transform: translateY(-2px);
        }

        @keyframes floatBounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @media (max-width: 768px) {
            .floating-scroll-arrow {
                width: 50px;
                height: 50px;
                font-size: 20px;
                bottom: 20px;
                right: 20px;
            }
        }

        /* Consultation Popup Modal */
        .consultation-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 10000;
            overflow-y: auto;
            padding: 40px 20px;
        }

        .consultation-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .consultation-modal-content {
            background: #ffffff;
            border-radius: 16px;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .consultation-modal-header {
            padding: 30px 40px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            background: #ffffff;
            border-radius: 16px 16px 0 0;
            z-index: 1;
        }

        .consultation-modal-title {
            font-size: 28px;
            font-weight: 700;
            color: #001f2e;
            margin: 0;
        }

        .consultation-modal-close {
            width: 40px;
            height: 40px;
            border: none;
            background: #f3f4f6;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 20px;
            color: #6b7280;
        }

        .consultation-modal-close:hover {
            background: #e5e7eb;
            color: #374151;
        }

        .consultation-modal-body {
            padding: 40px;
        }

        .consultation-form-group {
            margin-bottom: 24px;
        }

        .consultation-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .consultation-form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .consultation-form-label .required {
            color: #ef4444;
            margin-left: 4px;
        }

        .consultation-form-input,
        .consultation-form-select,
        .consultation-form-textarea {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            color: #374151;
            transition: all 0.3s ease;
            font-family: inherit;
            box-sizing: border-box;
        }

        .consultation-form-input:focus,
        .consultation-form-select:focus,
        .consultation-form-textarea:focus {
            outline: none;
            border-color: #00849e;
            box-shadow: 0 0 0 3px rgba(0, 132, 158, 0.1);
        }

        .consultation-form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .consultation-form-submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #003d5c 0%, #00849e 100%);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .consultation-form-submit-btn:hover {
            background: linear-gradient(135deg, #002d44 0%, #006d84 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 132, 158, 0.3);
        }

        @media (max-width: 768px) {
            .consultation-modal-content {
                margin: 20px;
            }

            .consultation-modal-header,
            .consultation-modal-body {
                padding: 24px;
            }

            .consultation-form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @include('layouts.header')

    @yield('content')


    @include('layouts.footer')

{{-- Scroll Script --}}
    <script>
        // Dynamic Scroll Arrow Navigation
        document.addEventListener('DOMContentLoaded', function() {
            const scrollArrow = document.getElementById('scrollDownArrow');
            const sections = ['top-banner', 'hero-section', 'about-section', 'services-section', 'culture-section',
                'careers-section', 'footer-section'
            ];

            scrollArrow.addEventListener('click', function(e) {
                e.preventDefault();

                // Get current scroll position
                const scrollPosition = window.scrollY;
                const windowHeight = window.innerHeight;

                // Find which section we're currently in
                let currentSectionIndex = -1;

                for (let i = 0; i < sections.length; i++) {
                    const section = document.getElementById(sections[i]);
                    if (section) {
                        const sectionTop = section.offsetTop;
                        const sectionBottom = sectionTop + section.offsetHeight;

                        // Check if we're in this section (with some tolerance)
                        if (scrollPosition >= sectionTop - windowHeight / 2 && scrollPosition <
                            sectionBottom - windowHeight / 2) {
                            currentSectionIndex = i;
                            break;
                        }
                    }
                }

                // Scroll to next section
                const nextSectionIndex = currentSectionIndex + 1;
                if (nextSectionIndex < sections.length) {
                    const nextSection = document.getElementById(sections[nextSectionIndex]);
                    if (nextSection) {
                        nextSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                } else {
                    // If at the last section, scroll to top
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                    scrollArrow.querySelector('i').classList.remove('fa-chevron-down');
                    scrollArrow.querySelector('i').classList.add('fa-chevron-up');
                    setTimeout(() => {
                        scrollArrow.querySelector('i').classList.remove('fa-chevron-up');
                        scrollArrow.querySelector('i').classList.add('fa-chevron-down');
                    }, 1000);
                }
            });

            // Optional: Change arrow direction at bottom of page
            window.addEventListener('scroll', function() {
                const scrollPosition = window.scrollY + window.innerHeight;
                const pageHeight = document.documentElement.scrollHeight;

                if (scrollPosition >= pageHeight - 100) {
                    scrollArrow.querySelector('i').classList.remove('fa-chevron-down');
                    scrollArrow.querySelector('i').classList.add('fa-chevron-up');
                    scrollArrow.setAttribute('title', 'Scroll to top');
                } else {
                    scrollArrow.querySelector('i').classList.remove('fa-chevron-up');
                    scrollArrow.querySelector('i').classList.add('fa-chevron-down');
                    scrollArrow.setAttribute('title', 'Scroll to next section');
                }
            });
        });
    </script>

    <!-- Consultation Modal Popup -->
    <div class="consultation-modal" id="consultationModal">
        <div class="consultation-modal-content">
            <div class="consultation-modal-header">
                <h2 class="consultation-modal-title">Book your Consultation</h2>
                <button class="consultation-modal-close" id="closeConsultationModal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="consultation-modal-body">
                <livewire:consultation-form />
            </div>
        </div>
    </div>
    <!-- Consultation Modal Script -->
    <script>
        // Consultation Modal Functionality
        const consultationModal = document.getElementById('consultationModal');
        const openConsultationModalBtn = document.getElementById('openConsultationModal');
        const openConsultationModalBtnHero = document.getElementById('openConsultationModalHero');
        const closeConsultationModalBtn = document.getElementById('closeConsultationModal');

        function openModal() {
            consultationModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            consultationModal.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (openConsultationModalBtn) {
            openConsultationModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openModal();
            });
        }

        if (openConsultationModalBtnHero) {
            openConsultationModalBtnHero.addEventListener('click', function(e) {
                e.preventDefault();
                openModal();
            });
        }

        if (closeConsultationModalBtn) {
            closeConsultationModalBtn.addEventListener('click', closeModal);
        }

        consultationModal.addEventListener('click', function(e) {
            if (e.target === consultationModal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && consultationModal.classList.contains('active')) {
                closeModal();
            }
        });

        window.addEventListener('consultation-submitted', closeModal);
    </script>

</body>

</html>
