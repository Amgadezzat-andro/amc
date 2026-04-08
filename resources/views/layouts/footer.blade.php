    <!-- Footer -->
    <footer id="footer-section" class="footer">
        <div class="footer-content">
            <!-- Footer Logo -->


            <div class="footer-top">
                <div class="footer-grid">
                    <x-common.footer-menu categorySlug="footer-menu" />

                    <div class="footer-col">
                        <h4>Connect With Us</h4>
                        <div class="footer-contact">
                            <p><i class="fas fa-phone"></i> <span
                                    style="color: #b0bec5;">{{ setting('site.phone') }}</span></p>
                            <p><i class="fas fa-envelope"></i> <a
                                    href="https://mail.google.com/mail/?view=cm&fs=1&to={{ setting('site.management_email') }}"
                                    target="_blank"
                                    style="color: #b0bec5; text-decoration: none;">{{ setting('site.management_email') }}</a>
                            </p>
                            <p><i class="fas fa-map-marker-alt"></i> <a href="{{ setting('site.location_url') }}"
                                    target="_blank"
                                    style="color: #b0bec5; text-decoration: none;">{{ $locationTitle }}</a>
                            </p>
                        </div>
                        <x-common.social-media-links />
                        <div class="stamp-with-gradient">
                            {{-- <img src="assets/stamp.png" alt="Stamp"> --}}
                        <x-common.webp-image :allowWebpMobile="false" :allowWebpTablet="false" :mediaObject='$footerLogo' alt='Footer Logo' />
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 A.M.C. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- <x-common.accessibility-tools /> --}}



    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>


    @livewireScripts

    @stack('js')

    <script type="text/javascript" src="{{ asset('/js/custom.js') }}"></script>
