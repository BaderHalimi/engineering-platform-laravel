
@extends("")


<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>الديوان للاستشارات الهندسية</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/@phosphor-icons/web"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800;900&family=IBM+Plex+Sans+Arabic:wght@400;500&display=swap" rel="stylesheet">

<style>
  :root{
    --teal:#526970;
    --teal-dark:#3d5258;
    --teal-light:#6b858d;
    --gold:#f5ad2a;
    --gold-dark:#d89320;
    --ink:#1E2A30;
    --line:#E7E2D8;
    --bg-soft:#fafbfc;
  }
  *{ font-family:'Cairo','Tajawal',sans-serif; }
  html{ scroll-behavior:smooth; }
  body{ background-color:#fff; color:var(--teal); overflow-x:hidden; }
  .font-body{ font-family:'IBM Plex Sans Arabic',sans-serif; }
  .font-display{font-family:'Tajawal',sans-serif;}

  /* ===== Nav ===== */
  .nav-link{ position:relative; transition:color .35s ease, background-color .35s ease, transform .35s ease; z-index:1; }
  .nav-link:hover{ color:var(--teal); }
  .nav-link.active{ color:#fff !important; background-color:var(--gold) !important; box-shadow:0 6px 16px -6px rgba(245,173,42,.55); }
  .nav-link:not(.active):hover{ background-color:#f3f4f6; }

  /* ===== Buttons ===== */
  .btn-primary{
    background:linear-gradient(135deg, var(--gold), var(--gold-dark));
    color:#fff; box-shadow:0 10px 24px -10px rgba(245,173,42,.6);
    transition:transform .3s ease, box-shadow .3s ease;
  }
  .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 14px 28px -8px rgba(245,173,42,.7); }
  .btn-blue,.btn-secondary{
    background:linear-gradient(135deg, var(--teal-light), var(--teal-dark));
    color:#fff; box-shadow:0 10px 24px -10px rgba(82,105,112,.55);
    transition:transform .3s ease, box-shadow .3s ease;
  }
  .btn-blue:hover,.btn-secondary:hover{ transform:translateY(-2px); box-shadow:0 14px 28px -8px rgba(82,105,112,.65); }

  /* ===== Decorations ===== */
  .blob{ position:absolute; border-radius:50%; filter:blur(80px); opacity:.35; pointer-events:none; }
  .geo-pattern{ background-image:radial-gradient(circle at 1px 1px, rgba(82,105,112,.08) 1px, transparent 0); background-size:22px 22px; }

  /* ===== Animations ===== */
  @keyframes pulse-ring{
    0%{ box-shadow:0 0 0 0 rgba(245,173,42,.4); }
    70%{ box-shadow:0 0 0 18px rgba(245,173,42,0); }
    100%{ box-shadow:0 0 0 0 rgba(245,173,42,0); }
  }
  .pulse-ring{ animation:pulse-ring 2.2s infinite; }

  .corner{ position:absolute; width:18px; height:18px; border-color:var(--gold); }
  .corner-tl{ top:10px; right:10px; border-top:3px solid; border-right:3px solid; }
  .corner-br{ bottom:10px; left:10px; border-bottom:3px solid; border-left:3px solid; }
  .ruler{ background-image:repeating-linear-gradient(to bottom, var(--line) 0 1px, transparent 1px 14px); }

  /* ===== Reveal animations ===== */
  .reveal{
    opacity:0; transform:translateY(30px);
    transition:opacity 1.3s cubic-bezier(.16,.7,.24,1), transform 1.3s cubic-bezier(.16,.7,.24,1);
    will-change:opacity, transform;
  }
  .reveal.is-visible{ opacity:1; transform:translateY(0); }
  .reveal-delay-1.is-visible{ transition-delay:.25s; }
  .reveal-delay-2.is-visible{ transition-delay:.55s; }
  .reveal-delay-3.is-visible{ transition-delay:.85s; }

  .services-reveal,.why-reveal{
    opacity:0; transform:translateY(24px);
    transition:opacity .7s ease, transform .7s cubic-bezier(.2,.8,.2,1);
  }
  .services-reveal.is-visible,.why-reveal.is-visible{ opacity:1; transform:translateY(0); }

  .generic-reveal{ opacity:0; transform:translateY(24px); transition:opacity .7s ease, transform .7s cubic-bezier(.2,.8,.2,1); }
  .generic-reveal.visible{ opacity:1; transform:translateY(0); }

  /* ===== Sections ===== */
  .section-title-underline{ width:70px; height:4px; background:linear-gradient(to left, var(--gold), var(--gold-dark)); border-radius:999px; }

  .card-hover{ transition:transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease, border-color .4s ease; }
  .card-hover:hover{ transform:translateY(-6px); box-shadow:0 22px 40px -22px rgba(82,105,112,.35); border-color:rgba(245,173,42,.5); }

  .icon-wrap{
    width:64px; height:64px; border-radius:20px;
    display:flex; align-items:center; justify-content:center;
    background:linear-gradient(135deg, rgba(245,173,42,.12), rgba(245,173,42,.04));
    color:var(--gold-dark);
    transition:transform .4s ease, background .4s ease, color .4s ease;
  }
  .card-hover:hover .icon-wrap{ transform:scale(1.08) rotate(-4deg); background:linear-gradient(135deg, var(--gold), var(--gold-dark)); color:#fff; }

  .deco-corner{ position:absolute; width:60px; height:60px; border:3px solid var(--gold); opacity:.5; }

  .project-img{ transition:transform .7s cubic-bezier(.2,.8,.2,1); }
  .card-hover:hover .project-img{ transform:scale(1.08); }
  .project-overlay{ opacity:0; transition:opacity .4s ease; }
  .project-card:hover .project-overlay{ opacity:1; }

  .line-clamp-2{ display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

  .field{ width:100%; background:var(--bg-soft); border:1px solid #e5e7eb; border-radius:14px; padding:.85rem 1rem; font-size:.95rem; color:var(--teal-dark); outline:none; transition:border-color .25s ease, box-shadow .25s ease, background .25s ease; }
  .field::placeholder{ color:#9ca3af; }
  .field:focus{ border-color:var(--gold); background:#fff; box-shadow:0 0 0 4px rgba(245,173,42,.15); }
</style>

</head>
<body class="bg-white min-h-screen">
<!-- ====== HEADER ====== -->
<div class="w-full bg-gradient-to-l from-[var(--teal)] to-[var(--teal-dark)] text-white text-sm py-2 px-6 items-center justify-between hidden md:flex">
  <div class="flex items-center gap-5">
    <span class="flex items-center gap-2"><i class="ph-bold ph-phone"></i> 920000123</span>
    <span class="flex items-center gap-2"><i class="ph-bold ph-envelope-simple"></i> info@aldiwan.sa</span>
    <span class="flex items-center gap-2"><i class="ph-bold ph-map-pin"></i> الرياض، المملكة العربية السعودية</span>
  </div>
  <div class="flex items-center gap-3 text-white/80">
    <a href="#" class="hover:text-[var(--gold)] transition"><i class="ph-bold ph-facebook-logo"></i></a>
    <a href="#" class="hover:text-[var(--gold)] transition"><i class="ph-bold ph-instagram-logo"></i></a>
    <a href="#" class="hover:text-[var(--gold)] transition"><i class="ph-bold ph-twitter-logo"></i></a>
    <a href="#" class="hover:text-[var(--gold)] transition"><i class="ph-bold ph-youtube-logo"></i></a>
    <span class="border-r border-white/30 h-4 mx-2"></span>
    <a href="#" class="hover:text-[var(--gold)] transition flex items-center gap-1"><i class="ph-bold ph-user-circle"></i> حسابي</a>
  </div>
</div>


<!-- Nav: desktop (md+) -->
<nav class="bg-white/95 backdrop-blur border border-gray-100 rounded-full shadow-lg shadow-gray-200/50 px-4 md:px-6 py-2.5 md:py-3 mx-4 md:mx-6 mt-4 md:mt-5 flex items-center justify-between sticky top-2 md:top-3 z-50 transition-all duration-300">
  <img src="https://files.catbox.moe/ekyv64.webp" alt="لوجو الديوان" class="h-8 md:hidden">
  <div class="w-10 hidden md:block"></div>
  <ul class="hidden md:flex items-center gap-3 text-gray-600 text-base font-bold">
    <li><a href="#home" class="nav-link active block px-5 py-2 rounded-full">الرئيسية</a></li>
    <li><a href="#services" class="nav-link block px-5 py-2 rounded-full">الخدمات</a></li>
    <li><a href="#projects" class="nav-link block px-5 py-2 rounded-full">المشاريع</a></li>
    <li><a href="#about" class="nav-link block px-5 py-2 rounded-full">من نحن</a></li>
    <li><a href="#articles" class="nav-link block px-5 py-2 rounded-full">المقالات</a></li>
    <li><a href="#contact" class="nav-link block px-5 py-2 rounded-full">تواصل معنا</a></li>
  </ul>
  <button class="btn-blue text-sm md:text-base font-bold px-4 md:px-6 py-2 md:py-2.5 rounded-full flex items-center gap-2">
    اطلب خدمة <i class="ph-bold ph-arrow-left"></i>
  </button>
  <button id="menuBtn" class="md:hidden w-10 h-10 flex items-center justify-center rounded-full" style="background-color:#f5ad2a;">
    <i class="ph-bold ph-list text-white text-xl"></i>
  </button>
</nav>

<!-- Mobile menu (drawer) -->
<div id="mobileMenu" class="hidden md:hidden mx-4 mt-3 bg-white border border-gray-100 rounded-3xl shadow-lg shadow-gray-200/50 p-3">
  <ul class="flex flex-col text-gray-600 text-base font-bold divide-y divide-gray-100">
    <li><a href="#home" class="mobile-link block px-4 py-3 rounded-2xl" style="color:#fff; background-color:#f5ad2a;">الرئيسية</a></li>
    <li><a href="#services" class="mobile-link block px-4 py-3 rounded-2xl">الخدمات</a></li>
    <li><a href="#projects" class="mobile-link block px-4 py-3 rounded-2xl">المشاريع</a></li>
    <li><a href="#about" class="mobile-link block px-4 py-3 rounded-2xl">من نحن</a></li>
    <li><a href="#articles" class="mobile-link block px-4 py-3 rounded-2xl">المقالات</a></li>
    <li><a href="#contact" class="mobile-link block px-4 py-3 rounded-2xl">تواصل معنا</a></li>
  </ul>
</div>

<!-- ====== HERO ====== -->
<section id="home" class="relative w-full overflow-hidden pt-6 md:pt-0" style="min-height:auto; md:min-height:88vh;">
  <div class="blob hidden md:block" style="width:380px;height:380px;background:var(--gold);top:80px;right:-100px;"></div>
  <div class="blob hidden md:block" style="width:300px;height:300px;background:var(--teal-light);bottom:60px;left:-80px;opacity:.15;"></div>
  <div class="absolute inset-0 geo-pattern opacity-50 hidden md:block"></div>
  <div class="absolute top-32 left-12 text-[var(--gold)]/20 text-9xl font-black select-none pointer-events-none leading-none hidden md:block">+</div>
  <div class="absolute bottom-20 right-12 text-[var(--teal)]/10 text-9xl font-black select-none pointer-events-none leading-none hidden md:block">×</div>

  <!-- Image: mobile = rounded card with badge, desktop = absolute positioned -->
  <div class="md:hidden px-5">
    <div class="relative rounded-3xl overflow-hidden shadow-xl mb-5">
      <img src="https://files.catbox.moe/3i7imq.webp" alt="صورة" class="w-full h-64 object-cover">
      <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(30,42,48,0.35), transparent 50%);"></div>
      <div class="absolute bottom-4 right-4 bg-white/95 backdrop-blur rounded-2xl px-4 py-2 flex items-center gap-2 shadow-lg">
        <i class="ph-bold ph-trophy text-[var(--gold)] text-xl"></i>
        <div>
          <div class="font-extrabold text-[var(--teal)] text-xs">+850 مشروع</div>
          <div class="text-[10px] text-gray-500">تم تنفيذه بنجاح</div>
        </div>
      </div>
    </div>
  </div>
  <img src="https://files.catbox.moe/3i7imq.webp" alt="صورة"
       class="hidden md:block absolute left-0 z-10"
       style="width:55%; max-width:800px; min-width:400px; bottom:-90px;">

  <div class="container mx-auto px-5 md:px-6 md:h-full md:flex md:items-center relative z-20">
    <div class="md:max-w-2xl md:mr-0 md:ml-auto text-right md:mt-24">
      <div class="inline-flex items-center gap-2 bg-white border border-[var(--gold)]/30 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 md:py-2 rounded-full text-xs md:text-sm font-bold mb-4 md:mb-6 shadow-sm">
        <span class="w-2 h-2 bg-[var(--gold)] rounded-full pulse-ring"></span>
        <span class="md:inline">مكتب هندسي معتمد — خبرة +12 سنة</span>
        <span class="md:hidden">مكتب معتمد</span>
      </div>

      <img src="https://files.catbox.moe/ekyv64.webp" alt="لوجو الديوان" class="ml-auto mb-4 md:mb-6 hidden md:block" style="height:70px;">

      <h1 class="font-extrabold leading-tight mb-3 md:mb-6 text-4xl md:text-7xl" style="color:var(--teal);">
        من الفكرة<br>
        <span class="relative inline-block">
          إلى رخصة البناء
          <span class="absolute -bottom-1 md:-bottom-2 right-0 h-1.5 md:h-2 bg-[var(--gold)] rounded-full" style="width:65%; md:width:70%;"></span>
        </span>
      </h1>

      <p class="text-gray-600 leading-relaxed mb-5 md:mb-8 text-sm md:text-2xl" style="max-width:580px; margin-right:auto;">
        حلول تصميم ورخص بناء تساعدك على فهم خطوات مشروعك بوضوح، من دراسة الاحتياج حتى جاهزية المخططات واعتمادها رسمياً.
      </p>

      <div class="flex items-center justify-end gap-3 md:gap-4 mb-6 md:mb-10">
        <button class="btn-primary w-full md:w-auto text-sm md:text-lg font-bold rounded-full flex items-center justify-center md:justify-start gap-2" style="padding:.9rem 1.5rem; md:padding:1rem 2.2rem;">
          <span class="md:inline">ابدأ بخطوة هندسية واضحة</span>
          <span class="md:hidden">ابدأ الآن</span>
          <i class="ph-bold ph-arrow-left text-base md:text-xl"></i>
        </button>
        <button class="hidden md:flex bg-white border-2 border-[var(--teal)]/20 text-[var(--teal)] hover:border-[var(--teal)] text-lg font-bold rounded-full items-center gap-2 transition" style="padding:.9rem 2rem;">
          <i class="ph-bold ph-play-circle text-2xl text-[var(--gold)]"></i> شاهد عملنا
        </button>
      </div>

      <div class="grid grid-cols-3 md:flex md:items-center md:justify-end gap-3 md:gap-8 text-center md:text-right">
        <div class="md:block bg-white md:bg-transparent border md:border-0 border-gray-100 rounded-2xl md:rounded-none p-3 md:p-0">
          <div class="text-xl md:text-3xl font-black text-[var(--teal)]">+850</div>
          <div class="text-[10px] md:text-sm text-gray-500 font-bold">مشروع منجز</div>
        </div>
        <div class="hidden md:block w-px h-10 bg-gray-200"></div>
        <div class="md:block bg-white md:bg-transparent border md:border-0 border-gray-100 rounded-2xl md:rounded-none p-3 md:p-0">
          <div class="text-xl md:text-3xl font-black text-[var(--teal)]">+1200</div>
          <div class="text-[10px] md:text-sm text-gray-500 font-bold">رخصة معتمدة</div>
        </div>
        <div class="hidden md:block w-px h-10 bg-gray-200"></div>
        <div class="md:block bg-white md:bg-transparent border md:border-0 border-gray-100 rounded-2xl md:rounded-none p-3 md:p-0">
          <div class="text-xl md:text-3xl font-black text-[var(--teal)]">98%</div>
          <div class="text-[10px] md:text-sm text-gray-500 font-bold">رضا العملاء</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom services bar (desktop only) -->
  <div class="hidden lg:block absolute left-0 right-0 z-30" style="bottom:0;">
    <div class="container mx-auto px-6" style="margin-bottom:-40px;">
      <div class="bg-white rounded-2xl shadow-2xl shadow-gray-300/40 border border-gray-100 px-8 py-6 grid grid-cols-4 gap-4">
        <div class="flex items-center gap-3 justify-end text-right">
          <div>
            <div class="font-bold text-base" style="color:var(--teal);">تصميم معماري</div>
            <div class="text-xs text-gray-400">مخططات تلبي الاحتياج</div>
          </div>
          <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background:rgba(245,173,42,.12);">
            <i class="ph-bold ph-buildings-alt text-xl" style="color:var(--gold-dark);"></i>
          </div>
        </div>
        <div class="flex items-center gap-3 justify-end text-right border-r border-gray-100 pr-4">
          <div>
            <div class="font-bold text-base" style="color:var(--teal);">رخص بناء</div>
            <div class="text-xs text-gray-400">اعتماد رسمي وكامل</div>
          </div>
          <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background:rgba(245,173,42,.12);">
            <i class="ph-bold ph-file-text text-xl" style="color:var(--gold-dark);"></i>
          </div>
        </div>
        <div class="flex items-center gap-3 justify-end text-right border-r border-gray-100 pr-4">
          <div>
            <div class="font-bold text-base" style="color:var(--teal);">إشراف هندسي</div>
            <div class="text-xs text-gray-400">متابعة ميدانية دقيقة</div>
          </div>
          <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background:rgba(245,173,42,.12);">
            <i class="ph-bold ph-pencil-ruler text-xl" style="color:var(--gold-dark);"></i>
          </div>
        </div>
        <div class="flex items-center gap-3 justify-end text-right border-r border-gray-100 pr-4">
          <div>
            <div class="font-bold text-base" style="color:var(--teal);">استشارات</div>
            <div class="text-xs text-gray-400">دراسة جدوى شاملة</div>
          </div>
          <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background:rgba(245,173,42,.12);">
            <i class="ph-bold ph-chats-circle text-xl" style="color:var(--gold-dark);"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ====== ABOUT (desktop+mobile unified) ====== -->
<section id="about" class="relative w-full py-16 md:py-24 mt-8 font-body" style="min-height:auto; md:min-height:85vh;">

  <!-- Mobile-only about (image with overlay + vertical cards) -->
  <div class="md:hidden max-w-md mx-auto px-5">
    <div data-reveal class="reveal flex items-center justify-between mb-6">
      <span class="text-[11px] tracking-[0.3em] font-bold text-[var(--teal)]/70 font-display">AL-DIWAN ENG.</span>
      <span class="text-[11px] tracking-[0.3em] font-bold font-display" style="color:var(--gold);">01</span>
    </div>
    <div data-reveal class="reveal relative rounded-3xl overflow-hidden shadow-xl border border-[var(--line)]">
      <img src="https://files.catbox.moe/81okx1.webp" alt="استشاري هندسي" class="w-full h-80 object-cover">
      <div class="absolute inset-0 bg-gradient-to-t from-[var(--ink)] via-[var(--ink)]/10 to-transparent"></div>
      <div class="corner corner-tl"></div>
      <div class="corner corner-br"></div>
      <div class="absolute bottom-0 right-0 p-5 text-right">
        <h1 class="font-black text-white text-4xl leading-none mb-1 font-display">من نحن</h1>
        <h2 class="font-bold text-white/90 text-lg font-display">الديوان للاستشارات الهندسية</h2>
      </div>
    </div>
    <div data-reveal class="reveal mt-8 pr-4 border-r-4 ruler" style="border-color:var(--gold);">
      <p class="text-[15px] leading-8">
        نقدم حلولاً هندسية احترافية تشمل التصميم، التراخيص، الإشراف، وإدارة المشاريع، وفق أعلى معايير الجودة.
      </p>
    </div>
    <div class="mt-10 space-y-5">
      <div data-reveal class="reveal reveal-delay-1 relative bg-white rounded-2xl shadow-lg border border-[var(--line)] p-5 pr-6 overflow-hidden">
        <span class="absolute top-0 bottom-0 right-0 w-1.5" style="background:var(--gold);"></span>
        <span class="text-xs font-bold tracking-widest font-display" style="color:var(--gold);">VISION — رؤيتنا</span>
        <p class="mt-2 text-[15px] leading-8">أن نكون الخيار الأول في تقديم الخدمات والاستشارات الهندسية، من خلال الابتكار، الدقة، وبناء علاقات طويلة الأمد مع عملائنا.</p>
      </div>
      <div data-reveal class="reveal reveal-delay-2 relative bg-white rounded-2xl shadow-lg border border-[var(--line)] p-5 pr-6 overflow-hidden">
        <span class="absolute top-0 bottom-0 right-0 w-1.5" style="background:var(--gold);"></span>
        <span class="text-xs font-bold tracking-widest font-display" style="color:var(--gold);">VALUES — قيمنا</span>
        <p class="mt-2 text-[15px] leading-8">الاحترافية، الجودة، الشفافية، والالتزام، والعمل بروح الفريق لضمان نجاح كل مشروع.</p>
      </div>
      <div data-reveal class="reveal reveal-delay-3 relative rounded-2xl shadow-lg p-5 pr-6 overflow-hidden" style="background:var(--ink);">
        <span class="absolute top-0 bottom-0 right-0 w-1.5" style="background:var(--gold);"></span>
        <span class="text-xs font-bold tracking-widest font-display" style="color:var(--gold);">SERVICES — خدماتنا</span>
        <h3 class="mt-2 font-bold text-white text-xl font-display">استشارات هندسية متكاملة</h3>
      </div>
    </div>
  </div>

  <!-- Desktop-only about (2-col flex) -->
  <div class="hidden md:flex container mx-auto px-6 flex-row-reverse items-center justify-between gap-10" style="min-height:60vh;">
    <img data-reveal src="https://files.catbox.moe/81okx1.webp" alt="صورة" class="reveal h-auto w-auto max-w-[35%] object-contain rounded-2xl shadow-xl">
    <div class="max-w-[42%] text-right" style="color:var(--teal);">
      <div data-reveal class="reveal mb-10">
        <h1 class="text-6xl font-bold leading-none mb-1">من نحن</h1>
        <h2 class="text-4xl font-bold">الديوان للاستشارات الهندسية</h2>
      </div>
      <div data-reveal class="reveal reveal-delay-1 bg-white rounded-2xl shadow-xl border border-gray-100 p-5 mb-4">
        <h3 class="text-3xl font-bold mb-2" style="color:var(--gold);">استشارات هندسية متكاملة</h3>
        <p class="text-2xl">نقدم حلولاً هندسية احترافية تشمل التصميم، التراخيص، الإشراف، وإدارة المشاريع وفق أعلى معايير الجودة.</p>
      </div>
      <div data-reveal class="reveal reveal-delay-2 bg-white rounded-2xl shadow-xl border border-gray-100 p-5 mb-4">
        <h3 class="text-3xl font-bold mb-2" style="color:var(--gold);">رؤيتنا</h3>
        <p class="text-2xl">أن نكون الخيار الأول في تقديم الخدمات والاستشارات الهندسية من خلال الابتكار، الدقة، وبناء علاقات طويلة الأمد مع عملائنا.</p>
      </div>
      <div data-reveal class="reveal reveal-delay-3 bg-white rounded-2xl shadow-xl border border-gray-100 p-5">
        <h3 class="text-3xl font-bold mb-2" style="color:var(--gold);">قيمنا</h3>
        <p class="text-2xl">الاحترافية، الجودة، الشفافية، والالتزام، والعمل بروح الفريق لضمان نجاح كل مشروع.</p>
      </div>
    </div>
  </div>
</section>

<!-- ====== SERVICES ====== -->
<section id="services" class="relative w-full py-16 md:py-24 mt-0 md:mt-8 bg-white overflow-hidden">
  <div class="blob hidden md:block" style="width:280px;height:280px;background:var(--gold);top:80px;left:-60px;opacity:.1;"></div>
  <div class="container mx-auto px-5 md:px-6">
    <div data-services-reveal class="services-reveal text-center max-w-2xl mx-auto mb-10 md:mb-16">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ph-bold ph-stack"></i> خدماتنا
      </div>
      <h2 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-3 md:mb-4">حلول هندسية متكاملة تحت سقف واحد</h2>
      <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
      <p class="text-gray-500 text-sm md:text-lg">من التصميم الأولي حتى التسليم، فريقنا يرافقك في كل خطوة من رحلة مشروعك.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-7">
      <!-- Card 1 -->
      <div data-services-reveal class="services-reveal card-hover bg-white border border-gray-100 rounded-3xl p-6 md:p-8 relative overflow-hidden">
        <div class="deco-corner" style="top:-1px;left:-1px;border-right:none;border-bottom:none;border-radius:0 0 30px 0;"></div>
        <div class="icon-wrap mb-4 md:mb-5"><i class="ph-bold ph-blueprint text-2xl md:text-3xl"></i></div>
        <h3 class="text-lg md:text-xl font-extrabold text-[var(--teal)] mb-2 md:mb-3">التصميم المعماري</h3>
        <p class="text-gray-500 text-sm leading-relaxed mb-4 md:mb-5">مخططات معمارية تفصيلية وثلاثية الأبعاد تعكس رؤيتك وتلبي احتياجك الوظيفي والجمالي.</p>
        <ul class="space-y-1.5 md:space-y-2 text-xs md:text-sm text-gray-600 mb-4 md:mb-6">
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> مخططات طوابق ومساقط</li>
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> واجهات أمامية وخلفية</li>
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> تصور 3D واقعي</li>
        </ul>
        <a href="#" class="inline-flex items-center gap-1 text-[var(--gold-dark)] font-bold text-sm hover:gap-3 transition-all">اقرأ المزيد <i class="ph-bold ph-arrow-left"></i></a>
      </div>
      <!-- Card 2 -->
      <div data-services-reveal class="services-reveal card-hover bg-white border border-gray-100 rounded-3xl p-6 md:p-8 relative overflow-hidden">
        <div class="deco-corner" style="top:-1px;left:-1px;border-right:none;border-bottom:none;border-radius:0 0 30px 0;"></div>
        <div class="icon-wrap mb-4 md:mb-5"><i class="ph-bold ph-file-text text-2xl md:text-3xl"></i></div>
        <h3 class="text-lg md:text-xl font-extrabold text-[var(--teal)] mb-2 md:mb-3">إصدار رخص البناء</h3>
        <p class="text-gray-500 text-sm leading-relaxed mb-4 md:mb-5">نتولى عنك كل الإجراءات من تجهيز المخططات حتى اعتمادها من الجهات الرسمية بدون تعقيد.</p>
        <ul class="space-y-1.5 md:space-y-2 text-xs md:text-sm text-gray-600 mb-4 md:mb-6">
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> رخص سكني وتجاري</li>
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> رخص ترميم وإضافة</li>
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> متابعة إلكترونية</li>
        </ul>
        <a href="#" class="inline-flex items-center gap-1 text-[var(--gold-dark)] font-bold text-sm hover:gap-3 transition-all">اقرأ المزيد <i class="ph-bold ph-arrow-left"></i></a>
      </div>
      <!-- Card 3 -->
      <div data-services-reveal class="services-reveal card-hover bg-white border border-gray-100 rounded-3xl p-6 md:p-8 relative overflow-hidden">
        <div class="deco-corner" style="top:-1px;left:-1px;border-right:none;border-bottom:none;border-radius:0 0 30px 0;"></div>
        <div class="icon-wrap mb-4 md:mb-5"><i class="ph-bold ph-ruler text-2xl md:text-3xl"></i></div>
        <h3 class="text-lg md:text-xl font-extrabold text-[var(--teal)] mb-2 md:mb-3">الإشراف الهندسي</h3>
        <p class="text-gray-500 text-sm leading-relaxed mb-4 md:mb-5">متابعة ميدانية لمراحل التنفيذ للتأكد من مطابقة الأعمال للمواصفات والمخططات المعتمدة.</p>
        <ul class="space-y-1.5 md:space-y-2 text-xs md:text-sm text-gray-600 mb-4 md:mb-6">
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> تقارير دورية مفصلة</li>
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> ضبط جودة التنفيذ</li>
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> استلام المراحل</li>
        </ul>
        <a href="#" class="inline-flex items-center gap-1 text-[var(--gold-dark)] font-bold text-sm hover:gap-3 transition-all">اقرأ المزيد <i class="ph-bold ph-arrow-left"></i></a>
      </div>
      <!-- Card 4 -->
      <div data-services-reveal class="services-reveal card-hover bg-white border border-gray-100 rounded-3xl p-6 md:p-8 relative overflow-hidden">
        <div class="deco-corner" style="top:-1px;left:-1px;border-right:none;border-bottom:none;border-radius:0 0 30px 0;"></div>
        <div class="icon-wrap mb-4 md:mb-5"><i class="ph-bold ph-hard-hat text-2xl md:text-3xl"></i></div>
        <h3 class="text-lg md:text-xl font-extrabold text-[var(--teal)] mb-2 md:mb-3">الاستشارات الهندسية</h3>
        <p class="text-gray-500 text-sm leading-relaxed mb-4 md:mb-5">جلسات استشارية مع مهندسين معتمدين لدراسة الجدوى وتقديم حلول فنية واقتصادية مدروسة.</p>
        <ul class="space-y-1.5 md:space-y-2 text-xs md:text-sm text-gray-600 mb-4 md:mb-6">
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> دراسات جدوى فنية</li>
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> تقييم عقاري</li>
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> استشارات كود البناء</li>
        </ul>
        <a href="#" class="inline-flex items-center gap-1 text-[var(--gold-dark)] font-bold text-sm hover:gap-3 transition-all">اقرأ المزيد <i class="ph-bold ph-arrow-left"></i></a>
      </div>
      <!-- Card 5 -->
      <div data-services-reveal class="services-reveal card-hover bg-white border border-gray-100 rounded-3xl p-6 md:p-8 relative overflow-hidden">
        <div class="deco-corner" style="top:-1px;left:-1px;border-right:none;border-bottom:none;border-radius:0 0 30px 0;"></div>
        <div class="icon-wrap mb-4 md:mb-5"><i class="ph-bold ph-paint-roller text-2xl md:text-3xl"></i></div>
        <h3 class="text-lg md:text-xl font-extrabold text-[var(--teal)] mb-2 md:mb-3">التصميم الداخلي</h3>
        <p class="text-gray-500 text-sm leading-relaxed mb-4 md:mb-5">حلول تصميم داخلي تعكس ذوقك وتُحسّن استغلال الفراغات بألوان وإضاءة مدروسة.</p>
        <ul class="space-y-1.5 md:space-y-2 text-xs md:text-sm text-gray-600 mb-4 md:mb-6">
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> اختيار المواد والألوان</li>
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> تصميم الإضاءة</li>
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> أثاث مخصص</li>
        </ul>
        <a href="#" class="inline-flex items-center gap-1 text-[var(--gold-dark)] font-bold text-sm hover:gap-3 transition-all">اقرأ المزيد <i class="ph-bold ph-arrow-left"></i></a>
      </div>
      <!-- Card 6 -->
      <div data-services-reveal class="services-reveal card-hover bg-white border border-gray-100 rounded-3xl p-6 md:p-8 relative overflow-hidden">
        <div class="deco-corner" style="top:-1px;left:-1px;border-right:none;border-bottom:none;border-radius:0 0 30px 0;"></div>
        <div class="icon-wrap mb-4 md:mb-5"><i class="ph-bold ph-leaf text-2xl md:text-3xl"></i></div>
        <h3 class="text-lg md:text-xl font-extrabold text-[var(--teal)] mb-2 md:mb-3">التصميم المستدام</h3>
        <p class="text-gray-500 text-sm leading-relaxed mb-4 md:mb-5">حلول صديقة للبيئة تراعي كفاءة الطاقة وتقلل من استهلاك الموارد على المدى الطويل.</p>
        <ul class="space-y-1.5 md:space-y-2 text-xs md:text-sm text-gray-600 mb-4 md:mb-6">
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> عزل حراري متقدم</li>
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> طاقة شمسية</li>
          <li class="flex items-center gap-2"><i class="ph-fill ph-check-circle text-[var(--gold)]"></i> مواد مستدامة</li>
        </ul>
        <a href="#" class="inline-flex items-center gap-1 text-[var(--gold-dark)] font-bold text-sm hover:gap-3 transition-all">اقرأ المزيد <i class="ph-bold ph-arrow-left"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- ====== WHY US ====== -->
<section id="why-us" class="relative w-full py-16 md:py-24 mt-0 md:mt-8 bg-[var(--bg-soft)] overflow-hidden">

  <!-- Mobile: stacked image-first -->
  <div class="md:hidden px-5">
    <div data-why-reveal class="why-reveal mb-8">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 py-1.5 rounded-full text-xs font-bold mb-4">
        <i class="ph-bold ph-question"></i> لماذا الديوان؟
      </div>
      <h2 class="text-3xl font-black text-[var(--teal)] mb-3 leading-tight">لماذا الديوان؟</h2>
      <p class="text-lg font-bold text-[var(--gold-dark)] mb-3 leading-snug">نلتزم بتقديم خدمات هندسية احترافية تجمع بين الجودة والدقة، والالتزام في جميع مراحل المشروع</p>
      <div class="section-title-underline mb-4"></div>
      <p class="text-gray-500 text-sm leading-relaxed">نعمل بشغف لنحوّل الرؤى المعمارية إلى واقع معتمد، ونلتزم بأعلى معايير الجودة والشفافية مع عملائنا.</p>
    </div>
    <div data-why-reveal class="why-reveal relative mb-8">
      <div class="absolute -top-4 -right-4 w-24 h-24 bg-[var(--gold)]/20 rounded-full blur-2xl"></div>
      <div class="absolute -bottom-4 -left-4 w-28 h-28 bg-[var(--teal)]/20 rounded-full blur-2xl"></div>
      <img src="https://files.catbox.moe/8jxeio.jpg" alt="مشاريعنا" class="relative rounded-3xl shadow-2xl w-full object-cover max-h-72">
    </div>
    <div class="space-y-5">
      <div data-why-reveal class="why-reveal flex items-start gap-4">
        <div class="w-11 h-11 rounded-2xl bg-[var(--gold)]/10 text-[var(--gold-dark)] flex items-center justify-center shrink-0"><i class="ph-bold ph-medal text-lg"></i></div>
        <div>
          <h4 class="font-extrabold text-[var(--teal)] text-base mb-1">خبرة معتمدة تتجاوز 12 سنة</h4>
          <p class="text-gray-500 text-sm">فريق من المهندسين السعوديين المعتمدين لدى الهيئة السعودية للمهندسين.</p>
        </div>
      </div>
      <div data-why-reveal class="why-reveal flex items-start gap-4">
        <div class="w-11 h-11 rounded-2xl bg-[var(--gold)]/10 text-[var(--gold-dark)] flex items-center justify-center shrink-0"><i class="ph-bold ph-clock-countdown text-lg"></i></div>
        <div>
          <h4 class="font-extrabold text-[var(--teal)] text-base mb-1">التزام بالوقت والتسليم</h4>
          <p class="text-gray-500 text-sm">جدول زمني واضح ومتابعة دورية لكل مرحلة من مراحل المشروع.</p>
        </div>
      </div>
      <div data-why-reveal class="why-reveal flex items-start gap-4">
        <div class="w-11 h-11 rounded-2xl bg-[var(--gold)]/10 text-[var(--gold-dark)] flex items-center justify-center shrink-0"><i class="ph-bold ph-currency-dollar text-lg"></i></div>
        <div>
          <h4 class="font-extrabold text-[var(--teal)] text-base mb-1">أسعار شفافة بدون مفاجآت</h4>
          <p class="text-gray-500 text-sm">عروض أسعار مفصّلة من البداية، بدون رسوم مخفية أو تعديلات مفاجئة.</p>
        </div>
      </div>
      <div data-why-reveal class="why-reveal flex items-start gap-4">
        <div class="w-11 h-11 rounded-2xl bg-[var(--gold)]/10 text-[var(--gold-dark)] flex items-center justify-center shrink-0"><i class="ph-bold ph-headset text-lg"></i></div>
        <div>
          <h4 class="font-extrabold text-[var(--teal)] text-base mb-1">دعم فني بعد التسليم</h4>
          <p class="text-gray-500 text-sm">نبقى معك بعد اعتماد المشروع للإجابة عن أي استفسار أو تعديل لاحق.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Desktop: 2-col layout (image right, content left) -->
  <div class="hidden md:block container mx-auto px-6">
    <div class="grid lg:grid-cols-2 gap-16 items-start">
      <div data-why-reveal class="relative why-reveal lg:order-2 flex justify-start lg:mr-16 lg:mt-10">
        <div class="absolute -top-6 -right-6 w-32 h-32 bg-[var(--gold)]/20 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-[var(--teal)]/20 rounded-full blur-2xl"></div>
        <img src="https://files.catbox.moe/8jxeio.jpg" alt="مشاريعنا" class="relative rounded-3xl shadow-2xl w-auto max-w-full max-h-[520px]">
      </div>
      <div data-why-reveal class="why-reveal lg:order-1">
        <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-4 py-1.5 rounded-full text-sm font-bold mb-4">
          <i class="ph-bold ph-question"></i> لماذا الديوان؟
        </div>
        <h2 class="text-4xl lg:text-5xl font-black text-[var(--teal)] mb-3 leading-tight">لماذا الديوان؟</h2>
        <p class="text-xl lg:text-2xl font-bold text-[var(--gold-dark)] mb-4 leading-snug">نلتزم بتقديم خدمات هندسية احترافية تجمع بين الجودة والدقة، والالتزام في جميع مراحل المشروع</p>
        <div class="section-title-underline mb-6"></div>
        <p class="text-gray-500 text-lg mb-8 leading-relaxed">نعمل بشغف لنحوّل الرؤى المعمارية إلى واقع معتمد، ونلتزم بأعلى معايير الجودة والشفافية مع عملائنا.</p>
        <div class="space-y-5">
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[var(--gold)]/10 text-[var(--gold-dark)] flex items-center justify-center shrink-0"><i class="ph-bold ph-medal text-xl"></i></div>
            <div>
              <h4 class="font-extrabold text-[var(--teal)] text-lg mb-1">خبرة معتمدة تتجاوز 12 سنة</h4>
              <p class="text-gray-500">فريق من المهندسين السعوديين المعتمدين لدى الهيئة السعودية للمهندسين.</p>
            </div>
          </div>
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[var(--gold)]/10 text-[var(--gold-dark)] flex items-center justify-center shrink-0"><i class="ph-bold ph-clock-countdown text-xl"></i></div>
            <div>
              <h4 class="font-extrabold text-[var(--teal)] text-lg mb-1">التزام بالوقت والتسليم</h4>
              <p class="text-gray-500">جدول زمني واضح ومتابعة دورية لكل مرحلة من مراحل المشروع.</p>
            </div>
          </div>
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[var(--gold)]/10 text-[var(--gold-dark)] flex items-center justify-center shrink-0"><i class="ph-bold ph-currency-dollar text-xl"></i></div>
            <div>
              <h4 class="font-extrabold text-[var(--teal)] text-lg mb-1">أسعار شفافة بدون مفاجآت</h4>
              <p class="text-gray-500">عروض أسعار مفصّلة من البداية، بدون رسوم مخفية أو تعديلات مفاجئة.</p>
            </div>
          </div>
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[var(--gold)]/10 text-[var(--gold-dark)] flex items-center justify-center shrink-0"><i class="ph-bold ph-headset text-xl"></i></div>
            <div>
              <h4 class="font-extrabold text-[var(--teal)] text-lg mb-1">دعم فني بعد التسليم</h4>
              <p class="text-gray-500">نبقى معك بعد اعتماد المشروع للإجابة عن أي استفسار أو تعديل لاحق.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ====== PROCESS (آلية العمل) ====== -->
<section class="relative overflow-hidden">

  <!-- Mobile: vertical timeline -->
  <div class="md:hidden min-h-screen flex flex-col bg-white">
    <div class="px-6 pt-6 pb-4 flex items-center justify-between shrink-0">
      <span class="font-display font-bold text-[11px] tracking-[0.35em]" style="color:var(--ink);">الديوان</span>
      <span class="h-px flex-1 mx-3" style="background:var(--line);"></span>
      <span class="font-display font-bold text-[10px] tracking-[0.3em]" style="color:var(--gold);">EST. 2026</span>
    </div>
    <div class="px-6 text-right shrink-0 generic-reveal">
      <span class="font-display font-bold text-[11px] tracking-[0.3em]" style="color:var(--gold);">HOW WE WORK</span>
      <h1 class="font-display font-black text-4xl mt-1 mb-2" style="color:var(--ink);">آلية العمل</h1>
      <p class="text-sm font-medium leading-7" style="color:var(--teal);">نتبع منهجية عمل واضحة لضمان تقديم خدمات هندسية دقيقة واحترافية في جميع مراحل المشروع</p>
    </div>
    <div class="px-6 mt-6 pb-8">
      <div class="relative">
        <div class="absolute top-2 bottom-2 right-[33px] w-px" style="background:var(--line);"></div>
        <div class="space-y-7">
          <div class="relative flex items-start gap-4 generic-reveal">
            <div class="w-[40px] h-[40px] rounded-full flex items-center justify-center font-display font-black text-base shrink-0 z-10" style="background:var(--ink); color:var(--gold);">١</div>
            <div class="text-right flex-1 pt-1.5">
              <h3 class="font-display font-black text-base mb-1" style="color:var(--gold);">استقبال الطلب</h3>
              <p class="text-[13px] font-medium leading-relaxed" style="color:var(--teal);">يستقبل فريقنا طلبك ويطلع على احتياجات المشروع.</p>
            </div>
          </div>
          <div class="relative flex items-start gap-4 generic-reveal">
            <div class="w-[40px] h-[40px] rounded-full flex items-center justify-center font-display font-black text-base shrink-0 z-10" style="background:var(--ink); color:var(--gold);">٢</div>
            <div class="text-right flex-1 pt-1.5">
              <h3 class="font-display font-black text-base mb-1" style="color:var(--gold);">دراسة المشروع</h3>
              <p class="text-[13px] font-medium leading-relaxed" style="color:var(--teal);">تحليل المتطلبات وتحديد أفضل الحلول الهندسية.</p>
            </div>
          </div>
          <div class="relative flex items-start gap-4 generic-reveal">
            <div class="w-[40px] h-[40px] rounded-full flex items-center justify-center font-display font-black text-base shrink-0 z-10" style="background:var(--ink); color:var(--gold);">٣</div>
            <div class="text-right flex-1 pt-1.5">
              <h3 class="font-display font-black text-base mb-1" style="color:var(--gold);">تنفيذ الخدمة</h3>
              <p class="text-[13px] font-medium leading-relaxed" style="color:var(--teal);">تنفيذ الخدمة وفق أعلى معايير الجودة والاحترافية.</p>
            </div>
          </div>
          <div class="relative flex items-start gap-4 generic-reveal">
            <div class="w-[40px] h-[40px] rounded-full flex items-center justify-center font-display font-black text-base shrink-0 z-10" style="background:var(--gold); color:var(--ink);">٤</div>
            <div class="text-right flex-1 pt-1.5">
              <h3 class="font-display font-black text-base mb-1" style="color:var(--gold);">التسليم والمتابعة</h3>
              <p class="text-[13px] font-medium leading-relaxed" style="color:var(--teal);">تسليم النتائج ومتابعة العميل عند الحاجة.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="px-6 pb-5 mt-auto flex items-center justify-between shrink-0">
      <span class="text-[10px] tracking-widest" style="color:var(--teal);">© الديوان للاستشارات الهندسية</span>
      <span class="text-[10px] tracking-widest" style="color:var(--gold);">2026</span>
    </div>
  </div>

  <!-- Desktop: 4-col grid -->
  <div class="hidden md:flex relative h-screen overflow-hidden flex-col">
    <div class="pt-16 px-10 text-right max-w-3xl mr-10 generic-reveal">
      <div class="flex items-center gap-2 mb-3 justify-end">
        <span class="font-display font-bold text-[11px] tracking-[0.35em]" style="color:var(--gold);">HOW WE WORK</span>
        <span class="w-8 h-px" style="background:var(--gold);"></span>
      </div>
      <h1 class="font-display font-black text-5xl mb-3" style="color:var(--gold);">آلية العمل</h1>
      <p class="text-xl font-bold leading-relaxed" style="color:var(--teal);">نتبع منهجية عمل واضحة لضمان تقديم خدمات هندسية دقيقة واحترافية في جميع مراحل المشروع</p>
    </div>
    <div class="flex-1 flex items-center px-16">
      <div class="w-full grid grid-cols-4 gap-6 relative">
        <div class="relative text-right generic-reveal" style="transition-delay:0.1s;">
          <div class="flex items-center justify-end mb-5">
            <div class="w-[68px] h-[68px] rounded-full flex items-center justify-center font-display font-black text-2xl shrink-0" style="background:var(--ink); color:var(--gold);">١</div>
          </div>
          <h3 class="font-display font-black text-xl mb-2" style="color:var(--gold);">استقبال الطلب</h3>
          <p class="text-[15px] font-medium leading-relaxed" style="color:var(--teal);">يستقبل فريقنا طلبك ويطلع على احتياجات المشروع.</p>
        </div>
        <div class="relative text-right generic-reveal" style="transition-delay:0.2s;">
          <div class="flex items-center justify-end mb-5">
            <div class="w-[68px] h-[68px] rounded-full flex items-center justify-center font-display font-black text-2xl shrink-0" style="background:var(--ink); color:var(--gold);">٢</div>
          </div>
          <h3 class="font-display font-black text-xl mb-2" style="color:var(--gold);">دراسة المشروع</h3>
          <p class="text-[15px] font-medium leading-relaxed" style="color:var(--teal);">تحليل المتطلبات وتحديد أفضل الحلول الهندسية.</p>
        </div>
        <div class="relative text-right generic-reveal" style="transition-delay:0.3s;">
          <div class="flex items-center justify-end mb-5">
            <div class="w-[68px] h-[68px] rounded-full flex items-center justify-center font-display font-black text-2xl shrink-0" style="background:var(--ink); color:var(--gold);">٣</div>
          </div>
          <h3 class="font-display font-black text-xl mb-2" style="color:var(--gold);">تنفيذ الخدمة</h3>
          <p class="text-[15px] font-medium leading-relaxed" style="color:var(--teal);">تنفيذ الخدمة وفق أعلى معايير الجودة والاحترافية.</p>
        </div>
        <div class="relative text-right generic-reveal" style="transition-delay:0.4s;">
          <div class="flex items-center justify-end mb-5">
            <div class="w-[68px] h-[68px] rounded-full flex items-center justify-center font-display font-black text-2xl shrink-0" style="background:var(--gold); color:var(--ink);">٤</div>
          </div>
          <h3 class="font-display font-black text-xl mb-2" style="color:var(--gold);">التسليم والمتابعة</h3>
          <p class="text-[15px] font-medium leading-relaxed" style="color:var(--teal);">تسليم النتائج ومتابعة العميل عند الحاجة.</p>
        </div>
      </div>
    </div>
    <div class="pb-8 px-10 flex items-center justify-between">
      <span class="text-[10px] tracking-widest" style="color:var(--teal);">© الديوان للاستشارات الهندسية</span>
      <span class="text-[10px] tracking-widest" style="color:var(--gold);">2026</span>
    </div>
  </div>
</section>

<!-- ====== PROJECTS ====== -->
<section id="projects" class="relative py-16 md:py-24 bg-[var(--bg-soft)] overflow-hidden">
  <div class="container mx-auto px-5 md:px-6">
    <div class="text-center max-w-2xl mx-auto mb-10 md:mb-16 generic-reveal">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ph-bold ph-buildings"></i> مشاريعنا
      </div>
      <h2 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-3 md:mb-4">نماذج من أعمالنا</h2>
      <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
      <p class="text-gray-500 text-sm md:text-lg">مجموعة مختارة من المشاريع السكنية والتجارية التي نفخر بتنفيذها لعملائنا.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-7">
      <div class="project-card card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal">
        <div class="relative overflow-hidden h-64">
          <img src="https://files.catbox.moe/3i7imq.webp" alt="مشروع سكني" class="project-img w-full h-full object-cover">
          <div class="project-overlay absolute inset-0 bg-gradient-to-t from-[var(--teal)]/90 to-transparent flex items-end p-6">
            <button class="bg-white text-[var(--teal)] w-12 h-12 rounded-full flex items-center justify-center hover:bg-[var(--gold)] hover:text-white transition">
              <i class="ph-bold ph-arrow-up-left text-xl"></i>
            </button>
          </div>
          <span class="absolute top-4 right-4 bg-[var(--gold)] text-white text-xs font-bold px-3 py-1.5 rounded-full">سكني</span>
        </div>
        <div class="p-5 md:p-6">
          <h3 class="font-extrabold text-[var(--teal)] text-base md:text-lg mb-2">فيلا سكنية — حي النرجس</h3>
          <p class="text-gray-500 text-xs md:text-sm mb-3 md:mb-4">تصميم معماري متكامل، 4 غرف نوم، مجلس رجال ونساء، حديقة خاصة.</p>
          <div class="flex items-center justify-between text-xs text-gray-500">
            <span class="flex items-center gap-1"><i class="ph-bold ph-map-pin"></i> الرياض</span>
            <span class="flex items-center gap-1"><i class="ph-bold ph-calendar"></i> 2024</span>
            <span class="flex items-center gap-1"><i class="ph-bold ph-ruler"></i> 450 م²</span>
          </div>
        </div>
      </div>

      <div class="project-card card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal">
        <div class="relative overflow-hidden h-64">
          <img src="https://files.catbox.moe/3i7imq.webp" alt="مشروع تجاري" class="project-img w-full h-full object-cover">
          <div class="project-overlay absolute inset-0 bg-gradient-to-t from-[var(--teal)]/90 to-transparent flex items-end p-6">
            <button class="bg-white text-[var(--teal)] w-12 h-12 rounded-full flex items-center justify-center hover:bg-[var(--gold)] hover:text-white transition">
              <i class="ph-bold ph-arrow-up-left text-xl"></i>
            </button>
          </div>
          <span class="absolute top-4 right-4 bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-full">تجاري</span>
        </div>
        <div class="p-5 md:p-6">
          <h3 class="font-extrabold text-[var(--teal)] text-base md:text-lg mb-2">مجمع تجاري — حي الملقا</h3>
          <p class="text-gray-500 text-xs md:text-sm mb-3 md:mb-4">مبنى تجاري من 3 طوابق، 18 وحدة، موقف سفلي وخدمات متكاملة.</p>
          <div class="flex items-center justify-between text-xs text-gray-500">
            <span class="flex items-center gap-1"><i class="ph-bold ph-map-pin"></i> الرياض</span>
            <span class="flex items-center gap-1"><i class="ph-bold ph-calendar"></i> 2024</span>
            <span class="flex items-center gap-1"><i class="ph-bold ph-ruler"></i> 2200 م²</span>
          </div>
        </div>
      </div>

      <div class="project-card card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal">
        <div class="relative overflow-hidden h-64">
          <img src="https://files.catbox.moe/3i7imq.webp" alt="مشروع ترميم" class="project-img w-full h-full object-cover">
          <div class="project-overlay absolute inset-0 bg-gradient-to-t from-[var(--teal)]/90 to-transparent flex items-end p-6">
            <button class="bg-white text-[var(--teal)] w-12 h-12 rounded-full flex items-center justify-center hover:bg-[var(--gold)] hover:text-white transition">
              <i class="ph-bold ph-arrow-up-left text-xl"></i>
            </button>
          </div>
          <span class="absolute top-4 right-4 bg-[var(--teal)] text-white text-xs font-bold px-3 py-1.5 rounded-full">ترميم</span>
        </div>
        <div class="p-5 md:p-6">
          <h3 class="font-extrabold text-[var(--teal)] text-base md:text-lg mb-2">ترميم فيلا تراثية</h3>
          <p class="text-gray-500 text-xs md:text-sm mb-3 md:mb-4">إعادة تأهيل فيلا قديمة مع الحفاظ على الطابع المعماري التراثي.</p>
          <div class="flex items-center justify-between text-xs text-gray-500">
            <span class="flex items-center gap-1"><i class="ph-bold ph-map-pin"></i> جدة</span>
            <span class="flex items-center gap-1"><i class="ph-bold ph-calendar"></i> 2023</span>
            <span class="flex items-center gap-1"><i class="ph-bold ph-ruler"></i> 680 م²</span>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center mt-10 md:mt-12">
      <button class="btn-secondary text-sm md:text-lg font-bold rounded-full inline-flex items-center gap-2" style="padding:.9rem 2rem; md:padding:1rem 2.5rem;">
        عرض جميع المشاريع <i class="ph-bold ph-arrow-left"></i>
      </button>
    </div>
  </div>
</section>

<!-- ====== ARTICLES ====== -->
<section id="articles" class="relative py-16 md:py-24 bg-white overflow-hidden">
  <div class="container mx-auto px-5 md:px-6">
    <div class="text-center max-w-2xl mx-auto mb-10 md:mb-16 generic-reveal">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ph-bold ph-newspaper"></i> المقالات
      </div>
      <h2 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-3 md:mb-4">من مدوّنتنا الهندسية</h2>
      <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
      <p class="text-gray-500 text-sm md:text-lg">مقالات ونصائح معمارية تساعدك على فهم مشروعك واتخاذ قرارات أفضل.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-7">
      <article class="card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal">
        <div class="relative overflow-hidden h-52">
          <img src="https://files.catbox.moe/3i7imq.webp" class="w-full h-full object-cover project-img">
          <span class="absolute top-4 right-4 bg-[var(--teal)] text-white text-xs font-bold px-3 py-1.5 rounded-full">نصائح</span>
        </div>
        <div class="p-5 md:p-6">
          <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
            <span class="flex items-center gap-1"><i class="ph-bold ph-calendar"></i> 15 مايو 2024</span>
            <span class="flex items-center gap-1"><i class="ph-bold ph-eye"></i> 2.4K</span>
          </div>
          <h3 class="font-extrabold text-[var(--teal)] text-base md:text-lg mb-2 leading-snug">7 أخطاء شائعة قبل إصدار رخصة البناء وكيف تتجنبها</h3>
          <p class="text-gray-500 text-xs md:text-sm mb-4 md:mb-5 line-clamp-2">تعرّف على أبرز الأخطاء التي يقع فيها أصحاب المشاريع قبل البدء بالإجراءات الرسمية.</p>
          <a href="#" class="inline-flex items-center gap-1 text-[var(--gold-dark)] font-bold text-sm hover:gap-3 transition-all">اقرأ المقال <i class="ph-bold ph-arrow-left"></i></a>
        </div>
      </article>
      <article class="card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal">
        <div class="relative overflow-hidden h-52">
          <img src="https://files.catbox.moe/3i7imq.webp" class="w-full h-full object-cover project-img">
          <span class="absolute top-4 right-4 bg-[var(--gold)] text-white text-xs font-bold px-3 py-1.5 rounded-full">تصميم</span>
        </div>
        <div class="p-5 md:p-6">
          <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
            <span class="flex items-center gap-1"><i class="ph-bold ph-calendar"></i> 28 أبريل 2024</span>
            <span class="flex items-center gap-1"><i class="ph-bold ph-eye"></i> 1.8K</span>
          </div>
          <h3 class="font-extrabold text-[var(--teal)] text-base md:text-lg mb-2 leading-snug">كيف تختار الواجهة المعمارية الأنسب لفيلتك</h3>
          <p class="text-gray-500 text-xs md:text-sm mb-4 md:mb-5 line-clamp-2">دليل مبسط للاختيار بين الطرازات المعمارية الحديثة والكلاسيكية والتراثية.</p>
          <a href="#" class="inline-flex items-center gap-1 text-[var(--gold-dark)] font-bold text-sm hover:gap-3 transition-all">اقرأ المقال <i class="ph-bold ph-arrow-left"></i></a>
        </div>
      </article>
      <article class="card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal">
        <div class="relative overflow-hidden h-52">
          <img src="https://files.catbox.moe/3i7imq.webp" class="w-full h-full object-cover project-img">
          <span class="absolute top-4 right-4 bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-full">تشريعات</span>
        </div>
        <div class="p-5 md:p-6">
          <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
            <span class="flex items-center gap-1"><i class="ph-bold ph-calendar"></i> 10 أبريل 2024</span>
            <span class="flex items-center gap-1"><i class="ph-bold ph-eye"></i> 3.1K</span>
          </div>
          <h3 class="font-extrabold text-[var(--teal)] text-base md:text-lg mb-2 leading-snug">أهم تحديثات كود البناء السعودي 2024</h3>
          <p class="text-gray-500 text-xs md:text-sm mb-4 md:mb-5 line-clamp-2">ملخص لأبرز التعديلات في كود البناء السعودي وأثرها على المشاريع السكنية الجديدة.</p>
          <a href="#" class="inline-flex items-center gap-1 text-[var(--gold-dark)] font-bold text-sm hover:gap-3 transition-all">اقرأ المقال <i class="ph-bold ph-arrow-left"></i></a>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ====== Divider ====== -->
<div class="w-full py-6 flex items-center justify-center">
  <div class="w-1/3 h-px bg-gray-100"></div>
</div>

<!-- ====== CONTACT ====== -->
<section id="contact" class="relative py-16 md:py-24 bg-white overflow-hidden">
  <div class="container mx-auto px-5 md:px-6">
    <div class="text-center max-w-2xl mx-auto mb-10 md:mb-16 generic-reveal">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ph-bold ph-envelope-simple-open"></i> تواصل معنا
      </div>
      <h2 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-3 md:mb-4">نحن هنا للإجابة على أسئلتك</h2>
      <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
      <p class="text-gray-500 text-sm md:text-lg">أرسل لنا تفاصيل مشروعك وسنعود إليك خلال 24 ساعة بعرض مفصّل.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 md:gap-10">
      <div class="lg:col-span-2 space-y-4 md:space-y-5 generic-reveal">
        <div class="card-hover bg-white border border-gray-100 rounded-3xl p-5 md:p-6 flex items-start gap-3 md:gap-4">
          <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[var(--gold)] to-[var(--gold-dark)] text-white flex items-center justify-center shrink-0"><i class="ph-bold ph-phone text-xl md:text-2xl"></i></div>
          <div>
            <h4 class="font-extrabold text-[var(--teal)] mb-1 text-sm md:text-base">اتصل بنا</h4>
            <p class="text-gray-500 text-xs md:text-sm mb-1">الأحد - الخميس | 9ص - 6م</p>
            <a href="tel:920000123" class="font-bold text-[var(--teal)] text-sm md:text-base" style="direction:ltr; display:inline-block;">920 000 123</a>
          </div>
        </div>
        <div class="card-hover bg-white border border-gray-100 rounded-3xl p-5 md:p-6 flex items-start gap-3 md:gap-4">
          <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[var(--gold)] to-[var(--gold-dark)] text-white flex items-center justify-center shrink-0"><i class="ph-bold ph-envelope-simple text-xl md:text-2xl"></i></div>
          <div>
            <h4 class="font-extrabold text-[var(--teal)] mb-1 text-sm md:text-base">البريد الإلكتروني</h4>
            <p class="text-gray-500 text-xs md:text-sm mb-1">نرد خلال 24 ساعة</p>
            <a href="mailto:info@aldiwan.sa" class="font-bold text-[var(--teal)] text-sm md:text-base">info@aldiwan.sa</a>
          </div>
        </div>
        <div class="card-hover bg-white border border-gray-100 rounded-3xl p-5 md:p-6 flex items-start gap-3 md:gap-4">
          <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[var(--gold)] to-[var(--gold-dark)] text-white flex items-center justify-center shrink-0"><i class="ph-bold ph-map-pin text-xl md:text-2xl"></i></div>
          <div>
            <h4 class="font-extrabold text-[var(--teal)] mb-1 text-sm md:text-base">المقر الرئيسي</h4>
            <p class="text-gray-500 text-xs md:text-sm">طريق الملك فهد، حي العليا</p>
            <p class="font-bold text-[var(--teal)] text-sm md:text-base">الرياض 12241، المملكة العربية السعودية</p>
          </div>
        </div>
        <div class="card-hover bg-white border border-gray-100 rounded-3xl p-5 md:p-6 flex items-start gap-3 md:gap-4">
          <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[var(--gold)] to-[var(--gold-dark)] text-white flex items-center justify-center shrink-0"><i class="ph-bold ph-whatsapp-logo text-xl md:text-2xl"></i></div>
          <div>
            <h4 class="font-extrabold text-[var(--teal)] mb-1 text-sm md:text-base">واتساب الأعمال</h4>
            <p class="text-gray-500 text-xs md:text-sm mb-1">تواصل فوري مع فريقنا</p>
            <a href="#" class="font-bold text-[var(--teal)] text-sm md:text-base" style="direction:ltr; display:inline-block;">+966 50 123 4567</a>
          </div>
        </div>
      </div>

      <div class="lg:col-span-3 generic-reveal">
        <form class="bg-white border border-gray-100 rounded-3xl p-6 md:p-8 shadow-xl shadow-gray-200/50">
          <h3 class="text-xl md:text-2xl font-extrabold text-[var(--teal)] mb-2">أرسل طلبك</h3>
          <p class="text-gray-500 text-sm mb-5 md:mb-7">املأ النموذج وسنعود إليك بعرض مفصّل خلال 24 ساعة عمل.</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5 mb-4 md:mb-5">
            <div>
              <label class="block text-sm font-bold text-[var(--teal)] mb-2">الاسم الكامل *</label>
              <input type="text" class="field" placeholder="اكتب اسمك">
            </div>
            <div>
              <label class="block text-sm font-bold text-[var(--teal)] mb-2">رقم الجوال *</label>
              <input type="tel" class="field" placeholder="05xxxxxxxx">
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5 mb-4 md:mb-5">
            <div>
              <label class="block text-sm font-bold text-[var(--teal)] mb-2">البريد الإلكتروني</label>
              <input type="email" class="field" placeholder="example@email.com">
            </div>
            <div>
              <label class="block text-sm font-bold text-[var(--teal)] mb-2">نوع الخدمة *</label>
              <select class="field">
                <option>تصميم معماري</option>
                <option>إصدار رخصة بناء</option>
                <option>إشراف هندسي</option>
                <option>استشارات هندسية</option>
                <option>تصميم داخلي</option>
                <option>أخرى</option>
              </select>
            </div>
          </div>
          <div class="mb-4 md:mb-5">
            <label class="block text-sm font-bold text-[var(--teal)] mb-2">تفاصيل المشروع</label>
            <textarea rows="5" class="field" placeholder="اشرح لنا باختصار عن مشروعك (الموقع، المساحة، نوع المبنى، إلخ)"></textarea>
          </div>
          <button type="submit" class="btn-primary w-full text-base md:text-lg font-bold rounded-full inline-flex items-center justify-center gap-2" style="padding:.9rem 1rem; md:padding:1rem;">
            إرسال الطلب <i class="ph-bold ph-paper-plane-tilt text-lg md:text-xl"></i>
          </button>
          <p class="text-xs text-gray-400 mt-3 md:mt-4 text-center">بإرسالك النموذج، فأنت توافق على <a href="#" class="text-[var(--gold-dark)] font-bold">سياسة الخصوصية</a>.</p>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ====== FOOTER ====== -->
<footer class="relative pt-16 pb-6 overflow-hidden" style="background: linear-gradient(135deg, var(--teal-dark) 0%, #1f2e34 100%);">
  <div class="absolute inset-0 geo-pattern opacity-5"></div>
  <div class="container mx-auto px-5 md:px-6 relative z-10 text-white">
    <div class="bg-gradient-to-l from-[var(--gold)] to-[var(--gold-dark)] rounded-3xl p-5 md:p-8 mb-10 md:mb-12 flex flex-col md:flex-row items-center justify-between gap-4 shadow-2xl">
      <div class="text-right">
        <h3 class="text-lg md:text-2xl font-black text-white mb-1">جاهز تبدأ مشروعك؟</h3>
        <p class="text-white/90 text-xs md:text-sm">احجز استشارتك المجانية الآن مع مهندسينا المعتمدين.</p>
      </div>
      <button class="bg-white text-[var(--gold-dark)] font-extrabold text-sm md:text-base rounded-full inline-flex items-center gap-2 hover:scale-105 transition" style="padding:.7rem 1.5rem; md:padding:.8rem 2rem;">
        احجز الآن <i class="ph-bold ph-arrow-left"></i>
      </button>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-10 mb-8 md:mb-10">
      <div class="col-span-2 md:col-span-1">
        <img src="https://files.catbox.moe/ekyv64.webp" alt="لوجو" class="mb-4 bg-white/10 rounded-2xl p-2" style="height:50px;">
        <p class="text-white/70 text-xs md:text-sm leading-relaxed mb-4 md:mb-5">مكتب هندسي سعودي معتمد، نقدم حلولاً متكاملة من التصميم حتى إصدار رخص البناء منذ 2012.</p>
        <div class="flex items-center gap-2 md:gap-3">
          <a href="#" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-white/10 hover:bg-[var(--gold)] flex items-center justify-center transition"><i class="ph-bold ph-facebook-logo text-base md:text-lg"></i></a>
          <a href="#" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-white/10 hover:bg-[var(--gold)] flex items-center justify-center transition"><i class="ph-bold ph-instagram-logo text-base md:text-lg"></i></a>
          <a href="#" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-white/10 hover:bg-[var(--gold)] flex items-center justify-center transition"><i class="ph-bold ph-twitter-logo text-base md:text-lg"></i></a>
          <a href="#" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-white/10 hover:bg-[var(--gold)] flex items-center justify-center transition"><i class="ph-bold ph-youtube-logo text-base md:text-lg"></i></a>
          <a href="#" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-white/10 hover:bg-[var(--gold)] flex items-center justify-center transition"><i class="ph-bold ph-linkedin-logo text-base md:text-lg"></i></a>
        </div>
      </div>
      <div>
        <h4 class="font-extrabold text-base md:text-lg mb-4 md:mb-5 relative inline-block">روابط سريعة<span class="absolute -bottom-2 right-0 h-1 w-10 bg-[var(--gold)] rounded-full"></span></h4>
        <ul class="space-y-2 md:space-y-3 text-xs md:text-sm text-white/70 mt-5">
          <li><a href="#home" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ph-bold ph-caret-left text-xs text-[var(--gold)]"></i> الرئيسية</a></li>
          <li><a href="#services" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ph-bold ph-caret-left text-xs text-[var(--gold)]"></i> خدماتنا</a></li>
          <li><a href="#projects" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ph-bold ph-caret-left text-xs text-[var(--gold)]"></i> مشاريعنا</a></li>
          <li><a href="#about" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ph-bold ph-caret-left text-xs text-[var(--gold)]"></i> من نحن</a></li>
          <li><a href="#articles" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ph-bold ph-caret-left text-xs text-[var(--gold)]"></i> المقالات</a></li>
          <li><a href="#contact" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ph-bold ph-caret-left text-xs text-[var(--gold)]"></i> تواصل معنا</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-extrabold text-base md:text-lg mb-4 md:mb-5 relative inline-block">خدماتنا<span class="absolute -bottom-2 right-0 h-1 w-10 bg-[var(--gold)] rounded-full"></span></h4>
        <ul class="space-y-2 md:space-y-3 text-xs md:text-sm text-white/70 mt-5">
          <li><a href="#" class="hover:text-[var(--gold)] transition">التصميم المعماري</a></li>
          <li><a href="#" class="hover:text-[var(--gold)] transition">رخص البناء</a></li>
          <li><a href="#" class="hover:text-[var(--gold)] transition">الإشراف الهندسي</a></li>
          <li><a href="#" class="hover:text-[var(--gold)] transition">التصميم الداخلي</a></li>
          <li><a href="#" class="hover:text-[var(--gold)] transition">الاستشارات</a></li>
          <li><a href="#" class="hover:text-[var(--gold)] transition">كود البناء</a></li>
        </ul>
      </div>
      <div class="col-span-2 md:col-span-1">
        <h4 class="font-extrabold text-base md:text-lg mb-4 md:mb-5 relative inline-block">تواصل معنا<span class="absolute -bottom-2 right-0 h-1 w-10 bg-[var(--gold)] rounded-full"></span></h4>
        <ul class="space-y-3 md:space-y-4 text-xs md:text-sm text-white/70 mt-5">
          <li class="flex items-start gap-3"><i class="ph-bold ph-map-pin text-[var(--gold)] text-base md:text-lg shrink-0 mt-0.5"></i><span>طريق الملك فهد، حي العليا، الرياض 12241</span></li>
          <li class="flex items-start gap-3"><i class="ph-bold ph-phone text-[var(--gold)] text-base md:text-lg shrink-0 mt-0.5"></i><a href="tel:920000123" class="hover:text-[var(--gold)] transition" style="direction:ltr; display:inline-block;">920 000 123</a></li>
          <li class="flex items-start gap-3"><i class="ph-bold ph-envelope-simple text-[var(--gold)] text-base md:text-lg shrink-0 mt-0.5"></i><a href="mailto:info@aldiwan.sa" class="hover:text-[var(--gold)] transition">info@aldiwan.sa</a></li>
          <li class="flex items-start gap-3"><i class="ph-bold ph-clock text-[var(--gold)] text-base md:text-lg shrink-0 mt-0.5"></i><span>الأحد - الخميس: 9ص - 6م</span></li>
        </ul>
      </div>
    </div>
    <div class="border-t border-white/10 pt-5 md:pt-6 flex flex-col md:flex-row items-center justify-between gap-3 md:gap-4 text-xs md:text-sm text-white/50">
      <div>© 2024 مكتب الديوان الهندسي. جميع الحقوق محفوظة.</div>
      <div class="flex items-center gap-4 md:gap-5">
        <a href="#" class="hover:text-[var(--gold)] transition">سياسة الخصوصية</a>
        <a href="#" class="hover:text-[var(--gold)] transition">الشروط والأحكام</a>
        <a href="#" class="hover:text-[var(--gold)] transition">خريطة الموقع</a>
      </div>
    </div>
  </div>
</footer>

<button id="toTop" class="fixed bottom-6 left-6 z-50 w-12 h-12 rounded-full btn-primary flex items-center justify-center shadow-xl opacity-0 pointer-events-none transition-all duration-300" style="padding:0;">
  <i class="ph-bold ph-arrow-up text-xl"></i>
</button>

<script>
  // Nav active state + smooth scroll
  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      if (href && href.startsWith('#')) {
        e.preventDefault();
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        const target = document.querySelector(href);
        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // Mobile menu links (close drawer + scroll)
  document.querySelectorAll('.mobile-link').forEach(link => {
    link.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      if (href && href.startsWith('#')) {
        e.preventDefault();
        const menu = document.getElementById('mobileMenu');
        if (menu) menu.classList.add('hidden');
        const target = document.querySelector(href);
        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // Mobile menu toggle
  const menuBtn = document.getElementById('menuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
  }

  // Back to top
  const toTop = document.getElementById('toTop');
  if (toTop) {
    window.addEventListener('scroll', () => {
      toTop.style.opacity = window.scrollY > 400 ? '1' : '0';
      toTop.style.pointerEvents = window.scrollY > 400 ? 'auto' : 'none';
    });
    toTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  }

  // Unified reveal animation
  function makeObserver(selector, visibleClass) {
    const els = document.querySelectorAll(selector);
    if (!els.length) return;
    const obs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add(visibleClass);
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });
    els.forEach(el => obs.observe(el));
  }

  document.addEventListener('DOMContentLoaded', () => {
    makeObserver('[data-reveal]', 'is-visible');
    makeObserver('[data-services-reveal]', 'is-visible');
    makeObserver('[data-why-reveal]', 'is-visible');
    makeObserver('.generic-reveal', 'visible');
  });
</script>

</body>
</html>

