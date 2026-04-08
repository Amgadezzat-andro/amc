// Mobile Menu Toggle
const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
const navMenu = document.querySelector('.nav-menu');

if (mobileMenuToggle) {
    mobileMenuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        mobileMenuToggle.classList.toggle('active');
        document.body.classList.toggle('mobile-menu-active');
    });
}

// Page Loader Animation
window.addEventListener('load', () => {
    setTimeout(() => {
        document.body.classList.add('loaded');
    }, 3800); // Remove loader after animations complete
});

// Hide banner content on scroll
function handleBannerScroll() {
    const bannerContent = document.querySelector('.banner-content');
    const topBanner = document.querySelector('.top-banner');

    if (!bannerContent || !topBanner) return;

    function updateBannerVisibility() {
        const bannerHeight = topBanner.offsetHeight;
        const scrolled = window.pageYOffset;

        // Fade out when scrolling past the banner
        if (scrolled > bannerHeight - 100) {
            bannerContent.style.opacity = '0';
            bannerContent.style.pointerEvents = 'none';
        } else {
            const opacity = 1 - (scrolled / (bannerHeight - 100));
            bannerContent.style.opacity = Math.max(0, opacity);
            bannerContent.style.pointerEvents = opacity > 0 ? '' : 'none';
        }
    }

    window.addEventListener('scroll', updateBannerVisibility);
    updateBannerVisibility();
}

// Initialize banner scroll handler
window.addEventListener('load', handleBannerScroll);

// Services Slider Functionality
function initServicesSlider() {
    const serviceSlides = document.querySelectorAll('.service-slide');
    const serviceNavBtns = document.querySelectorAll('.service-nav-btn');

    if (serviceNavBtns.length === 0) return;

    serviceNavBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const serviceNum = btn.getAttribute('data-service');

            // Remove active class from all
            serviceSlides.forEach(slide => slide.classList.remove('active'));
            serviceNavBtns.forEach(navBtn => navBtn.classList.remove('active'));

            // Add active class to selected
            const targetSlide = document.querySelector(`.service-slide[data-service="${serviceNum}"]`);
            if (targetSlide) {
                targetSlide.classList.add('active');
            }
            btn.classList.add('active');
        });
    });
}

// Initialize services slider on page load
window.addEventListener('load', initServicesSlider);

// Hero Slider Functionality (robust for any number of slides)
const heroSlides = Array.from(document.querySelectorAll('.hero-slide'));
let currentSlideIndex = heroSlides.findIndex(s => s.classList.contains('active'));
if (currentSlideIndex === -1) currentSlideIndex = 0;
const totalSlides = heroSlides.length || 0;
let autoplayInterval = null;

function showSlideByIndex(index) {
    if (!totalSlides) return;
    // normalize index
    index = ((index % totalSlides) + totalSlides) % totalSlides;

    // deactivate all slides
    heroSlides.forEach(s => s.classList.remove('active'));
    // activate target slide
    const target = heroSlides[index];
    if (target) target.classList.add('active');

    // update dots: prefer positional mapping, otherwise match by data-slide
    const dots = Array.from(document.querySelectorAll('.dot'));
    dots.forEach(d => d.classList.remove('active'));
    if (dots.length === totalSlides) {
        if (dots[index]) dots[index].classList.add('active');
    } else if (target) {
        const ds = target.getAttribute('data-slide');
        const matching = document.querySelector(`.dot[data-slide="${ds}"]`);
        if (matching) matching.classList.add('active');
    }

    currentSlideIndex = index;
}

function nextSlide() {
    showSlideByIndex(currentSlideIndex + 1);
}

function prevSlide() {
    showSlideByIndex(currentSlideIndex - 1);
}

function startAutoplay() {
    stopAutoplay();
    autoplayInterval = setInterval(nextSlide, 5000);
}

function stopAutoplay() {
    if (autoplayInterval) clearInterval(autoplayInterval);
    autoplayInterval = null;
}

// Arrow Controls
const prevArrow = document.querySelector('.slider-arrow.prev');
const nextArrow = document.querySelector('.slider-arrow.next');

if (prevArrow) {
    prevArrow.addEventListener('click', () => {
        stopAutoplay();
        prevSlide();
        startAutoplay();
    });
}

if (nextArrow) {
    nextArrow.addEventListener('click', () => {
        stopAutoplay();
        nextSlide();
        startAutoplay();
    });
}

