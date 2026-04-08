@if (isset($menuParents) && $menuParents)
    @foreach ($menuParents as $item)
        @php
            $currentPath = '/' . request()->path();
            $isActive = Str::endsWith($currentPath, $item->link);
            $hasChildren = isset($item->childs) && $item->childs->count();
        @endphp

        @if ($hasChildren)
            <li class="nav-item dropdown">
                <a {!! Utility::printAllUrl($item->link) !!} class="{{ $isActive ? 'active' : '' }}">
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
            <li class="nav-item">
                <a {!! Utility::printAllUrl($item->link) !!} class="{{ $isActive ? 'active' : '' }}">
                    {{ $item->title }}
                </a>
            </li>
        @endif
    @endforeach
@endif
