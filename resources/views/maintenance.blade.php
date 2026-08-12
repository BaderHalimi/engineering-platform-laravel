<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الموقع تحت الصيانة</title>

    <!-- Tailwind CSS -->

    <!-- Remixicon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    @vite(['resources/css/maintenance.css'])

    <!-- Google Fonts: Tajawal (Arabic) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-orange': '#f5ad2a',
                        'brand-teal':   '#526970',
                        'brand-mist':   '#eef2f3',
                        'brand-ivory':  '#f8f4ec',
                        'brand-slate':  '#3d5057',
                    },
                    fontFamily: {
                        'arabic': ['Tajawal', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #f8f4ec 0%, #eef2f3 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated floating shapes */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.15;
            filter: blur(2px);
            animation: float 8s ease-in-out infinite;
        }

        .floating-shape.shape-1 {
            width: 300px;
            height: 300px;
            background: #f5ad2a;
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }

        .floating-shape.shape-2 {
            width: 200px;
            height: 200px;
            background: #526970;
            bottom: -50px;
            left: -50px;
            animation-delay: 2s;
        }

        .floating-shape.shape-3 {
            width: 150px;
            height: 150px;
            background: #f5ad2a;
            top: 40%;
            left: 10%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0) scale(1); }
            33%      { transform: translateY(-30px) translateX(20px) scale(1.05); }
            66%      { transform: translateY(20px) translateX(-20px) scale(0.95); }
        }

        /* Pulse for the badge */
        .pulse-dot {
            position: relative;
        }
        .pulse-dot::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: #f5ad2a;
            animation: pulse-ring 2s ease-out infinite;
        }
        @keyframes pulse-ring {
            0%   { transform: scale(1);   opacity: 0.7; }
            100% { transform: scale(2.2); opacity: 0;   }
        }

        /* Construction cone wobble */
        .cone-wobble {
            animation: wobble 3s ease-in-out infinite;
            transform-origin: bottom center;
        }
        @keyframes wobble {
            0%, 100% { transform: rotate(-3deg); }
            50%      { transform: rotate(3deg); }
        }

        /* Gear rotation */
        .gear-spin {
            animation: spin 6s linear infinite;
            transform-origin: center;
        }
        .gear-spin-reverse {
            animation: spin 8s linear infinite reverse;
            transform-origin: center;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        /* Tool slide up animation */
        .slide-up {
            animation: slideUp 0.8s ease-out backwards;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Progress bar shimmer */
        .progress-shimmer {
            position: relative;
            overflow: hidden;
        }
        .progress-shimmer::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 50%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 2s infinite;
        }
        @keyframes shimmer {
            0%   { transform: translateX(100%); }
            100% { transform: translateX(-200%); }
        }

        /* Social icon hover */
        .social-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .social-link:hover {
            transform: translateY(-4px) scale(1.1);
        }

        /* Dotted divider animation */
        .moving-dots {
            background-image: radial-gradient(circle, #f5ad2a 1px, transparent 1px);
            background-size: 20px 20px;
            animation: dots-move 20s linear infinite;
        }
        @keyframes dots-move {
            from { background-position: 0 0; }
            to   { background-position: 200px 200px; }
        }
    </style>
</head>

<body class="font-arabic text-brand-slate relative">

    <!-- Decorative floating shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>

    <main class="relative z-10 min-h-screen flex flex-col">

        <!-- =================== HERO =================== -->
        <section class="flex-1 flex items-center justify-center px-6 py-12">
            <div class="max-w-2xl w-full text-center">

                <!-- Badge -->
                <div class="slide-up inline-flex items-center gap-2 bg-white/70 backdrop-blur-sm border border-brand-orange/30 text-brand-teal px-4 py-2 rounded-full text-sm font-medium mb-8" style="animation-delay:0.1s">
                    <span class="pulse-dot inline-block w-2 h-2 rounded-full bg-brand-orange"></span>
                    <span>جاري العمل على تحسين تجربتكم</span>
                </div>

                <!-- Illustration -->
                <div class="slide-up relative w-56 h-56 mx-auto mb-8" style="animation-delay:0.2s">
                    <!-- Soft circle background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-mist to-white rounded-full shadow-inner"></div>

                    <!-- Gear (background) -->
                    <i class="ri-settings-3-fill gear-spin-reverse absolute top-6 right-6 text-7xl text-brand-teal/20"></i>

                    <!-- Cone -->
                    <div class="cone-wobble absolute inset-0 flex items-center justify-center">
                        <i class="ri-hard-hat-fill text-9xl text-brand-orange drop-shadow-lg"></i>
                    </div>

                    <!-- Sparkles -->
                    <i class="ri-sparkling-2-fill absolute top-4 left-4 text-2xl text-brand-orange animate-pulse"></i>
                    <i class="ri-star-fill absolute bottom-6 right-2 text-xl text-brand-teal/40 animate-pulse" style="animation-delay:0.5s"></i>
                    <i class="ri-flashlight-fill absolute top-1/2 left-2 text-lg text-brand-orange/60 animate-pulse" style="animation-delay:1s"></i>
                </div>

                <!-- Title -->
                <h1 class="slide-up text-4xl md:text-5xl font-black text-brand-slate mb-4 leading-tight" style="animation-delay:0.3s">
                    الموقع تحت <span class="text-brand-orange">الصيانة</span>
                </h1>

                <!-- Subtitle -->
                <p class="slide-up text-lg text-brand-teal/80 mb-2" style="animation-delay:0.4s">
                    نعمل حالياً على تطوير وتحسين الموقع لنقدم لكم تجربة أفضل
                </p>

                <!-- Dynamic message (Laravel Blade) -->
                @if(isset($message) && $message)
                    <div class="slide-up inline-block bg-brand-orange/10 border border-brand-orange/30 text-brand-slate px-5 py-2 rounded-lg text-sm font-medium mb-6" style="animation-delay:0.45s">
                        <i class="ri-information-line align-middle ml-1"></i>
                        {{ $message }}
                    </div>
                @endif

                <!-- Progress bar -->
                <div class="slide-up max-w-md mx-auto mb-10" style="animation-delay:0.5s">
                    <div class="flex justify-between text-xs text-brand-teal mb-2 font-medium">
                        <span>نسبة الإنجاز</span>
                        <span class="text-brand-orange font-bold">٧٥٪</span>
                    </div>
                    <div class="h-2 bg-brand-mist rounded-full overflow-hidden">
                        <div class="progress-shimmer h-full bg-gradient-to-l from-brand-orange to-brand-teal rounded-full" style="width: 75%"></div>
                    </div>
                </div>

                <!-- Return message -->
                <div class="slide-up inline-flex items-center gap-2 bg-brand-slate text-white px-6 py-3 rounded-full shadow-lg shadow-brand-slate/20" style="animation-delay:0.6s">
                    <i class="ri-time-line text-brand-orange text-lg"></i>
                    <span class="font-bold">سنعود قريباً</span>
                    <i class="ri-arrow-left-line text-brand-orange text-lg"></i>
                </div>

            </div>
        </section>

        <!-- =================== DIVIDER =================== -->
        <div class="moving-dots h-2 opacity-50"></div>

        <!-- =================== FOOTER =================== -->
        <footer class="bg-brand-slate text-white py-8 px-6">
            <div class="max-w-4xl mx-auto">

                <!-- Social icons -->
                <div class="flex flex-col items-center gap-5">

                    <p class="text-brand-mist/70 text-sm flex items-center gap-2">
                        <i class="ri-share-circle-fill text-brand-orange"></i>
                        تابعنا على منصات التواصل الاجتماعي
                    </p>

                    <div class="flex items-center gap-3 flex-wrap justify-center">

                        <!-- Twitter / X -->
                        <a href="#" class="social-link w-11 h-11 flex items-center justify-center rounded-full bg-white/10 hover:bg-brand-orange text-white text-xl border border-white/10 hover:border-brand-orange">
                            <i class="ri-twitter-x-fill"></i>
                        </a>

                        <!-- Instagram -->
                        <a href="#" class="social-link w-11 h-11 flex items-center justify-center rounded-full bg-white/10 hover:bg-brand-orange text-white text-xl border border-white/10 hover:border-brand-orange">
                            <i class="ri-instagram-line"></i>
                        </a>

                        <!-- Facebook -->
                        <a href="#" class="social-link w-11 h-11 flex items-center justify-center rounded-full bg-white/10 hover:bg-brand-orange text-white text-xl border border-white/10 hover:border-brand-orange">
                            <i class="ri-facebook-fill"></i>
                        </a>

                        <!-- YouTube -->
                        <a href="#" class="social-link w-11 h-11 flex items-center justify-center rounded-full bg-white/10 hover:bg-brand-orange text-white text-xl border border-white/10 hover:border-brand-orange">
                            <i class="ri-youtube-fill"></i>
                        </a>

                        <!-- TikTok -->
                        <a href="#" class="social-link w-11 h-11 flex items-center justify-center rounded-full bg-white/10 hover:bg-brand-orange text-white text-xl border border-white/10 hover:border-brand-orange">
                            <i class="ri-tiktok-fill"></i>
                        </a>

                        <!-- Snapchat -->
                        <a href="#" class="social-link w-11 h-11 flex items-center justify-center rounded-full bg-white/10 hover:bg-brand-orange text-white text-xl border border-white/10 hover:border-brand-orange">
                            <i class="ri-snapchat-fill"></i>
                        </a>

                        <!-- WhatsApp -->
                        <a href="#" class="social-link w-11 h-11 flex items-center justify-center rounded-full bg-white/10 hover:bg-brand-orange text-white text-xl border border-white/10 hover:border-brand-orange">
                            <i class="ri-whatsapp-line"></i>
                        </a>

                        <!-- LinkedIn -->
                        <a href="#" class="social-link w-11 h-11 flex items-center justify-center rounded-full bg-white/10 hover:bg-brand-orange text-white text-xl border border-white/10 hover:border-brand-orange">
                            <i class="ri-linkedin-fill"></i>
                        </a>

                    </div>

                    <!-- Copyright -->
                    <p class="text-brand-mist/50 text-xs mt-2">
                        © <span x-data x-text="new Date().getFullYear()">2026</span> — جميع الحقوق محفوظة
                    </p>

                </div>

            </div>
        </footer>

    </main>

</body>
</html>