// Dot Controls
const dots = Array.from(document.querySelectorAll('.dot'));
dots.forEach((dot, idx) => {
    dot.addEventListener('click', (e) => {
        e.preventDefault();
        stopAutoplay();

        const ds = dot.getAttribute('data-slide');
        // Try to match slide by data-slide attribute
        let targetIndex = heroSlides.findIndex(s => s.getAttribute('data-slide') === ds);
        // If not found, and counts match, use positional index
        if (targetIndex === -1 && heroSlides.length === dots.length) targetIndex = idx;
        if (targetIndex === -1) targetIndex = 0;

        showSlideByIndex(targetIndex);
        startAutoplay();
    });
});

// Keyboard Navigation
document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
        stopAutoplay();
        prevSlide();
        startAutoplay();
    } else if (e.key === 'ArrowRight') {
        stopAutoplay();
        nextSlide();
        startAutoplay();
    }
});

// Touch/Swipe Support for Mobile
let touchStartX = 0;
let touchEndX = 0;

const heroSection = document.querySelector('.hero-section');

if (heroSection) {
    heroSection.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    heroSection.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });
}

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;

    if (Math.abs(diff) > swipeThreshold) {
        stopAutoplay();
        if (diff > 0) {
            // Swipe left - next slide
            nextSlide();
        } else {
            // Swipe right - prev slide
            prevSlide();
        }
        startAutoplay();
    }
}

// Pause autoplay on hover
if (heroSection) {
    heroSection.addEventListener('mouseenter', stopAutoplay);
    heroSection.addEventListener('mouseleave', startAutoplay);
}

// Ensure initial slide is visible and start autoplay when page loads
showSlideByIndex(currentSlideIndex);
startAutoplay();

// Navbar Scroll Effect
let lastScroll = 0;
const navbar = document.querySelector('.navbar');

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll <= 0) {
        navbar.classList.remove('scroll-up');
        return;
    }

    if (currentScroll > lastScroll && !navbar.classList.contains('scroll-down')) {
        // Scrolling down
        navbar.classList.remove('scroll-up');
        navbar.classList.add('scroll-down');
    } else if (currentScroll < lastScroll && navbar.classList.contains('scroll-down')) {
        // Scrolling up
        navbar.classList.remove('scroll-down');
        navbar.classList.add('scroll-up');
    }

    lastScroll = currentScroll;
});

// Smooth Scroll for Anchor Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Intersection Observer for Animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe link cards
document.querySelectorAll('.link-card').forEach(card => {
    observer.observe(card);
});

// ===========================
// COMPREHENSIVE INTERSECTION OBSERVER FOR ALL SECTIONS
// ===========================

// Enhanced Intersection Observer with multiple animation types
const animationObserverOptions = {
    threshold: 0.15,
    rootMargin: '0px 0px -80px 0px'
};

// Reduce threshold on mobile for better UX
if (window.innerWidth <= 768) {
    animationObserverOptions.threshold = 0.05;
    animationObserverOptions.rootMargin = '0px 0px -50px 0px';
}

const animationObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            // Keep observing if element has 'repeat-animation' class
            if (!entry.target.classList.contains('repeat-animation')) {
                animationObserver.unobserve(entry.target);
            }
        } else if (entry.target.classList.contains('repeat-animation')) {
            entry.target.classList.remove('is-visible');
        }
    });
}, animationObserverOptions);

