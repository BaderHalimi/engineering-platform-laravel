@php
    $brand = config('site.brand');
    $navItems = config('site.nav');
    $pageTitle = trim($__env->yieldContent('title')) ?: $brand['name'];
    $pageDescription = trim($__env->yieldContent('description')) ?: 'حلول تصميم ورخص بناء تساعدك على فهم خطوات مشروعك من البداية، بما يراعي احتياجك ومتطلبات الكود السعودي.';
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">

    <link rel="icon" href="{{ asset('logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <title>{{ \App\Support\Seo::title($pageTitle) }}</title>
    @include('partials.seo', ['seoDescription' => $pageDescription])
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @endif
    <style>
        .brand-logo { height: 64px; width: auto; min-width: 140px; object-fit: contain; }
        @media (max-width: 680px) { .brand-logo { height: 52px; min-width: 110px; } }
    </style>
    @stack('styles')
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand-link" href="/" aria-label="{{ $brand['name'] }}">
                <img class="brand-logo" src="{{ asset('logo.png') }}" alt="{{ $brand['name'] }}">
                <span class="brand-slogan">{{ $brand['slogan'] }}</span>
            </a>
            <nav class="nav-menu" aria-label="التنقل الرئيسي">
                @foreach ($navItems as $item)
                    <a href="{{ $item['href'] }}" @class(['is-active' => request()->path() === trim($item['href'], '/') || (request()->is('/') && $item['href'] === '/')])>{{ $item['label'] }}</a>
                @endforeach
            </nav>
            <div class="header-actions">
                <a class="language-link" style="opacity:.4;pointer-events:none;cursor:default;">English</a>
                <a class="btn btn-primary" href="/request-service">اطلب خدمة</a>
            </div>
        </div>
    </header>
    <main class="page">
        @yield('content')
    </main>
    <footer class="site-footer">
        <div class="container footer-inner">
            <p class="footer-copy">{{ $brand['name'] }} &copy; {{ date('Y') }}</p>
            <nav class="footer-links" aria-label="روابط الفوتر">
                <a href="/services">الخدمات</a>
                <a href="/projects">المشاريع</a>
                <a href="/faq">الأسئلة الشائعة</a>
                <a href="/privacy">الخصوصية</a>
                <a href="/terms">الشروط</a>
            </nav>
        </div>
    </footer>
</body>
</html>
