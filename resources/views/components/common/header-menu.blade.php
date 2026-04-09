@if (isset($menuParents) && $menuParents)
    @foreach ($menuParents as $item)
        @php
            $currentPath = '/' . ltrim(request()->path(), '/');
            $itemLink = (string) $item->link;
            $itemPath = parse_url($itemLink, PHP_URL_PATH) ?: $itemLink;
            $itemPath = '/' . ltrim($itemPath, '/');
            $isHomeLink = $itemPath === '/';
            $isActive = $isHomeLink
                ? request()->routeIs('home')
                : ($currentPath === $itemPath || Str::endsWith($currentPath, $itemPath));
            $hasChildren = isset($item->childs) && $item->childs->count();
        @endphp

        @if ($hasChildren)
            <li class="nav-item dropdown {{ $isActive ? 'active' : '' }}">
                <a {!! Utility::printAllUrl($item->link) !!}>
                    {{ $item->title }} <i class="fas fa-chevron-down"></i>
                </a>
                <div class="dropdown-menu">
                    @foreach ($item->childs as $subItem)
                        @if (isset($subItem->childs) && $subItem->childs->count())
                            @foreach ($subItem->childs as $subSubItem)
                                <a {!! Utility::printAllUrl($subSubItem->link) !!}>{{ $subSubItem->title }}</a>
                            @endforeach
                        @else
                            <a {!! Utility::printAllUrl($subItem->link) !!}>{{ $subItem->title }}</a>
                        @endif
                    @endforeach
                </div>
            </li>
        @else
            <li class="nav-item {{ $isActive ? 'active' : '' }}">
                <a {!! Utility::printAllUrl($item->link) !!}>
                    {{ $item->title }}
                </a>
            </li>
        @endif
    @endforeach
@endif
