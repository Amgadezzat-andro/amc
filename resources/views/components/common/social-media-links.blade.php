@if(isset($socialMediaLinks) && $socialMediaLinks->isNotEmpty())
<div class="{{ ($view ?? null) == 'social-links' ? 'social-links' : 'footer-social' }}">
    @foreach ($socialMediaLinks as $socialMediaLink)
        <a {!! Utility::printAllUrl($socialMediaLink->url) !!} class="text-white/70 hover:text-teal-400 transition inline-flex items-center justify-center w-10 h-10" aria-label="{{ $socialMediaLink->title ?? 'Social' }}">
            <i class="{{ $socialMediaLink->getIcon() }} text-xl" aria-hidden="true"></i>
        </a>
    @endforeach
</div>
@endif
