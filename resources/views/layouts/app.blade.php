<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'الديوان للاستشارات الهندسية')</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/@phosphor-icons/web"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800;900&family=IBM+Plex+Sans+Arabic:wght@400;500&display=swap" rel="stylesheet">

@stack('meta')
@stack('styles')
</head>
<body class="bg-white min-h-screen">

    <nav class="bg-white/95 backdrop-blur border border-gray-100 rounded-full shadow-lg shadow-gray-200/50 px-4 md:px-6 py-2.5 md:py-3 mx-4 md:mx-6 mt-4 md:mt-5 flex items-center justify-between sticky top-2 md:top-3 z-50">
        <img src="https://files.catbox.moe/ekyv64.webp" alt="لوجو الديوان" class="h-8">
        <span class="font-extrabold text-[#526970] text-sm md:text-base">الديوان للاستشارات الهندسية</span>
    </nav>

    @yield('content')

    <footer class="text-center text-xs text-gray-400 py-8 border-t border-gray-100 mt-10">
        © {{ date('Y') }} الديوان للاستشارات الهندسية
    </footer>

    @stack('scripts')
</body>
</html>
