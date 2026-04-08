@if (isset($menuParents) && $menuParents)

    <ul class="navbar-nav mb-lg-0 custom-nav gap-2">

        @foreach ($menuParents as $item)
            @if (count($item->childs))
                <li class="dropdown-menu-news-li-parent nav-link container relative py-4 custom-border-bottom">
                    <div class="d-flex justify-content-between w-100">
                        <a class="custom-dropdown nav-link text-decoration-none primary-color d-flex align-items-center"
                            {!! Utility::printAllUrl($item->link) !!}>
                            <h6>{{ $item->title }}</h6>
                            <i class="fa-solid fa-chevron-down px-1 d-none d-lg-block">
                            </i>
                        </a>
                        <button class="toggleButtonGeneral d-lg-none fs-4 px-3 border-0 bg-transparent primary-color"
                            data-target="#tab-main-{{ $item->id }}">
                            <i class="fa-solid fa-chevron-down open-list"></i>
                            <i class="fa-solid fa-chevron-up d-none close-list"></i>
                        </button>
                    </div>
                    <div id="tab-main-{{ $item->id }}" class="d-none d-lg-block w-100 container">
                        <div class="dropdown-menu-news">
                            <div class="bg-custom-blue text-white">
                                <h3 class="mb-3">{{ $item->title }}</h3>
                                <h6 class="mb-0">
                                    {{ $item->brief }}
                                </h6>
                            </div>

                            @foreach ($item->childs as $subItem)
                                <ul>
                                    @if (count($subItem->childs))
                                        @if ($subItem->title !== '&nbsp;')
                                            <div class="d-flex justify-content-between nested-links container">
                                                <h4 class="secondary-color mb-lg-2">{{ $subItem->title }}</h4>
                                                <button
                                                    class="toggleButtonGeneral d-lg-none fs-4 px-3 border-0 bg-transparent primary-color"
                                                    data-target="#tab-sub-{{ $subItem->id }}">
                                                    <i class="fa-solid fa-chevron-down open-list"></i>
                                                    <i class="fa-solid fa-chevron-up d-none close-list"></i>
                                                </button>
                                            </div>

                                            <div id="tab-sub-{{ $subItem->id }}" class="d-none d-lg-block container">
                                                @foreach ($subItem->childs as $subsubItem)
                                                    <li>
                                                        <a {!! Utility::printAllUrl($subsubItem->link) !!}
                                                            class="d-flex gap-1 align-items-center last-link">
                                                            <h5 class="primary-color {{$subsubItem->custom_color_class}}">                                                                {{-- subsubItem->title --}}
                                                                {{ $subsubItem->title }}
                                                            </h5>
                                                            <i
                                                                class="fa-solid fa-angle-{{ $lng == 'en' ? 'right' : 'left' }} px-2 pt-1 primary-color  {{$subsubItem->custom_color_class}}"></i>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </div>
                                        @else
                                            @foreach ($subItem->childs as $subsubItem)
                                                {{-- <ul> --}}
                                                    <div class="d-flex justify-content-between nested-links container">
                                                        <li>
                                                            <a {!! Utility::printAllUrl($subsubItem->link) !!}
                                                                class="d-flex gap-1 align-items-center last-link">
                                                                <h5 class="primary-color mb-0 {{$subsubItem->custom_color_class}}">{{ $subsubItem->title }}
                                                                </h5>
                                                                <i
                                                                    class="fa-solid fa-angle-{{ $lng == 'en' ? 'right' : 'left' }} px-2 pt-1 primary-color d-none d-lg-block  {{$subsubItem->custom_color_class}}"></i>
                                                            </a>
                                                        </li>
                                                    </div>
                                                {{-- </ul> --}}
                                            @endforeach
                                        @endif

                                    @else
                                        <ul>
                                            <div class="d-flex justify-content-between nested-links container">
                                                <li>
                                                    <a {!! Utility::printAllUrl($subItem->link) !!}
                                                        class="d-flex gap-1 align-items-center last-link">
                                                        <h5 class="primary-color mb-0">{{ $subItem->title }}</h5>
                                                        <i
                                                            class="fa-solid fa-angle-{{ $lng == 'en' ? 'right' : 'left' }} px-2 pt-1 primary-color d-none d-lg-block"></i>
                                                    </a>
                                                </li>
                                            </div>
                                    @endif
                                </ul>
                            @endforeach


                        </div>
                    </div>
                </li>


                </li>
            @else
                <li
                    class="dropdown-menu-news-li-parent  w-100 container primary-color  {{ url()->current() == url($lng . $item->link) && $item->link != '' ? 'active' : '' }}">
                    <a {!! Utility::printAllUrl($item->link) !!} class="nav-link small-screen anchor-none">
                        <h6> {{ $item->title }}</h6>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>


@endif
