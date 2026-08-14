{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'الديوان للاستشارات الهندسية')</title>


@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">

@include('partials.local-fonts')
<script src="https://unpkg.com/swup@4"></script>


<link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.0.3/src/bold/style.css">

{{-- Alpine.js: التوب بار وhead-styles تاع الصفحة الرئيسية معتمدين عليه --}}
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.14.1/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.1/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

<script>
const swup = new Swup();
</script>
@stack('meta')

{{-- ===========================================================================
     هاذ الـ include هو المصدر الحقيقي لهوية الموقع: فيه تعريف .nav-link,
     .nav-link.active, .btn-blue, .lang-switch, ستايل التوب بار... إلخ.
     بلاه، الناف بار يبقى بلا highlight لأن الكلاسات ماكاينش ليها CSS.
     =========================================================================== --}}
@include('partials.home.head-styles')

{{--
    ===========================================================================
    ملاحظة مهمة: شلت من هنا كل تعريف محلي لـ .nav-link / .lang-switch /
    .more-dropdown / أزرار الألوان لأنها كانت تفرض ثيم خاص بهذا الملف فقط
    (--teal / --gold المحليين) وهذا كان يخلق تعارض مع هوية الموقع الحقيقية
    المعرّفة في resources/css/app.css (.btn-blue, .nav-link, إلخ).
    دابا الناف تحت تستعمل نفس الكلاسات العامة (.btn-blue, .nav-link) بلا أي
    override محلي، باش تبان بالضبط كيما فالصفحة الرئيسية.
    ===========================================================================
--}}
<style>
    * { box-sizing: border-box; }

    body {
        color: var(--ink, #22262B);
        background-color: var(--cream, #FBFAF7);
        background-image:
            linear-gradient(var(--line, #E6E3DC) 1px, transparent 1px),
            linear-gradient(90deg, var(--line, #E6E3DC) 1px, transparent 1px);
        background-size: 48px 48px;
        background-position: center top;
        background-attachment: fixed;
        position: relative;
    }

    body::before {
        content: "";
        position: fixed;
        inset: 0;
        pointer-events: none;
        background: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(82,105,112,.06), transparent 60%);
        z-index: 0;
    }

    /* ===== قائمة "قانوني" المنسدلة (الخصوصية / الشروط) — هيكلة فقط، بلا ألوان محلية ===== */
    .more-dropdown { position: relative; }
    .more-dropdown-panel {
        position: absolute;
        top: calc(100% + 10px);
        inset-inline-end: 0;
        background: #fff;
        border: 1px solid var(--line, #E6E3DC);
        border-radius: 16px;
        box-shadow: 0 12px 30px -8px rgba(34,38,43,.15);
        min-width: 190px;
        padding: 6px;
        opacity: 0;
        transform: translateY(-6px);
        pointer-events: none;
        transition: all .18s ease;
        z-index: 60;
    }
    .more-dropdown:hover .more-dropdown-panel,
    .more-dropdown-panel.force-open {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
    .more-dropdown-panel a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 12px;
        border-radius: 10px;
        white-space: nowrap;
    }

    .site-footer {
        text-align: center;
        font-size: 12px;
        color: #A5A099;
        padding: 32px 0;
        border-top: 1px solid var(--line, #E6E3DC);
        margin-top: 48px;
        position: relative;
        z-index: 1;
    }

    .footer-legal {
        display: flex;
        justify-content: center;
        gap: 14px;
        margin-bottom: 10px;
    }
    .footer-legal a {
        color: #A5A099;
        font-weight: 600;
    }
    .footer-legal a:hover { color: var(--teal-dark, #3E5057); }

    @stack('styles')
</style>
</head>


@php
    use App\Models\Setup;

    // ===== هلبر رابط الصور (نفس هلبر الصفحة الرئيسية) =====
    $asset = fn($p) => $p ? asset('storage/' . ltrim($p, '/')) : null;

    // ===== الإعدادات العامة (نفس المتغيرات لي يحتاجها partials.home.topbar وpartials.home.head-styles) =====
    $siteName     = Setup::get('site_name', config('app.name'));
    $siteEmail    = Setup::get('site_email', '');
    $siteAddress  = Setup::get('site_address', '');
    $sitePhone    = Setup::get('phone_number', '');
    $siteLogo     = Setup::get('site_logo_path');
    $topNotice    = Setup::get('top_notice', '');
    $socialLinks  = json_decode(Setup::get('social_links', '[]'), true) ?: [];
@endphp
<body class="min-h-screen" x-data="{ mobileMenuOpen: false }">

{{-- التوب بار: نفس البارتيال تاع الصفحة الرئيسية بالضبط --}}
@include('partials.home.topbar', [
    'socialLinks' => $socialLinks,
    'sitePhone'   => $sitePhone,
    'siteEmail'   => $siteEmail,
    'siteAddress' => $siteAddress,
    'topNotice'   => $topNotice,
])

{{-- ============================================================
     ناف بار: نفس هوية الصفحة الرئيسية بالضبط (نفس الكلاسات العامة
     .btn-blue / .nav-link من partials.home.head-styles) — غير الروابط
     هنا route-based بدل anchor scroll لأنها صفحات منفصلة.
     ============================================================ --}}
<nav class="bg-white/95 backdrop-blur border border-gray-100 rounded-full shadow-lg shadow-gray-200/50 px-4 md:px-6 py-2.5 md:py-3 mx-4 md:mx-6 mt-4 md:mt-5 flex items-center justify-between sticky top-2 md:top-3 z-50 transition-all duration-300">

    @if($siteLogo)
        <img src="{{ $asset($siteLogo) }}" alt="{{ $siteName }}"
             class="h-8 md:hidden"
             style="filter: drop-shadow(0 1px 2px rgba(0,0,0,0.35));">
        <img src="{{ $asset($siteLogo) }}" alt="{{ $siteName }}"
             class="h-9 hidden md:block"
             style="height:52px;width:auto; filter: drop-shadow(0 1px 2px rgba(0,0,0,0.35));">
    @else
        <img src="https://files.catbox.moe/ekyv64.webp" alt="لوجو الديوان"
             class="h-8 md:hidden"
             style="filter: drop-shadow(0 1px 2px rgba(0,0,0,0.35));">
        <img src="https://files.catbox.moe/ekyv64.webp" alt="لوجو الديوان"
             class="h-9 hidden md:block"
             style="height:52px;width:auto; filter: drop-shadow(0 1px 2px rgba(0,0,0,0.35));">
    @endif

    <ul class="hidden md:flex items-center gap-3 text-gray-600 text-base font-bold">
        <li>
            <a href="{{ route('home') }}"
               class="block px-5 py-2 rounded-full nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="ri-home-4-line"></i> {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}
            </a>
        </li>
        <li>
            <a href="{{ route('home_pages.projects.index') }}"
               class="block px-5 py-2 rounded-full nav-link {{ request()->routeIs('home_pages.projects.*') ? 'active' : '' }}">
                <i class="ri-briefcase-4-line"></i> {{ app()->getLocale() === 'ar' ? 'المشاريع' : 'Projects' }}
            </a>
        </li>
        <li>
            <a href="{{ route('home_pages.articles.index') }}"
               class="block px-5 py-2 rounded-full nav-link {{ request()->routeIs('home_pages.articles.*') ? 'active' : '' }}">
                <i class="ri-newspaper-line"></i> {{ app()->getLocale() === 'ar' ? 'المقالات' : 'Articles' }}
            </a>
        </li>
        <li>
            <a href="{{ route('home_pages.images.index') }}"
               class="block px-5 py-2 rounded-full nav-link {{ request()->routeIs('home_pages.images.*') ? 'active' : '' }}">
                <i class="ri-image-line"></i> {{ app()->getLocale() === 'ar' ? 'الصور' : 'Gallery' }}
            </a>
        </li>
        <li>
            <a href="{{ route('home_pages.videos.index') }}"
               class="block px-5 py-2 rounded-full nav-link {{ request()->routeIs('home_pages.videos.*') ? 'active' : '' }}">
                <i class="ri-vidicon-line"></i> {{ app()->getLocale() === 'ar' ? 'الفيديوهات' : 'Videos' }}
            </a>
        </li>

        {{-- قائمة منسدلة: سياسة الخصوصية + الشروط والأحكام --}}
        <li class="more-dropdown">
            <span class="block px-5 py-2 rounded-full nav-link cursor-pointer {{ (request()->routeIs('privacy-policy') || request()->routeIs('terms-conditions')) ? 'active' : '' }}">
                <i class="ri-shield-check-line"></i> {{ app()->getLocale() === 'ar' ? 'قانوني' : 'Legal' }}
                <i class="ri-arrow-down-s-line text-xs"></i>
            </span>
            <div class="more-dropdown-panel">
                <a href="{{ route('privacy-policy') }}" class="nav-link">
                    <i class="ri-lock-2-line"></i> {{ app()->getLocale() === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}
                </a>
                <a href="{{ route('terms-conditions') }}" class="nav-link">
                    <i class="ri-file-text-line"></i> {{ app()->getLocale() === 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }}
                </a>
            </div>
        </li>
    </ul>

    <a href="{{ route('home') }}#contact" class="hidden md:flex btn-blue text-sm md:text-base font-bold px-4 md:px-6 py-2 md:py-2.5 rounded-full items-center gap-2">
        {{ app()->getLocale() === 'ar' ? 'اطلب خدمة' : 'Request service' }}
        <i class="ri-arrow-left-line rtl:inline ltr:hidden"></i><i class="ri-arrow-right-line ltr:inline rtl:hidden"></i>
    </a>

    <button id="mobile-menu-btn" class="md:hidden w-10 h-10 flex items-center justify-center rounded-full" style="background-color:#f5ad2a;">
        <i id="mobile-menu-icon-open" class="ri-menu-line text-white text-xl"></i>
        <i id="mobile-menu-icon-close" class="ri-close-line text-white text-xl hidden"></i>
    </button>
</nav>

{{-- قائمة الموبايل (drawer) — نفس شكل الصفحة الرئيسية --}}
<div id="mobile-menu" class="hidden md:hidden mx-4 mt-3 bg-white border border-gray-100 rounded-3xl shadow-lg shadow-gray-200/50 p-3">
    <ul class="flex flex-col text-gray-600 text-base font-bold divide-y divide-gray-100">
        <li>
            <a href="{{ route('home') }}" class="block px-4 py-3 rounded-2xl nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="ri-home-4-line"></i> {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}
            </a>
        </li>
        <li>
            <a href="{{ route('home_pages.projects.index') }}" class="block px-4 py-3 rounded-2xl nav-link {{ request()->routeIs('home_pages.projects.*') ? 'active' : '' }}">
                <i class="ri-briefcase-4-line"></i> {{ app()->getLocale() === 'ar' ? 'المشاريع' : 'Projects' }}
            </a>
        </li>
        <li>
            <a href="{{ route('home_pages.articles.index') }}" class="block px-4 py-3 rounded-2xl nav-link {{ request()->routeIs('home_pages.articles.*') ? 'active' : '' }}">
                <i class="ri-newspaper-line"></i> {{ app()->getLocale() === 'ar' ? 'المقالات' : 'Articles' }}
            </a>
        </li>
        <li>
            <a href="{{ route('home_pages.images.index') }}" class="block px-4 py-3 rounded-2xl nav-link {{ request()->routeIs('home_pages.images.*') ? 'active' : '' }}">
                <i class="ri-image-line"></i> {{ app()->getLocale() === 'ar' ? 'الصور' : 'Gallery' }}
            </a>
        </li>
        <li>
            <a href="{{ route('home_pages.videos.index') }}" class="block px-4 py-3 rounded-2xl nav-link {{ request()->routeIs('home_pages.videos.*') ? 'active' : '' }}">
                <i class="ri-vidicon-line"></i> {{ app()->getLocale() === 'ar' ? 'الفيديوهات' : 'Videos' }}
            </a>
        </li>

        <div class="border-t border-gray-100 my-1"></div>

        <li>
            <a href="{{ route('privacy-policy') }}" class="block px-4 py-3 rounded-2xl nav-link {{ request()->routeIs('privacy-policy') ? 'active' : '' }}">
                <i class="ri-lock-2-line"></i> {{ app()->getLocale() === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}
            </a>
        </li>
        <li>
            <a href="{{ route('terms-conditions') }}" class="block px-4 py-3 rounded-2xl nav-link {{ request()->routeIs('terms-conditions') ? 'active' : '' }}">
                <i class="ri-file-text-line"></i> {{ app()->getLocale() === 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }}
            </a>
        </li>
        <li>
            <a href="{{ route('home') }}#contact" class="block px-4 py-3 rounded-2xl nav-link">
                <i class="ri-send-plane-line"></i> {{ app()->getLocale() === 'ar' ? 'اطلب خدمة' : 'Request service' }}
            </a>
        </li>
    </ul>
</div>

    <div class="relative z-10">
        @yield('content')
    </div>

    <footer class="site-footer">
        <div class="footer-legal">
            <a href="{{ route('privacy-policy') }}">{{ app()->getLocale() === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}</a>
            <span>|</span>
            <a href="{{ route('terms-conditions') }}">{{ app()->getLocale() === 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }}</a>
        </div>
        © {{ date('Y') }} الديوان للاستشارات الهندسية
    </footer>

    @stack('scripts')

    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
            document.getElementById('mobile-menu-icon-open')?.classList.toggle('hidden');
            document.getElementById('mobile-menu-icon-close')?.classList.toggle('hidden');
        });
    </script>
</body>
</html>
