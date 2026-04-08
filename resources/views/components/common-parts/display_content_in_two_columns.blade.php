@php
    preg_match_all('/<([a-zA-Z0-9]+)[^>]*>(.*?)<\/\1>/s', $content, $matches);
    $tags = $matches[0];
    $totalTags = count($tags);
    $firstGroup = array_slice($tags, 0, ceil($totalTags / 2));
    $secondGroup = array_slice($tags, ceil($totalTags / 2));
@endphp

    <div>
        @foreach($firstGroup as $tag)

            {!! Content::inlineStyleToClasses($tag)  !!}
        @endforeach
    </div>
    <div>
        @foreach($secondGroup as $tag)
        {!! Content::inlineStyleToClasses($tag)  !!}
        @endforeach

    </div>


