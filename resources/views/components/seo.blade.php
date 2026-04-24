@props([
    'title'       => null,
    'description' => null,
    'canonical'   => null,
    'ogType'      => 'website',
    'ogImage'     => null,
    'noindex'     => false,
    'jsonld'      => null,
])

@php
    $siteName    = config('site.name', config('app.name', 'Viam Semicon'));
    $defaultTitle = config('site.seo.title', $siteName . ' - Thiết bị đo lường, Robot vận chuyển, RF Cable');
    $defaultDesc  = config('site.seo.description', 'Viam Semicon chuyên cung cấp thiết bị đo lường, robot vận chuyển, RF cable & adapters chính hãng.');
    $defaultImage = asset('images/logo.png');

    $resolvedTitle = $title
        ? (str_contains($title, $siteName) ? $title : $title . ' - ' . $siteName)
        : $defaultTitle;

    $resolvedDesc  = $description ?: $defaultDesc;
    $resolvedImage = $ogImage ? (str_starts_with($ogImage, 'http') ? $ogImage : url($ogImage)) : $defaultImage;
    $resolvedUrl   = $canonical ?: url()->current();
@endphp

<title>{{ $resolvedTitle }}</title>
<meta name="description" content="{{ Str::limit(strip_tags($resolvedDesc), 160, '...') }}">
<meta name="robots" content="{{ $noindex ? 'noindex, nofollow' : 'index, follow' }}">
<link rel="canonical" href="{{ $resolvedUrl }}">

{{-- Open Graph --}}
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="vi_VN">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:title" content="{{ $resolvedTitle }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($resolvedDesc), 200, '...') }}">
<meta property="og:url" content="{{ $resolvedUrl }}">
<meta property="og:image" content="{{ $resolvedImage }}">

{{-- Twitter Cards --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $resolvedTitle }}">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($resolvedDesc), 200, '...') }}">
<meta name="twitter:image" content="{{ $resolvedImage }}">

{{-- JSON-LD --}}
@if($jsonld)
    {!! $jsonld !!}
@endif
