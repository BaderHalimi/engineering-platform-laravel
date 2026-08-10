{{-- ============================================================
     الصفحة الرئيسية - ديناميكية بالكامل (مُعاد تنظيمها إلى ملفات)
     البيانات من: Setup (JSON collections) + ServicesType/Project/
     Article/AlbumVideo/AlbumImage/Faq/Feedback
     ------------------------------------------------------------
     تحديثات هذه النسخة:
     1) تحويل الأقسام إلى نظام "شبه SPA" بواسطة Alpine.js:
        - كل قسم أصبح داخل <div x-show="page === '...'">
        - التنقل بين الأقسام لا يعيد تحميل الصفحة (بدون ريلود)
        - الرابط يحتفظ باسم الصفحة عبر query string: ?p=services
        - يدعم زر الرجوع/التقدم في المتصفح (popstate)
     2) تغيير الخط بالكامل إلى DIN Next LT Arabic (3 أوزان):
        - Ultra Light  -> font-weight: 200
        - Heavy2-2     -> font-weight: 800
        - Black-4      -> font-weight: 900
        تم حذف Cairo / Tajawal / IBM Plex Sans Arabic بالكامل.
     3) كل section: تأثير slow fade up + smooth translation عند
        الظهور (x-transition: opacity 0->1 مع translate-y-8->0)
     ============================================================ --}}

@php
    use App\Models\Setup;

    $locale = app()->getLocale(); // ar | en | fr
    $dir    = $locale === 'ar' ? 'rtl' : 'ltr';

    // ===== Helper لاستخراج الترجمة من JSON translatable =====
    // يتبع اللغة الحالية دائماً، مع fallback على العربي ثم أول قيمة متوفرة
    $tr = function ($field) use ($locale) {
        if (is_array($field)) {
            return $field[$locale] ?? $field['ar'] ?? (reset($field) ?: '');
        }
        return $field ?? '';
    };

    // ===== Helper لاستخراج embed URL من YouTube/Vimeo =====
    $videoEmbed = function ($url) {
        if (! $url) return null;
        if (preg_match('/youtube\.com\/watch\?v=([\w\-]+)/', $url, $m))
            return 'https://www.youtube.com/embed/' . $m[1];
        if (preg_match('/youtu\.be\/([\w\-]+)/', $url, $m))
            return 'https://www.youtube.com/embed/' . $m[1];
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $m))
            return 'https://player.vimeo.com/video/' . $m[1];
        return $url;
    };

    // ===== Helper موحّد لبناء رابط storage (يُستعمل مع كل الصور/الفيديوهات) =====
    $asset = fn($p) => $p ? asset('storage/' . ltrim($p, '/')) : null;

    // ===== الإعدادات العامة من Setup =====
    $siteName      = Setup::get('site_name', config('app.name'));
    $siteEmail     = Setup::get('site_email', '');
    $siteAddress   = Setup::get('site_address', '');
    $sitePhone     = Setup::get('phone_number', '');
    $siteLogo      = Setup::get('site_logo_path');
    // صورة الهيرو منفصلة تماماً عن اللوغو (هذا كان سبب عدم ظهور صورة البرج)
    $heroImage     = $asset(Setup::get('hero_image_path')) ?: 'https://files.catbox.moe/3i7imq.webp';
    $workingHours  = Setup::get('working_hours', '');
    $topNotice     = Setup::get('top_notice', '');

    // ===== مجموعات JSON من Setup (translatable) =====
    $aboutUs     = json_decode(Setup::get('about_us', '[]'), true) ?: [];
    $whyAldiwan  = json_decode(Setup::get('why_aldiwan', '[]'), true) ?: [];
    $workSteps   = json_decode(Setup::get('work_steps', '[]'), true) ?: [];
    $socialLinks = json_decode(Setup::get('social_links', '[]'), true) ?: [];
    $marquee     = json_decode(Setup::get('marquee', '[]'), true) ?: [];

    // ===== نظام صفحات SPA بواسطة Alpine =====
    // قائمة الأقسام المسموح بها كـ "صفحات" + الافتراضي = home
    // القيمة القادمة من ?p=xxx يتم فلترتها هنا (على السيرفر) لمنع أي قيمة غريبة قبل ما توصل لـ Alpine
    $allowedPages = [
        'home', 'about', 'services', 'why-us', 'process',
        'projects', 'articles', 'media', 'faqs', 'contact', 'feedback',
    ];
    $initialPage = request()->query('p', 'home');
    if (! in_array($initialPage, $allowedPages, true)) {
        $initialPage = 'home';
    }
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $siteName }}</title>

