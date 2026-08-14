{{-- resources/views/layouts/app.blade.php --}}
@php
    use App\Models\ServicesType;
    use App\Support\HomeContent;

    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $setup = HomeContent::setup();
    $navAvailability = HomeContent::availability();
    $asset = fn ($path) => $path ? asset('storage/' . ltrim($path, '/')) : null;
    $tr = function ($field) use ($locale) {
        if (is_array($field)) {
            return $field[$locale] ?? $field['ar'] ?? (reset($field) ?: '');
        }

        return $field ?? '';
    };

    try {
        $footerServices = ServicesType::query()
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->limit(6)
            ->get();
    } catch (Throwable) {
        $footerServices = collect();
    }
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ \App\Support\Seo::title(trim($__env->yieldContent('title')) ?: null) }}</title>
@include('partials.seo')
@stack('meta')

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endif

<link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
<link rel="icon" href="{{ $setup['siteLogo'] ? $asset($setup['siteLogo']) : asset('logo.png') }}">
<link rel="apple-touch-icon" href="{{ $setup['siteLogo'] ? $asset($setup['siteLogo']) : asset('logo.png') }}">

@include('partials.local-fonts')

<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.14.1/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.1/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

@include('partials.home.head-styles')

<style>
    body{
        background:#fff;
        color:var(--teal);
    }
    .inner-page-main{
        position:relative;
        z-index:10;
        min-height:45vh;
    }
    .inner-page-main::before{
        content:"";
        position:absolute;
        inset:0;
        pointer-events:none;
        background:
            radial-gradient(ellipse 60% 30% at 100% 0%, rgba(245,173,42,.08), transparent 60%),
            radial-gradient(ellipse 55% 35% at 0% 12%, rgba(82,105,112,.08), transparent 65%);
        z-index:-1;
    }
</style>
@stack('styles')
</head>

<body class="bg-white min-h-screen font-body" x-data="{ mobileMenuOpen: false, activeSection: '{{ request()->routeIs('home') ? 'home' : '' }}' }">
@include('partials.home.topbar', [
    'socialLinks' => $setup['socialLinks'],
    'sitePhone' => $setup['sitePhone'],
    'siteEmail' => $setup['siteEmail'],
    'siteAddress' => $setup['siteAddress'],
    'topNotice' => $setup['topNotice'],
])

@include('partials.home.navbar', [
    'siteLogo' => $setup['siteLogo'],
    'siteName' => $setup['siteName'],
    'asset' => $asset,
    'floating' => false,
    'navAvailability' => $navAvailability,
])

<main class="inner-page-main">
    @yield('content')
</main>

@include('partials.home.footer', [
    'siteLogo' => $setup['siteLogo'],
    'siteName' => $setup['siteName'],
    'socialLinks' => $setup['socialLinks'],
    'services' => $footerServices,
    'tr' => $tr,
    'siteAddress' => $setup['siteAddress'],
    'sitePhone' => $setup['sitePhone'],
    'siteEmail' => $setup['siteEmail'],
    'workingHours' => $setup['workingHours'],
    'asset' => $asset,
    'navAvailability' => $navAvailability,
])

@stack('scripts')
</body>
</html>
