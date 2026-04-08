gsap.registerPlugin(ScrollTrigger);

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const closeMenuBtn = document.getElementById('closeMenuBtn');
const mobileMenu = document.getElementById('mobileMenu');
const navbar = document.getElementById('navbar');
const backToTop = document.getElementById('backToTop');
const projectFilters = document.querySelectorAll('.filter-btn');
const projectCards = document.querySelectorAll('.project-card');

function initMobileMenu() {
    if (!mobileMenuBtn || !closeMenuBtn || !mobileMenu) return;
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    
    const toggleMenu = () => {
        const isOpen = mobileMenu.classList.contains('open');
        mobileMenu.classList.toggle('open');
        if (mobileMenuOverlay) {
            mobileMenuOverlay.classList.toggle('active');
        }
        mobileMenuBtn.setAttribute('aria-expanded', !isOpen);
        document.body.style.overflow = isOpen ? '' : 'hidden';
    };

    const closeMenu = () => {
        mobileMenu.classList.remove('open');
        if (mobileMenuOverlay) {
            mobileMenuOverlay.classList.remove('active');
        }
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    };

    mobileMenuBtn.addEventListener('click', toggleMenu);
    closeMenuBtn.addEventListener('click', closeMenu);
    
    if (mobileMenuOverlay) {
        mobileMenuOverlay.addEventListener('click', closeMenu);
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mobileMenu.classList.contains('open')) {
            closeMenu();
        }
    });

    document.querySelectorAll('#mobileMenu a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });
}

function initNavbarScroll() {
    if (!navbar) return;
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        if (currentScroll > 100) {
            navbar.classList.add('nav-scrolled');
        } else {
            navbar.classList.remove('nav-scrolled');
        }
        lastScroll = currentScroll;
    });
}

function initVideoSection() {
    const sectionVideo = document.getElementById('sectionVideo');
    const videoFallback = document.getElementById('videoFallback');
    
    if (sectionVideo && videoFallback) {
        sectionVideo.addEventListener('error', () => {
            sectionVideo.style.display = 'none';
            videoFallback.style.display = 'block';
        });
        
        sectionVideo.addEventListener('loadeddata', () => {
            videoFallback.style.display = 'none';
        });
    }
}

function initBannerSlider() {
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    const sliderNav = document.getElementById('sliderNav');
    let currentSlide = 0;
    let slideInterval;

    if (slides.length === 0) return;

    function createDots() {
        slides.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.className = `slider-dot ${index === 0 ? 'active' : ''}`;
            dot.addEventListener('click', () => goToSlide(index));
            sliderNav.appendChild(dot);
        });
    }

    function updateSlides() {
        slides.forEach((slide, index) => {
            slide.classList.remove('active');
            if (index === currentSlide) {
                slide.classList.add('active');
            }
        });

        const dots = sliderNav.querySelectorAll('.slider-dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });
    }

    function goToSlide(index) {
        currentSlide = index;
        updateSlides();
        resetInterval();
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        updateSlides();
        resetInterval();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        updateSlides();
        resetInterval();
    }

    function startInterval() {
        if (prefersReducedMotion) return;
        slideInterval = setInterval(nextSlide, 5000);
    }

    function resetInterval() {
        clearInterval(slideInterval);
        startInterval();
    }

    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);

    createDots();
    startInterval();

    document.querySelector('.hero-slider')?.addEventListener('mouseenter', () => {
        clearInterval(slideInterval);
    });

    document.querySelector('.hero-slider')?.addEventListener('mouseleave', () => {
        startInterval();
    });
}

function initBackToTop() {
    if (!backToTop) return;
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTop.classList.remove('opacity-0', 'pointer-events-none');
            backToTop.classList.add('opacity-100');
        } else {
            backToTop.classList.add('opacity-0', 'pointer-events-none');
            backToTop.classList.remove('opacity-100');
        }
    });

    backToTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

