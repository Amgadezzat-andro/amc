<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" href="{{ $favIcon?->largeUrl }}">

    @php
        $seoDescription = strip_tags($seoDescription);
        $seoDescription = trim(preg_replace('/\s+/', ' ', $seoDescription));
    @endphp
    <x-common.seo :seoTitle="$seoTitle" :seoDescription="$seoDescription" :seoKeywords="$seoKeywords" :seoAuther="$seoAuther" :seoImage="$seoImage"
        :seoOGType="$seoOGType" :seoTwitterType="$seoTwitterType" :seoSchema="$seoSchema" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    @stack('css')


    @livewireStyles


    <link href="{{ asset('/css/custom.css') }}" type="text/css" rel="stylesheet" />


    <x-common.external-analytics />

</head>



