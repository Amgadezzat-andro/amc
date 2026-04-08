<x-layouts.layout 
  seoTitle="{{ $taregtPage->title }}" 
  seoDescription="{{ $taregtPage->brief }}" 
  seoKeywords="{{ $taregtPage->keywords }}" 
  seoImage="{{ $taregtPage->mainImage?->url }}"
  layoutView="main-inner"
>

@push('css')
@endpush



@section('content')


  <section class="bg-gray py-5 basic-page">
    <div class="container">
      <p> {{ $taregtPage->brief }} </p>
      <div class="cms-content">
        {!! Content::inlineStyleToClasses($taregtPage->content)  !!}
      </div>
    </div>

    @if($taregtPage->firstSections->isNotEmpty())
      <section class="container my-5">
        <div class="row">

          <div class="col-md-3">
            <div class="card">
              <ul class="nav nav-tabs flex-column list-group list-group-flush" id="myTab" role="tablist">
                
                @foreach ($taregtPage->firstSections as $indxe => $firstSection)
                  <li class="nav-item list-group-item " role="presentation">
                    <button 
                      class="nav-link {{ $indxe==0? 'active' : '' }}" 
                      id="tab-{{ $firstSection->slug }}-tab" 
                      data-bs-toggle="tab" 
                      data-bs-target="#tab-{{ $firstSection->slug }}" 
                      aria-controls="tab-{{ $firstSection->slug }}"
                      type="button" role="tab" aria-selected="true">
                        {{ $firstSection->title }}
                    </button>
                  </li>
                @endforeach
                  
              </ul>
            </div>
          </div>

          <div class="col-md-9 gx-5">

            <div class="tab-content" id="myTabContent"> 

              @foreach ($taregtPage->firstSections as $indxe => $firstSection)
                <div class="tab-pane fade {{ $indxe==0? 'show active' : '' }} " id="tab-{{ $firstSection->slug }}" role="tabpanel" aria-labelledby="tab-{{ $firstSection->slug }}-tab">
                  <h2 class="py-2 primary-color p-title"> {{ $firstSection->title }} </h2>
                  <div class="pb-4">
                    <div class="cms-content">
                      {!! Content::inlineStyleToClasses($firstSection->content)  !!}
                    </div>
                  </div>
                </div>
              @endforeach

            </div>

            <a {!! Utility::printAllUrl( $taregtPage->second_title ) !!} class="bg-primary-color p-title text-white rounded-1 border-0 px-2 py-1 anchor-none">
              {{ __("site.JOIN_US") }}
            </a>

          </div>
          
        </div>
      </section>

    @endif

  </section>



@endsection

</x-layouts.layout>