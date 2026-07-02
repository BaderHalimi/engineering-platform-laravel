<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="{ tab: 'login', showPass: false, showPass2: false, cardIn: false }" x-init="setTimeout(() => cardIn = true, 120)">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@500;600;700&family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: '#f5ad2a',
                        orangeDeep: '#c9860f',
                        orangeLight: '#ffd68a',
                        teal: '#526970',
                        tealDeep: '#33454b',
                        tealLight: '#8aa1a7',
                        mist: '#eef2f3',
                        ivory: '#f8f4ec',
                        slate: '#3d5057',
                        slateDeep: '#26343a',
                        slateLight: '#5c7d85',
                    },
                    fontFamily: {
                        display: ['"El Messiri"', 'sans-serif'],
                        body: ['Tajawal', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        * { font-family: 'Tajawal', sans-serif; }
        .font-display { font-family: 'El Messiri', sans-serif; }

        body {
            background: linear-gradient(160deg, #eef2f3 0%, #f8f4ec 55%, #eef2f3 100%);
        }

        /* ===== زجاجية متعددة الطبقات ===== */
        .glass-card {
            background: linear-gradient(155deg, rgba(248,244,236,0.85) 0%, rgba(238,242,243,0.65) 100%);
            backdrop-filter: blur(28px) saturate(180%);
            -webkit-backdrop-filter: blur(28px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow:
                0 30px 60px -15px rgba(61, 80, 87, 0.35),
                0 8px 24px -8px rgba(245, 173, 42, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.2) inset,
                0 1px 0 rgba(255,255,255,0.5) inset;
        }

        .glass-badge {
            background: linear-gradient(135deg, rgba(255,255,255,0.55), rgba(255,255,255,0.15));
            backdrop-filter: blur(14px) saturate(160%);
            -webkit-backdrop-filter: blur(14px) saturate(160%);
            border: 1px solid rgba(255,255,255,0.45);
            box-shadow: 0 12px 28px -10px rgba(61,80,87,0.45), 0 0 0 1px rgba(255,255,255,0.15) inset;
        }

        .glass-panel-dark {
            background: linear-gradient(155deg, rgba(61,80,87,0.55) 0%, rgba(38,52,58,0.35) 100%);
            backdrop-filter: blur(18px) saturate(160%);
            -webkit-backdrop-filter: blur(18px) saturate(160%);
            border: 1px solid rgba(248,244,236,0.12);
        }

        .field-input {
            background: linear-gradient(155deg, rgba(255,255,255,0.65), rgba(255,255,255,0.35));
            border: 1.5px solid rgba(82, 105, 112, 0.18);
            transition: all 0.35s cubic-bezier(.2,.8,.2,1);
        }
        .field-input:focus {
            background: rgba(255, 255, 255, 0.92);
            border-color: #f5ad2a;
            box-shadow: 0 0 0 4px rgba(245, 173, 42, 0.18), 0 10px 26px -6px rgba(245, 173, 42, 0.4);
            outline: none;
        }

        .glow-orange {
            box-shadow: 0 12px 32px -8px rgba(245, 173, 42, 0.6), 0 0 0 1px rgba(245, 173, 42, 0.35) inset;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ffd68a 0%, #f5ad2a 45%, #c9860f 100%);
            background-size: 200% 200%;
            transition: all 0.35s cubic-bezier(.2,.8,.2,1);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            background-position: 100% 50%;
            box-shadow: 0 20px 38px -10px rgba(245, 173, 42, 0.65);
        }
        .btn-primary:active { transform: translateY(-1px) scale(0.99); }

        .tab-pill { transition: all 0.45s cubic-bezier(.22,1,.36,1); }

        /* ===== أشكال متدرجة (Shaded orbs) ===== */
        .hero-orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(70px);
        }
        .orb-orange { background: radial-gradient(circle at 35% 30%, #ffd68a 0%, #f5ad2a 45%, #c9860f 100%); opacity: 0.55; }
        .orb-teal { background: radial-gradient(circle at 60% 40%, #8aa1a7 0%, #526970 55%, #33454b 100%); opacity: 0.5; }
        .orb-slate { background: radial-gradient(circle at 50% 50%, #5c7d85 0%, #3d5057 60%, #26343a 100%); opacity: 0.6; }

        .noise-overlay {
            background-image: radial-gradient(rgba(255,255,255,0.07) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .mesh-grid {
            background-image:
                linear-gradient(rgba(248,244,236,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(248,244,236,0.06) 1px, transparent 1px);
            background-size: 44px 44px;
        }

        /* ===== حركات السباحة/التمايل (Swim wiggle) ===== */
        .swim-1 { animation: swim1 8s ease-in-out infinite; }
        .swim-2 { animation: swim2 10s ease-in-out infinite; }
        .swim-3 { animation: swim3 12s ease-in-out infinite; }
        .swim-slow { animation: swim1 14s ease-in-out infinite; }

        @keyframes swim1 {
            0%, 100% { transform: translate(0,0) rotate(0deg) scale(1); }
            25% { transform: translate(18px,-14px) rotate(6deg) scale(1.03); }
            50% { transform: translate(6px,-28px) rotate(-3deg) scale(0.98); }
            75% { transform: translate(-16px,-10px) rotate(4deg) scale(1.02); }
        }
        @keyframes swim2 {
            0%, 100% { transform: translate(0,0) rotate(0deg); }
            30% { transform: translate(-22px,16px) rotate(-8deg); }
            60% { transform: translate(-8px,30px) rotate(5deg); }
            85% { transform: translate(14px,10px) rotate(-4deg); }
        }
        @keyframes swim3 {
            0%, 100% { transform: translate(0,0) rotate(0deg); }
            40% { transform: translate(12px,12px) rotate(10deg); }
            70% { transform: translate(-10px,-8px) rotate(-6deg); }
        }

        .wiggle-icon { animation: wiggleIcon 4.5s ease-in-out infinite; transform-origin: 50% 85%; }
        @keyframes wiggleIcon {
            0%, 100% { transform: rotate(0deg); }
            15% { transform: rotate(-9deg); }
            30% { transform: rotate(7deg); }
            45% { transform: rotate(-5deg); }
            60% { transform: rotate(3deg); }
            75% { transform: rotate(-2deg); }
        }

        .fade-up { animation: fadeUp 0.9s cubic-bezier(.22,1,.36,1) both; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .shimmer-text {
            background: linear-gradient(90deg, #f8f4ec 0%, #ffd68a 50%, #f8f4ec 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 5s linear infinite;
        }
        @keyframes shimmer {
            0% { background-position: 200% center; }
            100% { background-position: -200% center; }
        }

        ::selection { background: rgba(245, 173, 42, 0.35); }
        input::placeholder { color: rgba(82, 105, 112, 0.45); }

        .brand-underline {
            background: linear-gradient(90deg, transparent, #f5ad2a, #ffd68a, transparent);
            height: 2px;
        }

        .divider-shade {
            background: linear-gradient(90deg, transparent, rgba(82,105,112,0.25), transparent);
            height: 1px;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center overflow-x-hidden">

    <div class="relative w-full min-h-screen lg:min-h-0 lg:h-screen flex flex-col lg:flex-row-reverse items-stretch">

        <!-- ============ لوحة العرض الجانبية (Desktop) ============ -->
        <div class="hidden lg:flex relative w-1/2 flex-col justify-between overflow-hidden p-14"
             style="background: linear-gradient(160deg, #3d5057 0%, #26343a 50%, #33454b 100%);">

            <div class="hero-orb orb-orange swim-1" style="width:440px;height:440px;top:-140px;right:-160px;"></div>
            <div class="hero-orb orb-teal swim-2" style="width:380px;height:380px;bottom:-120px;left:-140px;"></div>
            <div class="hero-orb orb-slate swim-3" style="width:260px;height:260px;top:38%;left:8%;opacity:0.35;"></div>
            <div class="absolute inset-0 mesh-grid opacity-40"></div>
            <div class="absolute inset-0 noise-overlay opacity-25"></div>

            <!-- شارات زجاجية عائمة (سباحة) -->
            <div class="absolute top-24 left-16 glass-badge rounded-2xl p-3 swim-slow z-10" x-show="cardIn" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#f8f4ec" stroke-width="1.6" class="wiggle-icon">
                    <path d="M12 2l2.4 6.6L21 11l-6.6 2.4L12 20l-2.4-6.6L3 11l6.6-2.4L12 2z"/>
                </svg>
            </div>
            <div class="absolute bottom-40 left-24 glass-badge rounded-2xl p-3 swim-2 z-10" x-show="cardIn" x-transition:enter="transition ease-out duration-700 delay-150" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffd68a" stroke-width="1.8" class="wiggle-icon" style="animation-delay:1s;">
                    <rect x="4" y="10" width="16" height="10" rx="2"/>
                    <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                </svg>
            </div>
            <div class="absolute top-1/2 right-10 glass-badge rounded-2xl p-3 swim-3 z-10" x-show="cardIn" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f8f4ec" stroke-width="1.6" class="wiggle-icon" style="animation-delay:2s;">
                    <path d="M12 2L20 7V17L12 22L4 17V7L12 2Z"/>
                    <path d="M12 22V12M12 12L20 7M12 12L4 7"/>
                </svg>
            </div>

            <div class="relative z-10 fade-up">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center glow-orange swim-slow" style="background:linear-gradient(135deg,#ffd68a,#f5ad2a,#c9860f);">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2L20 7V17L12 22L4 17V7L12 2Z" stroke="#3d5057" stroke-width="1.8" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="3" fill="#3d5057"/>
                        </svg>
                    </div>
                    <span class="font-display text-2xl font-semibold shimmer-text">أوراق</span>
                </div>
                <div class="brand-underline w-16 rounded-full mt-3"></div>
            </div>

            <div class="relative z-10 max-w-md fade-up" style="animation-delay:0.15s;">
                <h1 class="font-display text-5xl leading-[1.25] font-semibold mb-6" style="color:#f8f4ec;">
                    تجربة رقمية <br>
                    <span style="background:linear-gradient(90deg,#ffd68a,#f5ad2a); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;">استثنائية</span> بانتظارك
                </h1>
                <p class="text-base leading-8" style="color:#c9d3d5;">
                    منصّة متكاملة صُممت بعناية فائقة لتمنحك تجربة سلسة وآمنة، حيث تلتقي الأناقة بالكفاءة في كل تفصيلة.
                </p>

                <div class="glass-panel-dark rounded-2xl p-4 mt-8 flex items-center gap-4">
                    <div class="flex -space-x-3 rtl:space-x-reverse">
                        <div class="w-9 h-9 rounded-full border-2" style="background:linear-gradient(135deg,#ffd68a,#c9860f); border-color:#3d5057;"></div>
                        <div class="w-9 h-9 rounded-full border-2" style="background:linear-gradient(135deg,#f8f4ec,#c9d3d5); border-color:#3d5057;"></div>
                        <div class="w-9 h-9 rounded-full border-2" style="background:linear-gradient(135deg,#8aa1a7,#33454b); border-color:#3d5057;"></div>
                    </div>
                    <p class="text-sm" style="color:#c9d3d5;">موثوق من قبل آلاف المستخدمين يومياً</p>
                </div>
            </div>

            <div class="relative z-10 flex items-center justify-between fade-up" style="animation-delay:0.3s;">
                <p class="text-xs" style="color:#8ea3a8;">جميع الحقوق محفوظة © 2026</p>
                <div class="flex gap-2">
                    <span class="w-2 h-2 rounded-full" style="background:#f5ad2a;"></span>
                    <span class="w-2 h-2 rounded-full opacity-40" style="background:#f8f4ec;"></span>
                    <span class="w-2 h-2 rounded-full opacity-40" style="background:#f8f4ec;"></span>
                </div>
            </div>
        </div>

        <!-- ============ لوحة النموذج ============ -->
        <div class="relative w-full lg:w-1/2 flex items-center justify-center px-5 py-10 sm:p-10 overflow-hidden"
             style="background: radial-gradient(circle at 30% 20%, #f8f4ec 0%, #eef2f3 60%, #eef2f3 100%);">

            <div class="hero-orb orb-orange swim-1" style="width:240px;height:240px;top:-60px;right:-60px;opacity:0.22;"></div>
            <div class="hero-orb orb-teal swim-2" style="width:220px;height:220px;bottom:-40px;left:-60px;opacity:0.18;"></div>
            <div class="hero-orb orb-slate swim-3 hidden sm:block" style="width:140px;height:140px;top:20%;left:6%;opacity:0.12;"></div>

            <div class="w-full max-w-md relative z-10">

                <div class="lg:hidden flex flex-col items-center mb-8 fade-up">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center glow-orange swim-slow mb-3" style="background:linear-gradient(135deg,#ffd68a,#f5ad2a,#c9860f);">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2L20 7V17L12 22L4 17V7L12 2Z" stroke="#3d5057" stroke-width="1.8" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="3" fill="#3d5057"/>
                        </svg>
                    </div>
                    <h2 class="font-display text-2xl font-semibold" style="color:#3d5057;">أوراق</h2>
                </div>

                <div class="glass-card rounded-[2rem] p-6 sm:p-9"
                     x-show="cardIn"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100">

                    <div class="text-center mb-7 hidden lg:block">
                        <h2 class="font-display text-3xl font-semibold mb-2" style="color:#3d5057;" x-text="tab === 'login' ? 'مرحباً بعودتك' : 'إنشاء حساب جديد'"></h2>
                        <p class="text-sm" style="color:#526970;" x-text="tab === 'login' ? 'سعداء برؤيتك مجدداً، سجّل الدخول للمتابعة' : 'انضم إلينا وابدأ رحلتك معنا اليوم'"></p>
                    </div>

                    <!-- التبويبات -->
                    <div class="flex p-1.5 rounded-2xl mb-8 relative overflow-hidden" style="background:linear-gradient(155deg,#eef2f3,#e4e9ea);">
                        <button @click="tab = 'login'"
                            :class="tab === 'login' ? 'text-white glow-orange scale-[1.02]' : ''"
                            :style="tab === 'login' ? 'background:linear-gradient(135deg,#ffd68a,#f5ad2a,#c9860f);' : 'color:#526970;'"
                            class="tab-pill flex-1 px-4 py-2.5 rounded-xl font-medium text-sm relative z-10">
                            تسجيل دخول
                        </button>
                        <button @click="tab = 'register'"
                            :class="tab === 'register' ? 'text-white glow-orange scale-[1.02]' : ''"
                            :style="tab === 'register' ? 'background:linear-gradient(135deg,#ffd68a,#f5ad2a,#c9860f);' : 'color:#526970;'"
                            class="tab-pill flex-1 px-4 py-2.5 rounded-xl font-medium text-sm relative z-10">
                            تسجيل جديد
                        </button>
                    </div>

                    <!-- ==== نموذج تسجيل الدخول ==== -->
                    <template x-if="tab === 'login'">
                        <form x-show="tab === 'login'"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 translate-y-3"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-3"
                            action="{{ route('login') }}" method="POST" class="space-y-5">
                            @csrf

                            <div>
                                <label class="block text-sm font-medium mb-2" style="color:#3d5057;">البريد الإلكتروني</label>
                                <div class="relative">
                                    <svg class="absolute right-4 top-1/2 -translate-y-1/2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#526970" stroke-width="1.8">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path d="M3 7l9 6 9-6"/>
                                    </svg>
                                    <input type="email" name="email" placeholder="example@domain.com"
                                        class="field-input w-full rounded-2xl px-4 py-3.5 pr-12 text-sm" style="color:#3d5057;" required>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block text-sm font-medium" style="color:#3d5057;">كلمة المرور</label>
                                    <a href="{{ route('password.request') }}" class="text-xs font-medium transition-colors hover:opacity-70" style="color:#f5ad2a;">
                                        نسيت كلمة المرور؟
                                    </a>
                                </div>
                                <div class="relative">
                                    <svg class="absolute right-4 top-1/2 -translate-y-1/2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#526970" stroke-width="1.8">
                                        <rect x="4" y="10" width="16" height="10" rx="2"/>
                                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                    </svg>
                                    <input :type="showPass ? 'text' : 'password'" name="password" placeholder="••••••••"
                                        class="field-input w-full rounded-2xl px-4 py-3.5 pr-12 pl-12 text-sm" style="color:#3d5057;" required>
                                    <button type="button" @click="showPass = !showPass" class="absolute left-4 top-1/2 -translate-y-1/2" style="color:#526970;">
                                        <svg x-show="!showPass"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-50"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        <svg x-show="showPass" x-cloak
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-50"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.6 21.6 0 0 1 5.06-5.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 7 11 7a21.6 21.6 0 0 1-2.61 3.68M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                                            <path d="M1 1l22 22"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded" style="accent-color:#f5ad2a;">
                                <span class="text-sm" style="color:#526970;">تذكرني في هذا الجهاز</span>
                            </label>

                            <button type="submit" class="btn-primary w-full text-white py-3.5 rounded-2xl font-semibold text-sm mt-2">
                                تسجيل الدخول
                            </button>

                            <div class="flex items-center gap-3 pt-1">
                                <div class="divider-shade flex-1"></div>
                                <span class="text-xs" style="color:#8a9a9e;">أو</span>
                                <div class="divider-shade flex-1"></div>
                            </div>

                            <p class="text-center text-sm" style="color:#526970;">
                                ليس لديك حساب؟
                                <button type="button" @click="tab = 'register'" class="font-semibold" style="color:#f5ad2a;">أنشئ حساباً</button>
                            </p>
                        </form>
                    </template>

                    <!-- ==== نموذج إنشاء حساب ==== -->
                    <template x-if="tab === 'register'">
                        <form x-show="tab === 'register'"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 translate-y-3"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-3"
                            action="{{ route('register') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-medium mb-2" style="color:#3d5057;">الاسم الكامل</label>
                                <div class="relative">
                                    <svg class="absolute right-4 top-1/2 -translate-y-1/2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#526970" stroke-width="1.8">
                                        <circle cx="12" cy="8" r="4"/>
                                        <path d="M4 20c0-4 3.5-6 8-6s8 2 8 6"/>
                                    </svg>
                                    <input type="text" name="name" placeholder="الاسم الكامل"
                                        class="field-input w-full rounded-2xl px-4 py-3.5 pr-12 text-sm" style="color:#3d5057;" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2" style="color:#3d5057;">البريد الإلكتروني</label>
                                <div class="relative">
                                    <svg class="absolute right-4 top-1/2 -translate-y-1/2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#526970" stroke-width="1.8">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path d="M3 7l9 6 9-6"/>
                                    </svg>
                                    <input type="email" name="email" placeholder="example@domain.com"
                                        class="field-input w-full rounded-2xl px-4 py-3.5 pr-12 text-sm" style="color:#3d5057;" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2" style="color:#3d5057;">كلمة المرور</label>
                                <div class="relative">
                                    <svg class="absolute right-4 top-1/2 -translate-y-1/2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#526970" stroke-width="1.8">
                                        <rect x="4" y="10" width="16" height="10" rx="2"/>
                                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                    </svg>
                                    <input :type="showPass ? 'text' : 'password'" name="password" placeholder="••••••••"
                                        class="field-input w-full rounded-2xl px-4 py-3.5 pr-12 pl-12 text-sm" style="color:#3d5057;" required>
                                    <button type="button" @click="showPass = !showPass" class="absolute left-4 top-1/2 -translate-y-1/2" style="color:#526970;">
                                        <svg x-show="!showPass"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-50"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        <svg x-show="showPass" x-cloak
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-50"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.6 21.6 0 0 1 5.06-5.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 7 11 7a21.6 21.6 0 0 1-2.61 3.68M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                                            <path d="M1 1l22 22"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2" style="color:#3d5057;">تأكيد كلمة المرور</label>
                                <div class="relative">
                                    <svg class="absolute right-4 top-1/2 -translate-y-1/2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#526970" stroke-width="1.8">
                                        <rect x="4" y="10" width="16" height="10" rx="2"/>
                                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                    </svg>
                                    <input :type="showPass2 ? 'text' : 'password'" name="password_confirmation" placeholder="••••••••"
                                        class="field-input w-full rounded-2xl px-4 py-3.5 pr-12 pl-12 text-sm" style="color:#3d5057;" required>
                                    <button type="button" @click="showPass2 = !showPass2" class="absolute left-4 top-1/2 -translate-y-1/2" style="color:#526970;">
                                        <svg x-show="!showPass2"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-50"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        <svg x-show="showPass2" x-cloak
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-50"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.6 21.6 0 0 1 5.06-5.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 7 11 7a21.6 21.6 0 0 1-2.61 3.68M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                                            <path d="M1 1l22 22"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn-primary w-full text-white py-3.5 rounded-2xl font-semibold text-sm mt-2">
                                إنشاء الحساب
                            </button>

                            <p class="text-center text-sm pt-1" style="color:#526970;">
                                لديك حساب بالفعل؟
                                <button type="button" @click="tab = 'login'" class="font-semibold" style="color:#f5ad2a;">سجّل الدخول</button>
                            </p>
                        </form>
                    </template>

                </div>

                <p class="text-center text-xs mt-6" style="color:#526970;">
                    بالمتابعة، أنت توافق على
                    <a href="#" class="font-medium hover:opacity-70" style="color:#3d5057;">الشروط والأحكام</a>
                    و
                    <a href="#" class="font-medium hover:opacity-70" style="color:#3d5057;">سياسة الخصوصية</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
