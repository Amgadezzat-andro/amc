function initAboutSlider() {
    const sliderContainer = document.querySelector('.about-image-slider');
    const sliderWrapper = document.querySelector('.about-image-slider .slider-wrapper');
    const slides = document.querySelectorAll('.about-image-slider .slide');
    let currentIndex = slides.length > 1 ? 1 : 0;
    let slideInterval;

    if (!sliderContainer || !sliderWrapper || slides.length === 0) return;

    const totalSlides = slides.length;
    function getSlidesToShow() { return window.innerWidth >= 768 ? 3 : 1; }
    function getMaxIndex() { return Math.max(0, totalSlides - 1); }

    function updateSlider() {
        if (!sliderWrapper) return;
        const slidesToShow = getSlidesToShow();
        const slideEl = slides[0];
        const gap = 24;
        const slideWidth = slideEl.offsetWidth + gap;
        let offset = slidesToShow === 3
            ? (currentIndex * slideWidth) - (sliderContainer.offsetWidth / 2) + (slideEl.offsetWidth / 2)
            : currentIndex * slideWidth;
        sliderWrapper.style.transform = 'translateX(-' + offset + 'px)';
        slides.forEach(function(slide, i) { slide.classList.toggle('active-slide', i === currentIndex); });
    }

    function nextSlide() { currentIndex = currentIndex >= getMaxIndex() ? 0 : currentIndex + 1; updateSlider(); }
    function prevSlide() { currentIndex = currentIndex <= 0 ? getMaxIndex() : currentIndex - 1; updateSlider(); }
    function resetInterval() { clearInterval(slideInterval); slideInterval = setInterval(nextSlide, 4000); }

    var isDragging = false, startX = 0, currentTranslate = 0, dragDelta = 0;
    function getPositionX(e) { return e.type.indexOf('mouse') !== -1 ? e.pageX : e.touches[0].clientX; }
    function dragStart(e) {
        isDragging = true; startX = getPositionX(e); dragDelta = 0;
        sliderContainer.classList.add('dragging'); clearInterval(slideInterval);
        var t = getComputedStyle(sliderWrapper).transform;
        if (t && t !== 'none') currentTranslate = new DOMMatrixReadOnly(t).m41;
    }
    function dragMove(e) { if (!isDragging) return; dragDelta = getPositionX(e) - startX; sliderWrapper.style.transform = 'translateX(' + (currentTranslate + dragDelta) + 'px)'; }
    function dragEnd() {
        isDragging = false; sliderContainer.classList.remove('dragging');
        if (dragDelta < -80) nextSlide(); else if (dragDelta > 80) prevSlide(); else updateSlider();
        resetInterval();
    }

    sliderContainer.addEventListener('mousedown', dragStart);
    sliderContainer.addEventListener('mousemove', dragMove);
    sliderContainer.addEventListener('mouseup', dragEnd);
    sliderContainer.addEventListener('mouseleave', function() { if (isDragging) dragEnd(); });
    sliderContainer.addEventListener('touchstart', dragStart, { passive: true });
    sliderContainer.addEventListener('touchmove', dragMove, { passive: true });
    sliderContainer.addEventListener('touchend', dragEnd);
    sliderWrapper.addEventListener('dragstart', function(e) { e.preventDefault(); });

    updateSlider();
    resetInterval();
    sliderContainer.addEventListener('mouseenter', function() { if (!isDragging) clearInterval(slideInterval); });
    sliderContainer.addEventListener('mouseleave', function() { if (!isDragging) resetInterval(); });
    window.addEventListener('resize', function() {
        if (currentIndex > getMaxIndex()) currentIndex = getMaxIndex();
        updateSlider();
    });
}

if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
    gsap.registerPlugin(ScrollTrigger);
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.querySelectorAll('.fade-in').forEach(function(el, i) {
            gsap.fromTo(el, { opacity: 0, y: 50 }, { opacity: 1, y: 0, duration: 0.8, delay: i * 0.1, scrollTrigger: { trigger: el, start: 'top 85%', toggleActions: 'play none none none' } });
        });
        document.querySelectorAll('.slide-in-right').forEach(function(el) {
            gsap.fromTo(el, { opacity: 0, x: 100 }, { opacity: 1, x: 0, duration: 1, scrollTrigger: { trigger: el, start: 'top 85%', toggleActions: 'play none none none' } });
        });
    }
}
document.addEventListener('DOMContentLoaded', initAboutSlider);