// Initialize animations on DOM load
function initScrollAnimations() {
    // Section headers
    document.querySelectorAll('.section-header').forEach(header => {
        animationObserver.observe(header);
    });

    // Top Banner
    const topBanner = document.querySelector('.top-banner');
    if (topBanner) {
        topBanner.classList.add('fade-in-animation');
        animationObserver.observe(topBanner);
    }

    // About section - observe entire section and individual cards
    const aboutSection = document.querySelector('.about-section');
    if (aboutSection) {
        animationObserver.observe(aboutSection);
    }

    document.querySelectorAll('.about-card').forEach((card, index) => {
        card.classList.add('slide-up-animation');
        card.style.transitionDelay = `${index * 0.15}s`;
        animationObserver.observe(card);
    });

    // Services section - observe the entire section
    const servicesSection = document.querySelector('.services-section');
    if (servicesSection) {
        animationObserver.observe(servicesSection);
    }

    // Services slider navigation
    const servicesSliderNav = document.querySelector('.services-slider-nav');
    if (servicesSliderNav) {
        servicesSliderNav.classList.add('slide-up-animation');
        animationObserver.observe(servicesSliderNav);
    }

    // Culture section - observe entire section
    const cultureSection = document.querySelector('.culture-section');
    if (cultureSection) {
        animationObserver.observe(cultureSection);
    }

    // Culture progress container
    const cultureProgress = document.querySelector('.culture-progress-container');
    if (cultureProgress) {
        cultureProgress.classList.add('fade-in-animation');
        animationObserver.observe(cultureProgress);
    }

    // Careers section
    const careersSection = document.querySelector('.careers-section');
    if (careersSection) {
        animationObserver.observe(careersSection);
    }

    // Career content blocks
    document.querySelectorAll('.career-content-block').forEach((block, index) => {
        block.classList.add('slide-up-animation');
        block.style.transitionDelay = `${index * 0.2}s`;
        animationObserver.observe(block);
    });

    // Footer
    const footer = document.querySelector('.footer');
    if (footer) {
        animationObserver.observe(footer);
    }

    // Generic animation classes - catch all remaining elements
    document.querySelectorAll('.fade-in-animation, .slide-up-animation, .slide-left-animation, .slide-right-animation, .scale-in-animation').forEach(element => {
        if (!element.closest('.about-card, .career-content-block')) {
            animationObserver.observe(element);
        }
    });

    // Competency items in services
    const competencyItems = document.querySelectorAll('.competency-item');
    competencyItems.forEach((item, index) => {
        item.classList.add('scale-in-animation');
        item.style.transitionDelay = `${index * 0.1}s`;
        animationObserver.observe(item);
    });

    // Industry tags
    const industryTags = document.querySelectorAll('.industry-tag');
    industryTags.forEach((tag, index) => {
        tag.classList.add('fade-in-animation');
        tag.style.transitionDelay = `${index * 0.05}s`;
        animationObserver.observe(tag);
    });

    // Culture items (all types)
    const cultureItems = document.querySelectorAll('.culture-item, .rise-value-item, .equity-item');
    cultureItems.forEach((item, index) => {
        item.classList.add('slide-up-animation');
        item.style.transitionDelay = `${index * 0.1}s`;
        animationObserver.observe(item);
    });

    // Career highlights
    const highlightItems = document.querySelectorAll('.highlight-item');
    highlightItems.forEach((item, index) => {
        item.classList.add('slide-up-animation');
        item.style.transitionDelay = `${index * 0.15}s`;
        animationObserver.observe(item);
    });

    // Career benefits list items
    const benefitItems = document.querySelectorAll('.career-benefits-list li');
    benefitItems.forEach((item, index) => {
        item.classList.add('slide-left-animation');
        item.style.transitionDelay = `${index * 0.1}s`;
        animationObserver.observe(item);
    });

    // Observe all images for lazy loading effect
    document.querySelectorAll('.about-image img, .service-slide-image img, .culture-slide-image img, .career-image-side img').forEach(img => {
        img.classList.add('scale-in-animation');
        animationObserver.observe(img);
    });

    // Hero section - ensure it's visible immediately
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        heroSection.classList.add('is-visible');
    }
}

// Call initialization when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initScrollAnimations);
} else {
    initScrollAnimations();
}

// Re-trigger animations on page show (for back/forward navigation)
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        // Page was loaded from cache, re-initialize animations
        initScrollAnimations();
    }
});

// Helper function to check if element is in viewport on page load
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Immediately show elements that are in viewport on page load
window.addEventListener('load', () => {
    document.querySelectorAll('.fade-in-animation, .slide-up-animation, .slide-left-animation, .slide-right-animation, .scale-in-animation').forEach(element => {
        if (isInViewport(element)) {
            element.classList.add('is-visible');
        }
    });
});

// Debounce function for performance
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Handle window resize for responsive animations
const handleResize = debounce(() => {
    // Reinitialize observer options on resize
    const isMobile = window.innerWidth <= 768;
    if (isMobile) {
        // Mobile optimizations already in CSS
        document.body.classList.add('mobile-device');
    } else {
        document.body.classList.remove('mobile-device');
    }
}, 250);

window.addEventListener('resize', handleResize);

