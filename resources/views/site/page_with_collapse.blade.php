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
      <div class="container">
        <div class="accordion w-100 max-w-2xl" id="accordionExample">

          @foreach ($taregtPage->firstSections as $firstSection)
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading-{{ $firstSection->slug }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $firstSection->slug }}" aria-expanded="false" aria-controls="collapse-{{ $firstSection->slug }}">
                  {{$firstSection->title}}
                  <i class="fas fa-plus "></i>
                </button>
              </h2>
              <div id="collapse-{{ $firstSection->slug }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $firstSection->slug }}" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="cms-content">
                    {!! Content::inlineStyleToClasses($firstSection->content)  !!}
                  </div>
                </div>
              </div>
            </div>
          @endforeach

        </div>
      </div>
    @endif

  </section>



@endsection

</x-layouts.layout>