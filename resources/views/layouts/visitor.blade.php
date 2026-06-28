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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $pageDescription }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('logo.png') }}">
    <title>{{ $pageTitle }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root { --bright-orange: #f5ad2a; --soft-teal: #526970; --light-mist: #eef2f3; --warm-ivory: #f8f4ec; --deep-slate: #3d5057; --slate-100: #e6ecee; --slate-200: #d0dbdf; --slate-700: #3d5057; --orange-50: #fff8e8; --white: #ffffff; --container-max: 1180px; }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; background: var(--white); color: var(--deep-slate); font-family: 'DIN Next LT Arabic', 'IBM Plex Sans Arabic', 'Tajawal', 'Segoe UI', system-ui, sans-serif; font-feature-settings: "kern"; }
        a { color: inherit; text-decoration: none; }
        select, input, textarea, button { font: inherit; }
        input, textarea, select { color: var(--deep-slate); }
        .page { overflow: hidden; background: var(--white); }
        .container { width: min(var(--container-max), calc(100% - 32px)); margin-inline: auto; }
        .section { padding-block: 64px; }
        .muted-section { background: var(--light-mist); }
        .warm-section { background: var(--warm-ivory); }
        .dark-section { background: var(--deep-slate); color: var(--white); }
        .eyebrow { margin: 0 0 12px; color: var(--bright-orange); font-size: 14px; font-weight: 800; }
        .section-title { margin: 0; color: var(--deep-slate); font-size: clamp(30px, 4vw, 42px); line-height: 1.25; font-weight: 950; letter-spacing: 0; }
        .dark-section .section-title, .dark-section h1, .dark-section h2 { color: var(--white); }
        .section-copy { margin: 16px 0 0; color: #526970; font-size: 17px; line-height: 2; }
        .dark-section .section-copy { color: rgb(255 255 255 / .75); }
        .section-head { max-width: 780px; margin-bottom: 36px; }
        .grid { display: grid; gap: 16px; }
        .two-col { display: grid; grid-template-columns: .95fr 1.05fr; gap: 32px; align-items: start; }
        .three-grid { grid-template-columns: repeat(3, 1fr); }
        .four-grid { grid-template-columns: repeat(4, 1fr); }
        .card { border: 1px solid var(--slate-200); border-radius: 8px; background: var(--white); }
        .card-pad { padding: 22px; }
        .card h3 { margin: 16px 0 0; color: var(--deep-slate); font-size: 22px; line-height: 1.35; font-weight: 900; }
        .card p { margin: 12px 0 0; color: #526970; line-height: 1.85; }
        .button-row { display: flex; flex-wrap: wrap; gap: 12px; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 44px; border-radius: 8px; padding: 12px 18px; border: 1px solid transparent; font-weight: 800; transition: transform .2s ease, box-shadow .2s ease, background .2s ease; cursor: pointer; }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary { background: var(--bright-orange); color: var(--deep-slate); box-shadow: 0 14px 30px rgb(245 173 42 / .22); }
        .btn-outline { border-color: rgb(255 255 255 / .32); color: var(--white); background: rgb(255 255 255 / .08); }
        .btn-light { border-color: var(--slate-200); color: var(--deep-slate); background: var(--white); }
        .icon-badge { display: inline-grid; place-items: center; flex: 0 0 auto; width: 38px; height: 38px; border-radius: 8px; background: #f3f7f7; color: var(--soft-teal); font-size: 13px; font-weight: 950; }
        .pill-list { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 20px; }
        .pill { border: 1px solid var(--slate-200); border-radius: 8px; background: var(--white); padding: 9px 12px; color: #526970; font-size: 14px; font-weight: 800; }
        .dark-section .pill { border-color: rgb(255 255 255 / .15); background: rgb(255 255 255 / .08); color: var(--white); }
        .site-header { position: sticky; top: 0; z-index: 50; border-bottom: 1px solid rgb(255 255 255 / .1); background: rgb(61 80 87 / .95); color: var(--white); backdrop-filter: blur(14px); }
        .header-inner { min-height: 72px; display: flex; align-items: center; justify-content: space-between; gap: 20px; }
        .brand-link { display: flex; align-items: center; gap: 12px; min-width: 0; color: var(--white); }
        .brand-logo { width: auto; height: 48px; min-width: 120px; object-fit: contain; }
        .brand-slogan { display: block; color: rgb(255 255 255 / .7); font-size: 12px; font-weight: 600; white-space: nowrap; }
        .nav-menu { display: flex; align-items: center; gap: 4px; }
        .nav-menu a { border-radius: 8px; padding: 10px 12px; color: rgb(255 255 255 / .82); font-size: 14px; font-weight: 700; transition: background .2s ease, color .2s ease; }
        .nav-menu a:hover, .nav-menu a.is-active { background: rgb(255 255 255 / .1); color: var(--white); }
        .header-actions { display: flex; align-items: center; gap: 8px; }
        .language-link { border-radius: 8px; padding: 9px 11px; color: var(--white); font-size: 14px; font-weight: 800; }
        .language-link:hover { background: rgb(255 255 255 / .1); }
        .page-hero { position: relative; overflow: hidden; background: var(--deep-slate); color: var(--white); padding-block: 72px; }
        .page-hero::before, .pattern-bg::before { content: ''; position: absolute; inset: 0; background-image: linear-gradient(to right, rgb(255 255 255 / .08) 1px, transparent 1px), linear-gradient(to bottom, rgb(255 255 255 / .08) 1px, transparent 1px); background-size: 44px 44px; mask-image: linear-gradient(to bottom, black, transparent 90%); pointer-events: none; }
        .page-hero .container { position: relative; }
        .page-hero h1 { margin: 0; max-width: 850px; font-size: clamp(38px, 6vw, 62px); line-height: 1.18; font-weight: 950; letter-spacing: 0; }
        .page-hero p { margin: 20px 0 0; max-width: 740px; color: rgb(255 255 255 / .78); font-size: 18px; line-height: 2; }
        .visual-panel { position: relative; min-height: 280px; border: 1px solid var(--slate-200); border-radius: 8px; background: var(--light-mist); overflow: hidden; }
        .visual-panel::before { content: ''; position: absolute; inset: 20px; border: 1px solid rgb(82 105 112 / .22); background-image: linear-gradient(to right, rgb(82 105 112 / .12) 1px, transparent 1px), linear-gradient(to bottom, rgb(82 105 112 / .12) 1px, transparent 1px); background-size: 26px 26px; }
        .visual-panel::after { content: ''; position: absolute; inset-inline-end: 32px; bottom: 32px; width: 46%; height: 42%; border: 8px solid var(--bright-orange); border-bottom-width: 14px; opacity: .9; }
        .project-visual { aspect-ratio: 16 / 10; background: var(--light-mist); padding: 20px; }
        .project-pattern { display: grid; grid-template-columns: repeat(5, 1fr); grid-template-rows: repeat(3, 1fr); gap: 8px; height: 100%; }
        .project-pattern span { border-radius: 4px; border: 1px solid #aec1c8; }
        .project-pattern span:nth-child(1) { grid-column: span 2; grid-row: span 3; background: rgb(82 105 112 / .2); border: 0; }
        .project-pattern span:nth-child(3) { grid-column: span 2; background: rgb(245 173 42 / .85); border: 0; }
        .project-pattern span:nth-child(4) { background: var(--deep-slate); border: 0; }
        .project-pattern span:nth-child(5) { grid-column: span 3; }
        .meta { display: flex; flex-wrap: wrap; gap: 8px; color: #66818a; font-size: 14px; font-weight: 800; }
        .form-card { border: 1px solid var(--slate-200); border-radius: 8px; background: var(--white); padding: 22px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .field { display: grid; gap: 8px; font-size: 14px; font-weight: 800; }
        .field input, .field select, .field textarea { width: 100%; border: 1px solid var(--slate-200); border-radius: 8px; background: var(--white); padding: 0 12px; }
        .field input, .field select { height: 46px; }
        .field textarea { min-height: 132px; padding-block: 12px; resize: vertical; }
        .span-2 { grid-column: 1 / -1; }
        .site-footer { background: var(--deep-slate); color: var(--white); }
        .footer-inner { min-height: 92px; display: flex; align-items: center; justify-content: space-between; gap: 20px; }
        .footer-copy { margin: 0; color: rgb(255 255 255 / .75); font-size: 14px; }
        .footer-links { display: flex; flex-wrap: wrap; gap: 12px; color: rgb(255 255 255 / .72); font-size: 14px; font-weight: 700; }
        .footer-links a:hover { color: var(--white); }
        @media (max-width: 1080px) { .nav-menu { display: none; } }
        @media (max-width: 980px) { .two-col, .three-grid, .four-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 680px) { .container { width: min(100% - 24px, var(--container-max)); } .section { padding-block: 48px; } .header-inner { min-height: auto; padding-block: 12px; align-items: flex-start; flex-direction: column; } .brand-logo { height: 42px; min-width: 108px; } .header-actions { width: 100%; justify-content: space-between; } .two-col, .three-grid, .four-grid, .form-grid { grid-template-columns: 1fr; } .footer-inner { align-items: stretch; flex-direction: column; padding-block: 22px; } }
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
                <a class="language-link" href="/en">English</a>
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