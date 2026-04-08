<section class="bg-white  p-0 mt-4 my-2">
    <div class="container mt-0 my-2 pt-2 pb-4">
        <div class="d-flex align-items-center justify-content-between py-3 mt-4">

            <div>
                <h1> {{$lastBreadCrumpTitle}} </h1>
                <div class="">
                    <ul class="list-unstyled d-flex align-items-center m-0">
                        <li class="px-2">
                            <a href="{{ route("home", ["locale"=>$lng]) }}" class="secondary-color p-title"> {{__('site.HOME')}} </a>
                        </li>
                        
                        @foreach ($breacdCrumpUrls as $breacdCrumpUrl)
                            <i class="fa-solid fa-angle-left"></i>
                            <li class="px-2">
                                <a {!! Utility::printAllUrl( $breacdCrumpUrl['link'] ) !!} class="secondary-color p-title"> {{ $breacdCrumpUrl['title'] }} </a>
                            </li>                    
                        @endforeach

                        <i class="fa-solid fa-angle-left"></i>
                        <li class="px-2">
                            <a href="javascript:void(0);" class="p-title primary-color anchor-none"> {{$lastBreadCrumpTitle}} </a>
                        </li>
                    </ul>
                </div>
            </div>

            @if(isset($hasFilter) && $hasFilter)
                <button class="filter-btn">
                    <i class="fa-solid fa-sliders px-2"></i>
                    <span>{{ __("site.FILTER") }}</span>
                </button>
            @endif

        </div>
    </div>
</section>