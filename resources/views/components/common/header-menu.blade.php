@if (isset($menuParents) && $menuParents)
        @foreach ($menuParents as $item)
            @php
                $currentPath = '/' . request()->path();
                $isActive = Str::endsWith($currentPath, $item->link);
            @endphp
            <a {!! Utility::printAllUrl($item->link) !!} class="text-white/90 hover:text-teal-700 transition font-medium {{ $isActive ? 'active' : '' }}">
                {{ $item->title }}
            </a>

        @endforeach
@endif
