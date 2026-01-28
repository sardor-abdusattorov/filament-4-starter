@php
    use App\Models\Settings;

    $locale = app()->getLocale();
    $seoTitle = settings('seo.title.' . $locale) ?? config('app.name');
    $seoDescription = settings('seo.description.' . $locale) ?? '';
@endphp

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title', $seoTitle)</title>
    <meta property="og:title" content="@yield('title', $seoTitle)">

    <meta name="description" content="@yield('meta_description', $seoDescription)">
    <meta property="og:description" content="@yield('meta_description', $seoDescription)">

    @php
        $ogImageUrl = trim($__env->yieldContent('og_image'))
        ?: (Settings::getOgImage() ?? '');
    @endphp

    @if($ogImageUrl)
        <meta property="og:image" content="{{ $ogImageUrl }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="{{ $ogImageUrl }}">
    @endif

    <meta property="og:url" content="{{ url()->current() }}">

    <meta property="og:type" content="website">

    {{-- Yandex Metrika --}}
    @if(settings('metrics.yandex'))
        {!! settings('metrics.yandex') !!}
    @endif

    {{-- Google Analytics --}}
    @if(settings('metrics.google'))
        {!! settings('metrics.google') !!}
    @endif
</head>