{{-- Tailwind --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- Remix Icon (بدل Phosphor) - الأيقونات في قاعدة البيانات مخزّنة بصيغة ri-xxx-line/fill --}}
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">

@if($siteLogo)
    <link rel="shortcut icon" href="{{ $asset($siteLogo) }}" type="image/x-icon">
  @endif

{{-- Alpine.js لتنظيم التفاعلات (القائمة، الأكورديون، active state، reveal on scroll) --}}
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.14.1/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.1/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

{{-- ============================================================
     خط DIN Next LT Arabic - 3 أوزان فقط (تم حذف Google Fonts بالكامل:
     Cairo / Tajawal / IBM Plex Sans Arabic)
     ضع ملفات الخط في: public/fonts/
     الصيغ المدعومة أدناه: woff2 (الأساسي) مع fallback إلى ttf
     عدّل المسارات فقط لو أسماء ملفاتك مختلفة عن الأسماء التالية.
     ============================================================ --}}
<style>
    @font-face {
        font-family: 'DIN Next LT Arabic';
        src: url('{{ asset('fonts/DINNextLTArabic-UltraLight.woff2') }}') format('woff2'),
             url('{{ asset('fonts/DINNextLTArabic-UltraLight.ttf') }}') format('truetype');
        font-weight: 200;
        font-style: normal;
        font-display: swap;
    }
    @font-face {
        font-family: 'DIN Next LT Arabic';
        src: url('{{ asset('fonts/DINNextLTArabic-Heavy2-2.woff2') }}') format('woff2'),
             url('{{ asset('fonts/DINNextLTArabic-Heavy2-2.ttf') }}') format('truetype');
        font-weight: 800;
        font-style: normal;
        font-display: swap;
    }
    @font-face {
        font-family: 'DIN Next LT Arabic';
        src: url('{{ asset('fonts/DINNextLTArabic-Black-4.woff2') }}') format('woff2'),
             url('{{ asset('fonts/DINNextLTArabic-Black-4.ttf') }}') format('truetype');
        font-weight: 900;
        font-style: normal;
        font-display: swap;
    }

    /* تطبيق الخط على كل الصفحة بشكل شامل */
    html, body {
        font-family: 'DIN Next LT Arabic', sans-serif;
        font-weight: 200; /* الوزن الافتراضي = Ultra Light */
    }
    h1, h2, h3, h4, h5, h6,
    .font-heading {
        font-family: 'DIN Next LT Arabic', sans-serif;
        font-weight: 900; /* العناوين = Black */
    }
    strong, b,
    .font-bold, .font-extrabold, .font-black {
        font-family: 'DIN Next LT Arabic', sans-serif;
        font-weight: 800; /* التركيز/الغامق = Heavy */
    }

    /* ===== انتقال ناعم بين الصفحات (SPA) ===== */
    [x-cloak] { display: none !important; }
</style>

@include('partials.home.head-styles')
</head>
<body
    class="bg-white min-h-screen"
    x-data="{
        mobileMenuOpen: false,
        page: '{{ $initialPage }}',
        allowedPages: {{ Js::from($allowedPages) }},

        goTo(pageName) {
            if (! this.allowedPages.includes(pageName)) pageName = 'home';
            this.page = pageName;
            this.mobileMenuOpen = false;

            // تحديث الرابط بدون ريلود مع الاحتفاظ باسمه: ?p=xxx
            const url = new URL(window.location.href);
            if (pageName === 'home') {
                url.searchParams.delete('p');
            } else {
                url.searchParams.set('p', pageName);
            }
            window.history.pushState({ page: pageName }, '', url);

            // إعادة المستخدم لأعلى الصفحة عند تغيير القسم
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }"
    x-init="
        // مزامنة الحالة عند استخدام زر الرجوع/التقدم في المتصفح
        window.addEventListener('popstate', (e) => {
            const p = new URL(window.location.href).searchParams.get('p') || 'home';
            page = allowedPages.includes(p) ? p : 'home';
        });
    "
