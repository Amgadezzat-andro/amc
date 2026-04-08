@if (isset($menuParents) && $menuParents)
    @foreach ($menuParents as $footerItem)
        <div>
            <h4 class="text-lg font-bold mb-4 text-white">{{ $footerItem->title }}</h4>
            @if (count($footerItem->childs))
                <ul class="space-y-2">
                    @foreach ($footerItem->childs as $SubFooterItem)
                        <li><a {!! Utility::printAllUrl($SubFooterItem->link) !!} class="text-white/70 hover:text-teal-400 transition">{{ $SubFooterItem->title }}</a></li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach
@endif
