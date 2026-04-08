                    
                    
                    @if( isset($searchSections) )
                        @foreach($searchSections as $searchSection)

                            @if( count( $searchSection["items"] )  )


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

                            @endif

                        @endforeach
                    @endif