// Performance optimization: use passive event listeners where possible
const supportsPassive = (() => {
    let support = false;
    try {
        const options = {
            get passive() {
                support = true;
                return false;
            }
        };
        window.addEventListener('test', null, options);
        window.removeEventListener('test', null, options);
    } catch (err) {
        support = false;
    }
    return support;
})();

// Apply passive listeners to scroll events for better performance
if (supportsPassive) {
    window.addEventListener('scroll', () => {}, { passive: true });
}

// Dropdown Menu for Mobile Sidebar
const navItems = document.querySelectorAll('.nav-item.dropdown > a');
navItems.forEach(item => {
    item.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
            e.preventDefault();
            const parent = item.parentElement;

            // Toggle dropdown-open class
            parent.classList.toggle('dropdown-open');

            // Close other dropdowns
            document.querySelectorAll('.nav-item.dropdown').forEach(navItem => {
                if (navItem !== parent && navItem.classList.contains('dropdown-open')) {
                    navItem.classList.remove('dropdown-open');
                }
            });
        }
    });
});

// Close mobile menu when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.nav-wrapper') && navMenu.classList.contains('active')) {
        navMenu.classList.remove('active');
        mobileMenuToggle.classList.remove('active');
        document.body.classList.remove('mobile-menu-active');
    }
});

// Close mobile menu when clicking on a link (except dropdown toggles)
document.querySelectorAll('.nav-menu a').forEach(link => {
    if (!link.parentElement.classList.contains('dropdown')) {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                navMenu.classList.remove('active');
                mobileMenuToggle.classList.remove('active');
                document.body.classList.remove('mobile-menu-active');
            }
        });
    }
});

// Preload Images (with error handling)
function preloadImages() {
    const imageUrls = [
        'assets/hero/team-meeting.jpg',
        'assets/hero/consultation.jpg',
        'assets/hero/team-collaboration.jpg',
        'assets/hero/diversity.jpg',
        'assets/hero/career-growth.jpg'
    ];

    imageUrls.forEach(url => {
        const img = new Image();
        img.onerror = function() {
            // Silently handle missing images - don't log errors
            this.onerror = null;
        };
        img.src = url;
    });
}

// Call preload on page load
window.addEventListener('load', preloadImages);

// Add active state to current page in navigation
const currentPage = window.location.pathname.split('/').pop() || 'index.html';
document.querySelectorAll('.nav-menu a').forEach(link => {
    if (link.getAttribute('href') === currentPage) {
        link.parentElement.classList.add('active');
    }
});

// Counter Animation for Stats
function animateCounter(element, target, duration = 2000) {
    const start = 0;
    const increment = target / (duration / 16); // 60 FPS
    let current = start;

    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Trigger counter animation when visible
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const statNumber = entry.target.querySelector('.stat-number');
            if (statNumber && !statNumber.classList.contains('animated')) {
                const target = parseInt(statNumber.textContent);
                statNumber.textContent = '0';
                animateCounter(statNumber, target);
                statNumber.classList.add('animated');
            }
        }
    });
}, { threshold: 0.5 });

document.querySelectorAll('.stat-item').forEach(stat => {
    statsObserver.observe(stat);
});

// Progressive Image Loading
document.querySelectorAll('.hero-background img').forEach(img => {
    const placeholder = img.getAttribute('data-placeholder');
    if (placeholder) {
        img.style.filter = 'blur(10px)';
        const fullImage = new Image();
        fullImage.src = img.src;
        fullImage.onload = () => {
            img.style.filter = 'blur(0)';
        };
    }
});

// Accessibility: Pause animations on reduced motion preference
if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    stopAutoplay();
    document.querySelectorAll('.hero-background img').forEach(img => {
        img.style.animation = 'none';
    });
}

// Update year in footer automatically
const yearElement = document.querySelector('.footer-bottom p');
if (yearElement) {
    const currentYear = new Date().getFullYear();
    yearElement.innerHTML = yearElement.innerHTML.replace('2025', currentYear);
}

// Intersection Observer for About Cards Animation
const aboutObserverOptions = {
    threshold: 0.2,
    rootMargin: '0px 0px -50px 0px'
};

const aboutObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            aboutObserver.unobserve(entry.target);
        }
    });
}, aboutObserverOptions);

// Observe all about cards
const aboutCards = document.querySelectorAll('.about-card');
aboutCards.forEach(card => {
    aboutObserver.observe(card);
});

