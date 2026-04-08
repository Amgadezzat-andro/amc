@if (isset($menuParents) && $menuParents)
    @foreach ($menuParents as $footerItem)
        <div class="footer-col">
            <h4 >{{ $footerItem->title }}</h4>
            @if (count($footerItem->childs))
                <ul >
                    @foreach ($footerItem->childs as $SubFooterItem)
                        <li><a {!! Utility::printAllUrl($SubFooterItem->link) !!}>{{ $SubFooterItem->title }}</a></li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach
@endif