>

{{-- ===== Flash message ===== --}}
@if(session('success'))
  <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
       class="fixed top-5 left-1/2 -translate-x-1/2 z-[9999] bg-green-500 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-2 font-bold">
    <i class="ri-checkbox-circle-fill text-xl"></i> {{ session('success') }}
  </div>
@endif

@include('partials.home.topbar', ['socialLinks' => $socialLinks, 'sitePhone' => $sitePhone, 'siteEmail' => $siteEmail, 'siteAddress' => $siteAddress, 'topNotice' => $topNotice])

{{-- ============================================================
     الـ Navbar: مرّرنا له دالة goTo() وحالة page الحالية
     داخل navbar.blade.php، بدّل أي <a href="#services"> بزر مثل:
     <button @click="goTo('services')" :class="page === 'services' ? 'active-class' : ''">
     ============================================================ --}}
@include('partials.home.navbar', ['siteLogo' => $siteLogo, 'asset' => $asset])

{{-- ============================================================
     كل قسم أصبح "صفحة" مستقلة تُعرض/تُخفى حسب page
     x-show بدل x-if عمداً: يحافظ على العنصر في DOM (أفضل للـ SEO
     ولتفادي إعادة بناء الأكورديونات/الفيديوهات كل مرة)

     x-transition: slow fade up + smooth translation
     - enter: opacity 0->1 مع انزلاق من translate-y-8 إلى 0 خلال 700ms
     - leave: fade سريع نسبياً (200ms) بدون انزلاق
     ============================================================ --}}

<div x-show="page === 'home'" x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    @include('partials.home.hero', ['heroImage' => $heroImage, 'siteLogo' => $siteLogo, 'asset' => $asset, 'tr' => $tr])
</div>

<div x-show="page === 'about'" x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    @include('partials.home.about', ['aboutUs' => $aboutUs, 'siteName' => $siteName, 'tr' => $tr])
</div>

<div x-show="page === 'services'" x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    @include('partials.home.services', ['services' => $services, 'tr' => $tr, 'asset' => $asset])
</div>

<div x-show="page === 'why-us'" x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    @include('partials.home.why-us', ['whyAldiwan' => $whyAldiwan, 'tr' => $tr])
</div>

<div x-show="page === 'process'" x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    @include('partials.home.process', ['workSteps' => $workSteps, 'siteName' => $siteName, 'tr' => $tr])
</div>

<div x-show="page === 'projects'" x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    @include('partials.home.projects', ['projects' => $projects ?? collect(), 'tr' => $tr, 'asset' => $asset])
</div>

<div x-show="page === 'articles'" x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    @include('partials.home.articles', ['articlesByCategory' => $articlesByCategory ?? collect(), 'asset' => $asset])
</div>

<div x-show="page === 'media'" x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    @include('partials.home.media', ['videos' => $videos, 'images' => $images, 'asset' => $asset, 'videoEmbed' => $videoEmbed])
</div>

<div x-show="page === 'faqs'" x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    @include('partials.home.faqs', ['faqs' => $faqs ?? collect()])
</div>

<div x-show="page === 'contact'" x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    @include('partials.home.contact', ['services' => $services, 'tr' => $tr, 'sitePhone' => $sitePhone, 'siteEmail' => $siteEmail, 'siteAddress' => $siteAddress, 'workingHours' => $workingHours])
</div>

<div x-show="page === 'feedback'" x-cloak
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    @include('partials.home.feedback')
</div>

{{-- الفوتر يبقى ثابتاً وظاهراً في كل الصفحات (خارج نظام page) --}}
@include('partials.home.footer', ['siteLogo' => $siteLogo, 'siteName' => $siteName, 'socialLinks' => $socialLinks, 'services' => $services, 'tr' => $tr, 'siteAddress' => $siteAddress, 'sitePhone' => $sitePhone, 'siteEmail' => $siteEmail, 'workingHours' => $workingHours, 'asset' => $asset])

@include('partials.home.scripts')

</body>
</html>