// Culture Slider Functionality
function initCultureSlider() {
    const cultureSlides = document.querySelectorAll('.culture-slide');
    const cultureNavButtons = document.querySelectorAll('.culture-nav-btn');
    const progressFill = document.querySelector('.culture-progress-fill');
    const progressCurrent = document.querySelector('.progress-current');
    const prevArrow = document.querySelector('.prev-culture');
    const nextArrow = document.querySelector('.next-culture');

    // If there are no slides, nothing to do
    if (cultureSlides.length === 0) return;

    // Determine initial current slide from DOM (if .active exists)
    let currentSlide = 1;
    const activeSlide = document.querySelector('.culture-slide.active');
    if (activeSlide && activeSlide.getAttribute('data-culture')) {
        currentSlide = parseInt(activeSlide.getAttribute('data-culture')) || 1;
    }

    const totalSlides = cultureSlides.length;

    // Function to update progress bar and arrows
    function updateProgress(slideNumber) {
        const percentage = (slideNumber / totalSlides) * 100;

        if (progressFill) {
            progressFill.style.width = `${percentage}%`;
        }

        if (progressCurrent) {
            progressCurrent.textContent = slideNumber;
        }

        // Update arrow states
        if (prevArrow) {
            prevArrow.disabled = slideNumber === 1;
        }
        if (nextArrow) {
            nextArrow.disabled = slideNumber === totalSlides;
        }
    }

    // Function to go to specific slide
    function goToSlide(slideNumber) {
        currentSlide = slideNumber;

        // Remove active class from all slides and nav buttons (if any)
        cultureSlides.forEach(slide => slide.classList.remove('active'));
        if (cultureNavButtons.length) cultureNavButtons.forEach(btn => btn.classList.remove('active'));

        // Add active class to selected slide and nav button (if present)
        const targetSlide = document.querySelector(`.culture-slide[data-culture="${slideNumber}"]`);
        const targetButton = document.querySelector(`.culture-nav-btn[data-culture="${slideNumber}"]`);

        if (targetSlide) {
            targetSlide.classList.add('active');
        }
        if (targetButton) {
            targetButton.classList.add('active');
        }

        // Update progress bar
        updateProgress(slideNumber);
    }

    // Navigation button click handlers (if nav buttons exist)
    if (cultureNavButtons.length) {
        cultureNavButtons.forEach(button => {
            button.addEventListener('click', () => {
                const cultureNum = parseInt(button.getAttribute('data-culture'));
                goToSlide(cultureNum);
            });
        });
    }

    // Arrow button click handlers
    if (prevArrow) {
        prevArrow.addEventListener('click', () => {
            if (currentSlide > 1) {
                goToSlide(currentSlide - 1);
            }
        });
    }

    if (nextArrow) {
        nextArrow.addEventListener('click', () => {
            if (currentSlide < totalSlides) {
                goToSlide(currentSlide + 1);
            }
        });
    }

    // Initialize progress/arrow states using detected currentSlide
    updateProgress(currentSlide);
}

// Initialize culture slider on page load
window.addEventListener('load', initCultureSlider);

// Handle Industries navigation from all pages.
function handleIndustriesNavigation() {
    // Skip only when already on the services route.
    if (window.location.pathname.includes('/services')) {
        return;
    }

    // Find all Industries links in navigation and footer
    const industriesLinks = document.querySelectorAll('a[href*="industries"], a[href*="#industries"], a[href*="#overview2"]');

    industriesLinks.forEach(link => {
        // Skip if already handled
        if (link.hasAttribute('data-industries-handled-global')) {
            return;
        }

        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            // Navigate to the Laravel services route section.
            if (href.includes('services.html') || href.includes('industries') || href.includes('overview2')) {
                e.preventDefault();
                const pathSegments = window.location.pathname.split('/').filter(Boolean);
                const locale = pathSegments[0] || '';
                const localePrefix = /^[a-z]{2}$/i.test(locale) ? `/${locale}` : '';
                window.location.href = `${localePrefix}/services#overview2`;
            }
        });

        link.setAttribute('data-industries-handled-global', 'true');
    });
}

// Initialize Industries navigation
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', handleIndustriesNavigation);
} else {
    handleIndustriesNavigation();
}

// Also handle links that might be added dynamically
setTimeout(handleIndustriesNavigation, 500);

console.log('A.M.C. Website Initialized - 32 Years of Excellence');
