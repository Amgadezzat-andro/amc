@php
    preg_match_all('/<([a-zA-Z0-9]+)[^>]*>(.*?)<\/\1>/s', $content, $matches);
    $tags = $matches[0];
    $totalTags = count($tags);
    $firstGroup = array_slice($tags, 0, ceil($totalTags / 2));
    $secondGroup = array_slice($tags, ceil($totalTags / 2));
@endphp

<div class="cms-content">
    @foreach ($firstGroup as $tag)
        {!! Content::inlineStyleToClasses($tag) !!}
    @endforeach
</div>

@if ($selectedArticle)
    <div class="container border-top border-bottom py-3 my-4">
        <div class="container-2-to-1">
            <div>
                <h3 class="primary-color"> {{ __('site.READ_ALSO') }} </h3>
                <span class="category m-0"> {{ $selectedArticle->department }} </span>
                <a href="" class="nav-link">
                    <h3> {{ $selectedArticle->title }} </h3>
                </a>
            </div>

            <div>

                <x-common.webp-image :mediaObject='$selectedArticle->mainImage' :alternativeImage="$alternativeArticleImage->url" :alt="$selectedArticle->title" :withAnchor="true"
                    url="{{ $selectedArticle->articleUrl }}"
                    imgClass="cover-image-class article-aspect-ratio image-boder-raduis" :allowWebpMobile="false"
                    :allowWebpTablet="false" />
            </div>

        </div>
    </div>
@endif

<div class="cms-content">
    @foreach ($secondGroup as $tag)
        {!! Content::inlineStyleToClasses($tag) !!}
    @endforeach
</div>
