    <!-- Top Header Bar -->
    <div class="top-header">
        <div class="container">
            <div class="top-header-content">
                <div class="contact-info">
                    <a href="tel:{{ setting('site.phone') }}" class="contact-info-link"><i class="fas fa-phone"></i>
                        {{ setting('site.phone') }}</a>
                    <a href="mailto:{{ setting('site.management_email') }}" class="contact-info-link"><i
                            class="fas fa-envelope"></i> {{ setting('site.management_email') }}</a>
                </div>
                <x-common.social-media-links :view="'social-links'" />

            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <a href="/">
                        <x-common.webp-image :mediaObject='$logo' alt='{{ setting("{$lng}.general.title") }}'
                            imgClass="h-8 w-auto" url="/" :withAnchor="true" allowWebp="{{ true }}"
                            :allowWebpMobile="false" :allowWebpTablet="false" /> </a>
                </div>

                <button class="mobile-menu-toggle" aria-label="Toggle menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <ul class="nav-menu">
                    <li class="mobile-sidebar-logo">
                        <x-common.webp-image :mediaObject='$logo' alt='{{ setting("{$lng}.general.title") }}'
                            imgClass="h-8 w-auto" url="/" :withAnchor="true" allowWebp="{{ true }}"
                            :allowWebpMobile="false" :allowWebpTablet="false" />
                    </li>
                    <x-common.header-menu />
                    <li class="nav-item cta">
                        <a href="#" class="btn-consultation" id="openConsultationModal">Book your Consultation</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