function initProjectFilters() {
    if (!projectFilters.length || !projectCards.length) return;
    projectFilters.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-filter');
            
            projectFilters.forEach(b => {
                b.classList.remove('active');
            });
            btn.classList.add('active');

            if (prefersReducedMotion) {
                projectCards.forEach(card => {
                    const category = card.getAttribute('data-category');
                    if (filter === 'all' || category === filter) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
                return;
            }

            const tl = gsap.timeline();
            const visibleCards = Array.from(projectCards).filter(card => !card.classList.contains('hidden'));
            
            tl.to(visibleCards, {
                opacity: 0,
                scale: 0.95,
                duration: 0.3,
                stagger: 0.05,
                onComplete: () => {
                    projectCards.forEach(card => {
                        const category = card.getAttribute('data-category');
                        if (filter === 'all' || category === filter) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    });

                    const newVisibleCards = Array.from(projectCards).filter(card => !card.classList.contains('hidden'));
                    gsap.fromTo(newVisibleCards, 
                        { opacity: 0, scale: 0.95 },
                        { opacity: 1, scale: 1, duration: 0.3, stagger: 0.05 }
                    );
                }
            });
        });
    });
}

function initPageAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right, .scale-in').forEach(el => {
        observer.observe(el);
    });
}

function initAnimations() {
    if (prefersReducedMotion) return;
    
    initPageAnimations();

    const heroBadge = document.getElementById('heroBadge');
    const heroTitle = document.getElementById('heroTitle');
    const heroText = document.getElementById('heroText');
    const heroButtons = document.getElementById('heroButtons');
    const statCards = document.querySelectorAll('.stat-card');

    const heroEls = [heroBadge, heroTitle, heroText, heroButtons].filter(Boolean);
    if (heroEls.length) {
        gsap.fromTo(heroEls,
            { opacity: 0, y: 30 },
            { opacity: 1, y: 0, duration: 1, stagger: 0.2, ease: 'power3.out' }
        );
    }

    if (statCards.length) {
        gsap.fromTo(statCards,
            { opacity: 0, y: 50 },
            { opacity: 1, y: 0, duration: 0.8, stagger: 0.2, delay: 0.5, ease: 'power3.out' }
        );
    }

    const serviceCards = document.querySelectorAll('.service-card');
    ScrollTrigger.batch(serviceCards, {
        onEnter: (elements) => {
            gsap.fromTo(elements,
                { opacity: 0, y: 50 },
                { opacity: 1, y: 0, duration: 0.8, stagger: 0.1, ease: 'power3.out' }
            );
        },
        once: true
    });

    const serviceIcons = document.querySelectorAll('.service-icon');
    serviceIcons.forEach(icon => {
        icon.addEventListener('mouseenter', () => {
            gsap.to(icon, { rotation: 360, duration: 0.6, ease: 'power2.out' });
        });
    });

    const aboutTitle = document.getElementById('aboutTitle');
    if (aboutTitle) {
        ScrollTrigger.create({
            trigger: aboutTitle,
            start: 'top 80%',
            animation: gsap.fromTo(aboutTitle,
                { opacity: 0, x: -50 },
                { opacity: 1, x: 0, duration: 0.8, ease: 'power3.out' }
            ),
            once: true
        });
    }

    const whyCards = document.querySelectorAll('.why-card');
    ScrollTrigger.batch(whyCards, {
        onEnter: (elements) => {
            gsap.fromTo(elements,
                { opacity: 0, y: 50 },
                { opacity: 1, y: 0, duration: 0.8, stagger: 0.15, ease: 'power3.out' }
            );
        },
        once: true
    });

    const projectsTitle = document.getElementById('projectsTitle');
    if (projectsTitle) {
        ScrollTrigger.create({
            trigger: projectsTitle,
            start: 'top 80%',
            animation: gsap.fromTo(projectsTitle,
                { opacity: 0, y: 30 },
                { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' }
            ),
            once: true
        });
    }

    const newsCards = document.querySelectorAll('.news-card');
    ScrollTrigger.batch(newsCards, {
        onEnter: (elements) => {
            gsap.fromTo(elements,
                { opacity: 0, y: 50 },
                { opacity: 1, y: 0, duration: 0.8, stagger: 0.1, ease: 'power3.out' }
            );
        },
        once: true
    });

    const sectionTitles = document.querySelectorAll('#servicesTitle, #newsTitle, #whyTitle');
    ScrollTrigger.batch(sectionTitles, {
        onEnter: (elements) => {
            gsap.fromTo(elements,
                { opacity: 0, y: 30 },
                { opacity: 1, y: 0, duration: 0.8, stagger: 0.1, ease: 'power3.out' }
            );
        },
        once: true
    });

    const statsSection = document.getElementById('stats');
    if (statsSection) {
        let countersAnimated = false;
        
        const animateCounters = () => {
            if (countersAnimated) return;
            countersAnimated = true;
            
            const statItems = document.querySelectorAll('.stat-item');
            gsap.fromTo(statItems,
                { opacity: 0, y: 30 },
                { opacity: 1, y: 0, duration: 0.8, stagger: 0.1, ease: 'power3.out' }
            );
            
            const counters = document.querySelectorAll('[data-count]');
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
                        requestAnimationFrame(() => {
                            setTimeout(updateCounter, duration / steps);
                        });
                    } else {
                        counter.textContent = needsPlus ? '+' + target.toLocaleString() : target.toLocaleString();
                    }
                };
                
                setTimeout(() => updateCounter(), 300);
            });
        };
        
        ScrollTrigger.create({
            trigger: statsSection,
            start: 'top 85%',
            onEnter: animateCounters,
            once: true
        });
        
        if (window.innerHeight > statsSection.getBoundingClientRect().top) {
            animateCounters();
        }
    }
}

