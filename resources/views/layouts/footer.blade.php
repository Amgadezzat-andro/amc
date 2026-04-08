

    <footer class="bg-gray-900 border-t border-gray-800 py-12">
        <div class="mx-auto px-4 lg:px-8">
            <div class="flex flex-wrap justify-between gap-8 mb-8 items-start">
                <div class="min-w-0 flex-shrink-0">
                    <x-common.webp-image :allowWebpMobile="false" :allowWebpTablet="false" :mediaObject='$footerLogo' alt='Footer Logo' imgClass="h-12 w-auto mb-4" />
                    <span class="text-2xl font-bold bg-gradient-to-r from-teal-400 to-blue-400 bg-clip-text text-transparent hidden" style="display: none;">AG Energies</span>
                    <p class="text-white/70 mb-4">Leading EPC company
                        <br> specializing in solar energy solutions
                        <br>
                         across Tanzania.</p>
                    <x-common.social-media-links />

                </div>

                <div class="flex flex-wrap gap-x-10 gap-y-6 min-w-0">
                    <x-common.footer-menu categorySlug="footer-menu" />
                </div>

                <div class="min-w-0 flex-shrink-0 text-left">
                    <h4 class="text-lg font-bold mb-4 text-white">Contact</h4>
                    <ul class="space-y-2 text-white/70">
                        <li><i class="fas fa-phone mr-2"></i> {{ setting('site.phone') }}</li>
                        <li><i class="fas fa-envelope mr-2"></i>{{ setting('site.management_email') }}</li>
                        <li><i class="fas fa-clock mr-2"></i>{{ __('site.WORKING_HOURS') }}</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>Copyright © All Rights Reserved AG Energies | Powered By Syscom Technologies</p>
            </div>
        </div>
    </footer>

    <button id="backToTop" class="fixed bottom-8 right-8 glass rounded-full p-4 hover:bg-white/10 transition opacity-0 pointer-events-none z-50" aria-label="Back to top">
        <i class="fas fa-arrow-up text-white"></i>
    </button>

    {{-- <x-common.accessibility-tools /> --}}




    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>


    @livewireScripts

    @stack('js')

    <script type="text/javascript" src="{{ asset('/js/custom.js') }}"></script>
