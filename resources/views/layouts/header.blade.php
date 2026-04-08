    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="navbar">
        <nav class="mx-auto px-4 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <x-common.webp-image :mediaObject='$logo' alt='{{ setting("{$lng}.general.title") }}'
                    imgClass="h-10 w-auto mr-3" url="/" :withAnchor="true"
                    allowWebp="{{ true }}" :allowWebpMobile="false" :allowWebpTablet="false" />
                    <span class="text-2xl font-bold text-white hidden d-none" >AG Energies</span>
                </div>
                <div class="hidden lg:flex items-center space-x-8">
                    <x-common.header-menu />
                    <a {!! Utility::printAllUrl($internUrl) !!} class="btn-orange-gradient px-6 py-2 text-white rounded-lg transition shadow-md inline-block">
                        {{ __('site.Get a Quote') }}
                    </a>
                </div>
                <button id="mobileMenuBtn" class="lg:hidden text-white" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobileMenu">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </nav>
        <div id="mobileMenuOverlay" class="mobile-menu-overlay lg:hidden"></div>
        <div id="mobileMenu" class="mobile-menu lg:hidden fixed bg-gradient-to-r from-slate-800 to-slate-900 backdrop-blur-lg shadow-lg">
            <div class="px-6 py-6 h-full flex flex-col">
                <div class="flex justify-between items-center mb-8">
                    <x-common.webp-image :mediaObject='$logo' alt='{{ setting("{$lng}.general.title") }}'
                    imgClass="h-8 w-auto" url="/" :withAnchor="true"
                    allowWebp="{{ true }}" :allowWebpMobile="false" :allowWebpTablet="false" />
                    <span class="text-xl font-bold text-white hidden d-none" >AG Energies</span>
                    <button id="closeMenuBtn" class="text-white" aria-label="Close menu">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                <div class="flex flex-col space-y-4 flex-1">
                    <x-common.header-menu />
                    <a href="{{ route('get-a-quote', ['locale' => $lng]) }}" class="btn-orange-gradient px-6 py-2 rounded-lg transition mt-4 inline-block">
                        {{ __('site.Get a Quote') }}
                    </a>
                </div>
            </div>
        </div>
    </header>