function handleNewsletterSubmit(e) {
    if (e) e.preventDefault();
    var newsletterForm = document.getElementById('newsletterForm');
    var messageEl = document.getElementById('newsletterMessage');
    if (!newsletterForm) return;
    var emailInput = newsletterForm.querySelector('input[type="email"]');
    var submitBtn = newsletterForm.querySelector('button[type="submit"]');
    var email = emailInput && emailInput.value ? emailInput.value.trim() : '';
    if (!email) return;
    if (messageEl) {
        messageEl.classList.add('hidden');
        messageEl.classList.remove('text-green-600', 'text-red-600');
    }
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = '...';
    }
    var formData = new FormData(newsletterForm);
    fetch(newsletterForm.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(function(res) {
        return res.json().then(function(data) {
            if (!res.ok) throw new Error(data.message || data.errors ? (data.errors.email && data.errors.email[0]) || 'Invalid input' : 'Request failed');
            return data;
        });
    })
    .then(function(data) {
        if (messageEl) {
            messageEl.textContent = data.message || 'Thank you for subscribing!';
            messageEl.classList.remove('hidden');
            messageEl.classList.add(data.success ? 'text-green-600' : 'text-red-600');
        } else {
            alert(data.message || 'Thank you for subscribing!');
        }
        newsletterForm.reset();
    })
    .catch(function(err) {
        var msg = err && err.message ? err.message : 'Something went wrong. Please try again.';
        if (messageEl) {
            messageEl.textContent = msg;
            messageEl.classList.remove('hidden', 'text-green-600');
            messageEl.classList.add('text-red-600');
        } else {
            alert(msg);
        }
    })
    .finally(function() {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Subscribe';
        }
    });
}
window.handleNewsletterSubmit = handleNewsletterSubmit;

function initNewsletter() {
    var newsletterForm = document.getElementById('newsletterForm');
    if (!newsletterForm) return;
    newsletterForm.addEventListener('submit', function(e) {
        handleNewsletterSubmit(e);
    });
}

function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === '#home') {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                const offset = 80;
                const targetPosition = target.offsetTop - offset;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initMobileMenu();
    initNavbarScroll();
    initBannerSlider();
    initVideoSection();
    initBackToTop();
    initProjectFilters();
    initAnimations();
    initNewsletter();
    initSmoothScroll();
});
