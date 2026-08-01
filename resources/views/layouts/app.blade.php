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

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800;900&family=IBM+Plex+Sans+Arabic:wght@400;500&display=swap" rel="stylesheet">
<script src="https://unpkg.com/swup@4"></script>


<link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.0.3/src/bold/style.css">

<script>
const swup = new Swup();
</script>
@stack('meta')

<style>
    :root {
        --ink: #22262B;
        --slate: #5B6067;
        --teal: #526970;
        --teal-dark: #3E5057;
        --gold: #C89B3C;
        --gold-soft: #E8D3A0;
        --cream: #FBFAF7;
        --paper: #F4F2ED;
        --line: #E6E3DC;
        --font-display: 'Cairo', sans-serif;
        --font-body: 'IBM Plex Sans Arabic', sans-serif;
    }

    * { box-sizing: border-box; }

    body {
        font-family: var(--font-body);
        color: var(--ink);
        background-color: var(--cream);
        background-image:
            linear-gradient(var(--line) 1px, transparent 1px),
            linear-gradient(90deg, var(--line) 1px, transparent 1px);
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

    .nav-link {
        font-size: 14px;
        font-weight: 600;
        color: var(--slate);
        padding: 8px 16px;
        border-radius: 999px;
        transition: all .2s ease;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    .nav-link i { font-size: 15px; }
    .nav-link:hover { background: var(--paper); color: var(--teal-dark); }
    .nav-link.active {
        background: var(--teal);
        color: #fff;
        box-shadow: 0 4px 10px -4px rgba(82,105,112,.6);
    }
    .nav-link.active:hover { background: var(--teal-dark); color: #fff; }

    .lang-switch {
        display: flex;
        gap: 4px;
        background: var(--paper);
        border-radius: 999px;
        padding: 3px;
    }
    .lang-switch a {
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        color: #A5A099;
        letter-spacing: .3px;
        transition: all .2s ease;
    }
    .lang-switch a.active { background: var(--teal); color: #fff; }
    .lang-switch a:not(.active):hover { color: var(--teal-dark); }

    /* ===== قائمة "المزيد" المنسدلة (الخصوصية / الشروط) ===== */
    .more-dropdown { position: relative; }
    .more-dropdown-panel {
        position: absolute;
        top: calc(100% + 10px);
        inset-inline-end: 0;
        background: #fff;
        border: 1px solid var(--line);
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
        font-size: 13px;
        font-weight: 600;
        color: var(--slate);
        transition: all .15s ease;
        white-space: nowrap;
    }
    .more-dropdown-panel a:hover { background: var(--paper); color: var(--teal-dark); }
    .more-dropdown-panel a i { font-size: 15px; color: var(--gold); }

    .site-footer {
        text-align: center;
        font-size: 12px;
        color: #A5A099;
        padding: 32px 0;
        border-top: 1px solid var(--line);
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
        transition: color .15s ease;
    }
    .footer-legal a:hover { color: var(--teal-dark); }

    @stack('styles')
</style>
</head>
<body class="min-h-screen">

    <nav class="bg-white/90 backdrop-blur border border-[var(--line)] rounded-full shadow-lg shadow-gray-200/50 px-4 md:px-6 py-2.5 md:py-3 mx-4 md:mx-6 mt-4 md:mt-5 flex items-center justify-between sticky top-2 md:top-3 z-50 relative">

        <div class="flex items-center gap-3">
            <img src="https://files.catbox.moe/ekyv64.webp" alt="لوجو الديوان" class="h-8">
            <span class="font-extrabold text-[var(--teal)] text-sm md:text-base hidden sm:block" style="font-family:var(--font-display)">
                الديوان للاستشارات الهندسية
            </span>
        </div>

        <div class="hidden md:flex items-center gap-1">
            <a href="{{ route('home_pages.projects.index') }}"
               class="nav-link {{ request()->routeIs('home_pages.projects.*') ? 'active' : '' }}">
                <i class="ri-briefcase-4-line"></i> {{ app()->getLocale() === 'ar' ? 'المشاريع' : 'Projects' }}
            </a>
            <a href="{{ route('home_pages.articles.index') }}"
               class="nav-link {{ request()->routeIs('home_pages.articles.*') ? 'active' : '' }}">
                <i class="ri-newspaper-line"></i> {{ app()->getLocale() === 'ar' ? 'المقالات' : 'Articles' }}
            </a>
            <a href="{{ route('home_pages.images.index') }}"
               class="nav-link {{ request()->routeIs('home_pages.images.*') ? 'active' : '' }}">
                <i class="ri-image-line"></i> {{ app()->getLocale() === 'ar' ? 'الصور' : 'Gallery' }}
            </a>
            <a href="{{ route('home_pages.videos.index') }}"
               class="nav-link {{ request()->routeIs('home_pages.videos.*') ? 'active' : '' }}">
                <i class="ri-vidicon-line"></i> {{ app()->getLocale() === 'ar' ? 'الفيديوهات' : 'Videos' }}
            </a>

            {{-- قائمة منسدلة: سياسة الخصوصية + الشروط والأحكام --}}
            <div class="more-dropdown">
                <span class="nav-link cursor-pointer {{ (request()->routeIs('privacy-policy') || request()->routeIs('terms-conditions')) ? 'active' : '' }}">
                    <i class="ri-shield-check-line"></i> {{ app()->getLocale() === 'ar' ? 'قانوني' : 'Legal' }}
                    <i class="ri-arrow-down-s-line text-xs"></i>
                </span>
                <div class="more-dropdown-panel">
                    <a href="{{ route('privacy-policy') }}">
                        <i class="ri-lock-2-line"></i> {{ app()->getLocale() === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}
                    </a>
                    <a href="{{ route('terms-conditions') }}">
                        <i class="ri-file-text-line"></i> {{ app()->getLocale() === 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }}
                    </a>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="lang-switch">
                <a href="{{ route('set-locale', 'ar') }}"
                   class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}">AR</a>
                <a style="opacity:.4;pointer-events:none;cursor:default;">EN</a>
            </div>

            <button id="mobile-menu-btn" class="md:hidden text-2xl text-[var(--teal)]">
                <i class="ri-menu-line"></i>
            </button>
        </div>
    </nav>

    <div id="mobile-menu" class="hidden md:hidden mx-4 mt-2 bg-white border border-[var(--line)] rounded-2xl shadow-lg p-3 flex flex-col gap-1 relative z-40">
        <a href="{{ route('home_pages.projects.index') }}" class="nav-link {{ request()->routeIs('home_pages.projects.*') ? 'active' : '' }}">
            <i class="ri-briefcase-4-line"></i> {{ app()->getLocale() === 'ar' ? 'المشاريع' : 'Projects' }}
        </a>
        <a href="{{ route('home_pages.articles.index') }}" class="nav-link {{ request()->routeIs('home_pages.articles.*') ? 'active' : '' }}">
            <i class="ri-newspaper-line"></i> {{ app()->getLocale() === 'ar' ? 'المقالات' : 'Articles' }}
        </a>
        <a href="{{ route('home_pages.images.index') }}" class="nav-link {{ request()->routeIs('home_pages.images.*') ? 'active' : '' }}">
            <i class="ri-image-line"></i> {{ app()->getLocale() === 'ar' ? 'الصور' : 'Gallery' }}
        </a>
        <a href="{{ route('home_pages.videos.index') }}" class="nav-link {{ request()->routeIs('home_pages.videos.*') ? 'active' : '' }}">
            <i class="ri-vidicon-line"></i> {{ app()->getLocale() === 'ar' ? 'الفيديوهات' : 'Videos' }}
        </a>

        <div class="border-t border-[var(--line)] my-1"></div>

        <a href="{{ route('privacy-policy') }}" class="nav-link {{ request()->routeIs('privacy-policy') ? 'active' : '' }}">
            <i class="ri-lock-2-line"></i> {{ app()->getLocale() === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}
        </a>
        <a href="{{ route('terms-conditions') }}" class="nav-link {{ request()->routeIs('terms-conditions') ? 'active' : '' }}">
            <i class="ri-file-text-line"></i> {{ app()->getLocale() === 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }}
        </a>
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
        });
    </script>
</body>
</html>
