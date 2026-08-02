{{-- ============================================================
     الصفحة الرئيسية - ديناميكية بالكامل (مُعاد تنظيمها إلى ملفات)
     البيانات من: Setup (JSON collections) + ServicesType/Project/
     Article/AlbumVideo/AlbumImage/Faq/Feedback
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
    <link rel="shortcut icon" href="{{ asset($siteLogo) }}" type="image/x-icon">
  @endif

{{-- Alpine.js لتنظيم التفاعلات (القائمة، الأكورديون، active state، reveal on scroll) --}}
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.14.1/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.14.1/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800;900&family=IBM+Plex+Sans+Arabic:wght@400;500&display=swap" rel="stylesheet">

@include('partials.home.head-styles')
</head>
<body class="bg-white min-h-screen font-body" x-data="{ mobileMenuOpen: false, activeSection: 'home' }">

{{-- ===== Flash message ===== --}}
@if(session('success'))
  <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
       class="fixed top-5 left-1/2 -translate-x-1/2 z-[9999] bg-green-500 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-2 font-bold">
    <i class="ri-checkbox-circle-fill text-xl"></i> {{ session('success') }}
  </div>
@endif

@include('partials.home.topbar', ['socialLinks' => $socialLinks, 'sitePhone' => $sitePhone, 'siteEmail' => $siteEmail, 'siteAddress' => $siteAddress, 'topNotice' => $topNotice])

@include('partials.home.navbar', ['siteLogo' => $siteLogo, 'asset' => $asset])

@include('partials.home.hero', ['heroImage' => $heroImage, 'siteLogo' => $siteLogo, 'asset' => $asset, 'tr' => $tr])

@include('partials.home.about', ['aboutUs' => $aboutUs, 'siteName' => $siteName, 'tr' => $tr])

@include('partials.home.services', ['services' => $services, 'tr' => $tr, 'asset' => $asset])

@include('partials.home.why-us', ['whyAldiwan' => $whyAldiwan, 'tr' => $tr])

@include('partials.home.process', ['workSteps' => $workSteps, 'siteName' => $siteName, 'tr' => $tr])

@include('partials.home.projects', ['projects' => $projects ?? collect(), 'tr' => $tr, 'asset' => $asset])

@include('partials.home.articles', ['articlesByCategory' => $articlesByCategory ?? collect(), 'asset' => $asset])

@include('partials.home.media', ['videos' => $videos, 'images' => $images, 'asset' => $asset, 'videoEmbed' => $videoEmbed])

@include('partials.home.faqs', ['faqs' => $faqs ?? collect()])

@include('partials.home.contact', ['services' => $services, 'tr' => $tr, 'sitePhone' => $sitePhone, 'siteEmail' => $siteEmail, 'siteAddress' => $siteAddress, 'workingHours' => $workingHours])

@include('partials.home.feedback')

@include('partials.home.footer', ['siteLogo' => $siteLogo, 'siteName' => $siteName, 'socialLinks' => $socialLinks, 'services' => $services, 'tr' => $tr, 'siteAddress' => $siteAddress, 'sitePhone' => $sitePhone, 'siteEmail' => $siteEmail, 'workingHours' => $workingHours, 'asset' => $asset])

@include('partials.home.scripts')

</body>
</html>
