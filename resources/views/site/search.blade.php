<x-layouts.layout
  seoTitle="{{__('site.SEARCH')}}"
  seoDescription="{{__('site.SEARCH_DESCRIPTION')}}"
>

@push('css')
    <link href="{{ asset('/css/SearchInner.css') }}" rel="stylesheet" type="text/css"  />
@endpush


@section('content')

<main>
    <x-common.header-image :innerItem=null />
            <form class="mb-3 mt-3 container search-form-container border-0" method="post"
                action="{{ route('search', ['locale' => app()->getLocale()]) }}">
                @csrf
                <input name="search_word" type="search" id="search"  class="form-control" placeholder="{{ __('site.SEARCH') }}"
                    value="{{ $searchWord ?? '' }}"  />
                 <button
                    class="btn-border-outline primary-color blog-btn blog-read-more">
                     {{ __('site.SEARCH') }}
                 </button>
            </form>

    <div class="container searchPageContainer">
        <div class="row flex-column-reverse flex-md-row">
          <div class=" ">
            <div class="search-container">

                <div class="product my-3">

                    @if( isset($searchSections) )
                        @foreach($searchSections as $searchSection)

                            @if( count( $searchSection["items"] )  )

                                <div id="{{$searchSection['pagination_name']}}">
                                    <?php $item_url = $searchSection["main_item_url"]; ?>
                                    @if ($item_url === null)
                                    <h4>{{$searchSection["title"]}}  </h4>

                                    @else
                                    <h4> <a href="{{ route($item_url,['locale'=> app()->getLocale()]) }}">{{$searchSection["title"]}}</a>  </h4>

                                    @endif

                                    @foreach($searchSection["items"] as $item)
                                        <div class="search-product__card">
                                            <h3>
                                                @php($title = $searchSection['item_title'] )
                                                @php($url = $searchSection['item_url'] )
                                                @if($searchSection['pagination_name'] == "service")
                                                    <a href="{{route($url, ['slug' => $item->slug, 'locale'=> app()->getLocale(), 'category_slug' => $item->category?->slug ] )}}" >
                                                @else
                                                    <a href="{{route($url, ['slug' => $item->slug, 'locale'=> app()->getLocale() ] )}}" >
                                                @endif
                                                    {{$item->$title}}
                                                </a>
                                            </h3>
                                            <p>
                                                @php($brief = $searchSection['item_brief'] )
                                                {{$item->$brief}}
                                            </p>
                                        </div>
                                    @endforeach

                                    @if($searchSection["items"]->hasMorePages())
                                        <div class="search-read-more">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="add--read_more">
                                                    <a class="load-more" href="{{ $searchSection['items']->nextPageUrl() }}"   data-section="{{$searchSection['pagination_name']}}"  >
                                                        <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        viewBox="0 0 24 24"
                                                        fill="#c9ac80"
                                                        stroke="#c9ac80"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-plus"
                                                        >
                                                        <path d="M5 12h14" />
                                                        <path d="M12 5v14" />
                                                        </svg>
                                                        {{__('site.LOAD_MORE')}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>

                            @endif

                        @endforeach
                    @endif



                </div>


            </div>
          </div>
        </div>
    </div>

</main>

@endsection




@push('js')

    <script  >

        $(document).on("click",".load-more",function(e){

            $(this).attr("disabled","disabled");
            e.preventDefault();
            console.log($(this).attr('href') );
            let section = "#"+$(this).attr("data-section");
            let sectionPagination = $(this);
            console.log(section);

            $.post($(this).attr('href'), {"_token": "{{ csrf_token() }}"}, function(response){
                console.log(response);
                $(sectionPagination).remove();
                $(section).append(response);
            });




        });

    </script>

@endpush


</x-layouts.layout>
