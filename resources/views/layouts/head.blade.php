<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seoTitle ? 'AMC - ' . $seoTitle : 'A.M.C' }}</title>
    <link rel="icon" href="{{ $favIcon?->largeUrl }}">


    @php
        $seoDescription = strip_tags($seoDescription);
        $seoDescription = trim(preg_replace('/\s+/', ' ', $seoDescription));
    @endphp
    <x-common.seo :seoTitle="$seoTitle" :seoDescription="$seoDescription" :seoKeywords="$seoKeywords" :seoAuther="$seoAuther" :seoImage="$seoImage"
        :seoOGType="$seoOGType" :seoTwitterType="$seoTwitterType" :seoSchema="$seoSchema" />


    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('css')


    @livewireStyles


    <link href="{{ asset('/css/custom.css') }}" type="text/css" rel="stylesheet" />


    <x-common.external-analytics />
</head>
