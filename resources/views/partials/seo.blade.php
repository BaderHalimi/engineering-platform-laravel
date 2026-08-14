@php
    use App\Models\Setup;
    use App\Support\Seo;

    $rawTitle = trim($__env->yieldContent('title')) ?: ($seoTitle ?? Setup::get('site_name', config('app.name')));
    $pageTitle = Seo::title($rawTitle);
    $pageDescription = Seo::description(trim($__env->yieldContent('description')) ?: ($seoDescription ?? null));
    $canonical = $seoCanonical ?? url()->current();
    $robots = $seoRobots ?? (request()->query() ? 'noindex,follow' : 'index,follow');
    $image = $seoImage ?? asset('logo.png');
    $type = $seoType ?? 'website';
    $schema = collect($seoSchema ?? [])
        ->prepend(Seo::website($pageTitle, $pageDescription))
        ->prepend(Seo::organization())
        ->filter()
        ->values()
        ->all();
@endphp

<meta name="description" content="{{ $pageDescription }}">
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $canonical }}">
<link rel="alternate" hreflang="{{ app()->getLocale() }}" href="{{ $canonical }}">
<link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">
<link rel="icon" href="{{ asset('logo.png') }}">
<link rel="apple-touch-icon" href="{{ asset('logo.png') }}">

<meta property="og:locale" content="{{ app()->getLocale() === 'ar' ? 'ar_SA' : 'en_US' }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:site_name" content="{{ Setup::get('site_name', config('app.name')) }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ $image }}">

@foreach($schema as $item)
<script type="application/ld+json">@json($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
@endforeach
