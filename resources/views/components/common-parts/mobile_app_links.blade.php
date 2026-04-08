
@foreach ($mobileAppButtons as $mobileAppButton)
  <li class="call-list">
    <div class="w-150px">
      <x-common.webp-image :allowWebpMobile="false" :allowWebpTablet="false" imagePath='{{ $mobileAppButton->translate()->mainImage?->url }}' alt='{{ $mobileAppButton->label }}' imgClass="default-image-class" withAnchor="{{true}}" url="{{ $mobileAppButton->url }}" width="{{ $mobileAppButton->translate()->mainImage?->width }}" height="{{ $mobileAppButton->translate()->mainImage?->height }}" />
    </div>
  </li>
@endforeach
