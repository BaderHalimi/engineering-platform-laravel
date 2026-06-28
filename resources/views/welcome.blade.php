@extends('layouts.visitor')

@section('title', 'شركة الديوان للاستشارات الهندسية')
@section('description', 'من الفكرة إلى رخصة البناء بوضوح عبر حلول هندسية تراعي الكود السعودي وتكلفة التنفيذ.')

@push('styles')
<style>
    .hero { position: relative; overflow: hidden; min-height: calc(100svh - 72px); border-bottom: 1px solid rgb(255 255 255 / .1); background: var(--deep-slate); color: var(--white); }
    .hero-grid-bg { position: absolute; inset: 0; background-image: linear-gradient(to right, rgb(255 255 255 / .08) 1px, transparent 1px), linear-gradient(to bottom, rgb(255 255 255 / .08) 1px, transparent 1px); background-size: 44px 44px; mask-image: linear-gradient(to bottom, black, transparent 92%); }
    .hero-ring-a, .hero-ring-b { position: absolute; border: 1px solid rgb(255 255 255 / .13); border-radius: 999px; }
    .hero-ring-a { right: -96px; top: 96px; width: 288px; height: 288px; }
    .hero-ring-b { left: -80px; bottom: 40px; width: 384px; height: 384px; border-color: rgb(245 173 42 / .3); }
    .hero-layout { position: relative; display: grid; align-items: center; gap: 40px; min-height: calc(100svh - 72px); padding-block: 56px; }
    .hero-copy { max-width: 760px; }
    .hero-eyebrow { display: inline-flex; margin-bottom: 20px; border: 1px solid rgb(255 255 255 / .15); border-radius: 8px; background: rgb(255 255 255 / .1); padding: 6px 12px; color: var(--white); font-size: 14px; font-weight: 800; }
    .hero h1 { margin: 0; color: var(--white); font-size: clamp(40px, 7vw, 72px); line-height: 1.15; font-weight: 950; letter-spacing: 0; }
    .hero p { margin: 24px 0 0; max-width: 680px; color: rgb(255 255 255 / .78); font-size: 19px; line-height: 2; }
    .hero-actions { margin-top: 32px; }
    .hero-steps { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 32px; }
    .hero-steps span { border: 1px solid rgb(255 255 255 / .15); border-radius: 8px; background: rgb(255 255 255 / .1); padding: 9px 12px; color: var(--white); font-size: 14px; font-weight: 800; }
    .hero-visual { position: relative; min-height: 560px; }
    .permit-map { position: absolute; inset: 0; isolation: isolate; }
    .map-orbit { position: absolute; border: 1px solid rgb(82 105 112 / .16); border-radius: 999px; animation: orbit-drift 12s ease-in-out infinite; }
    .map-orbit-one { inset: 10% 8% 18% 0; }
    .map-orbit-two { inset: 22% 18% 8% 12%; animation-delay: -4s; }
    .route-line { position: absolute; inset: 6% 0 10%; z-index: 2; width: 100%; height: 84%; }
    .route-shadow, .route-path { fill: none; stroke-linecap: round; stroke-linejoin: round; }
    .route-shadow { stroke: rgb(255 255 255 / .16); stroke-width: 28; }
    .route-path { stroke: var(--bright-orange); stroke-width: 7; stroke-dasharray: 18 18; animation: route-flow 2.4s linear infinite; }
    .station { position: absolute; z-index: 5; display: grid; min-width: 108px; gap: 4px; border: 1px solid rgb(61 80 87 / .16); border-radius: 8px; padding: 12px 14px; background: rgb(255 255 255 / .86); box-shadow: 0 18px 50px rgb(61 80 87 / .12); backdrop-filter: blur(10px); animation: station-in 700ms ease both, station-float 6s ease-in-out infinite; }
    .station span { color: var(--bright-orange); font-size: 12px; font-weight: 950; }
    .station strong { color: var(--deep-slate); font-size: 16px; }
    .station-one { right: 4%; bottom: 20%; }
    .station-two { right: 26%; top: 18%; animation-delay: 100ms, 800ms; }
    .station-three { left: 26%; bottom: 24%; animation-delay: 200ms, 1400ms; }
    .station-four { left: 4%; top: 8%; animation-delay: 300ms, 2000ms; }
    .blueprint-card { position: absolute; right: 14%; top: 38%; z-index: 3; width: min(320px, 52%); rotate: 4deg; border: 1px solid rgb(82 105 112 / .18); border-radius: 8px; padding: 18px; background: rgb(255 255 255 / .78); box-shadow: 0 28px 70px rgb(61 80 87 / .16); backdrop-filter: blur(10px); }
    .blueprint-title { display: flex; align-items: center; gap: 8px; color: var(--soft-teal); font-weight: 950; }
    .blueprint-title-mark { display: inline-grid; place-items: center; width: 22px; height: 22px; border-radius: 6px; background: var(--orange-50); color: var(--bright-orange); }
    .blueprint-plan { position: relative; margin-top: 18px; aspect-ratio: 1.6; border: 1px solid rgb(82 105 112 / .24); background-image: linear-gradient(to right, rgb(82 105 112 / .12) 1px, transparent 1px), linear-gradient(to bottom, rgb(82 105 112 / .12) 1px, transparent 1px); background-size: 24px 24px; }
    .blueprint-plan span { position: absolute; background: var(--deep-slate); opacity: .48; }
    .blueprint-plan span:nth-child(1) { inset: 24% 14% auto; height: 2px; }
    .blueprint-plan span:nth-child(2) { inset: 54% 14% auto; height: 2px; }
    .blueprint-plan span:nth-child(3) { inset: 18% 28% 20% auto; width: 2px; }
    .blueprint-plan span:nth-child(4) { inset: 18% auto 20% 24%; width: 2px; }
    .blueprint-plan span:nth-child(5) { inset: auto 16% 16%; height: 2px; background: var(--bright-orange); opacity: 1; }
    .tower-model { position: absolute; left: 11%; bottom: 11%; z-index: 4; display: flex; align-items: end; gap: 10px; height: 190px; padding-inline: 16px; }
    .tower { width: 34px; border: 5px solid var(--bright-orange); border-bottom-width: 10px; background: rgb(255 255 255 / .5); animation: tower-rise 900ms ease both; }
    .tower-a { height: 96px; } .tower-b { height: 146px; animation-delay: 120ms; } .tower-c { height: 112px; animation-delay: 240ms; } .tower-d { height: 78px; animation-delay: 360ms; }
    .trust { padding-block: 40px; }
    .trust-card { display: flex; align-items: center; gap: 12px; padding: 16px; font-weight: 800; }
    .fit { display: block; margin-top: 16px; border-radius: 4px; background: var(--orange-50); padding: 10px 12px; color: #526970; font-size: 14px; font-weight: 800; line-height: 1.7; }
    .assistant-layout { display: grid; grid-template-columns: .9fr 1.1fr; gap: 32px; align-items: start; }
    @keyframes route-flow { to { stroke-dashoffset: -72; } }
    @keyframes station-in { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes station-float { 0%, 100% { translate: 0 0; } 50% { translate: 0 -10px; } }
    @keyframes tower-rise { from { opacity: 0; transform: scaleY(.2); transform-origin: bottom; } to { opacity: 1; transform: scaleY(1); transform-origin: bottom; } }
    @keyframes orbit-drift { 0%, 100% { transform: translate3d(0, 0, 0); } 50% { transform: translate3d(-16px, -12px, 0); } }
    @media (min-width: 860px) { .hero-layout { grid-template-columns: 1.05fr .95fr; } }
    @media (max-width: 980px) { .hero-visual { min-height: 500px; } .assistant-layout { grid-template-columns: 1fr; } }
    @media (max-width: 680px) { .hero-layout { padding-block: 44px; } .hero h1 { font-size: 38px; } .hero p { font-size: 17px; } .hero-visual { min-height: 420px; } .blueprint-card { right: 4%; width: 58%; } .tower-model { left: 2%; scale: .8; } .station { min-width: 88px; padding: 10px; } }
</style>
@endpush

@section('content')
@php
    $brand = config('site.brand');
    $trustItems = config('site.trust');
    $heroSteps = ['الفكرة', 'التصميم', 'الرخصة', 'التنفيذ'];
    $services = config('site.services');
    $projects = array_slice(config('site.projects'), 0, 3);
    $articles = array_slice(config('site.articles'), 0, 3);
@endphp

<section class="hero">
    <div class="hero-grid-bg"></div><div class="hero-ring-a"></div><div class="hero-ring-b"></div>
    <div class="container hero-layout">
        <div class="hero-copy">
            <span class="hero-eyebrow">استشارات هندسية في المدينة المنورة</span>
            <h1>من الفكرة إلى رخصة البناء بوضوح</h1>
            <p>حلول تصميم ورخص بناء تساعدك على فهم خطوات مشروعك، من دراسة الاحتياج حتى جاهزية المخططات، بما يراعي الكود السعودي وتكلفة التنفيذ.</p>
            <div class="button-row hero-actions"><a class="btn btn-primary" href="/request-service">اطلب خدمة</a><a class="btn btn-outline" href="{{ $brand['whatsapp'] }}" target="_blank" rel="noopener">تحدث معنا عبر واتساب</a></div>
            <div class="hero-steps">@foreach ($heroSteps as $step)<span>{{ $step }}</span>@endforeach</div>
        </div>
        <div class="hero-visual" aria-hidden="true"><div class="permit-map"><div class="map-orbit map-orbit-one"></div><div class="map-orbit map-orbit-two"></div><svg class="route-line" viewBox="0 0 720 520" fill="none"><path class="route-shadow" d="M92 404 C180 270 214 116 346 184 C488 258 424 396 626 116" /><path class="route-path" d="M92 404 C180 270 214 116 346 184 C488 258 424 396 626 116" /></svg><div class="station station-one"><span>01</span><strong>الفكرة</strong></div><div class="station station-two"><span>02</span><strong>التصميم</strong></div><div class="station station-three"><span>03</span><strong>الرخصة</strong></div><div class="station station-four"><span>04</span><strong>التنفيذ</strong></div><div class="blueprint-card"><div class="blueprint-title"><span class="blueprint-title-mark">+</span><span>Permit route</span></div><div class="blueprint-plan"><span></span><span></span><span></span><span></span><span></span></div></div><div class="tower-model"><span class="tower tower-a"></span><span class="tower tower-b"></span><span class="tower tower-c"></span><span class="tower tower-d"></span></div></div></div>
    </div>
</section>

<section class="trust"><div class="container grid four-grid">@foreach ($trustItems as $index => $item)<div class="card trust-card"><span class="icon-badge">{{ $index + 1 }}</span><span>{{ $item }}</span></div>@endforeach</div></section>

<section class="section muted-section"><div class="container"><div class="section-head"><p class="eyebrow">الخدمات الرئيسية</p><h2 class="section-title">خدمات هندسية واضحة من أول قرار</h2><p class="section-copy">بطاقات مختصرة للخدمات الأساسية، مع مسار مباشر لمعرفة التفاصيل أو طلب الخدمة.</p></div><div class="grid three-grid">@foreach ($services as $service)<article class="card card-pad"><span class="icon-badge">{{ $service['number'] }}</span><h3>{{ $service['title'] }}</h3><p>{{ $service['summary'] }}</p><span class="fit">{{ $service['audience'] }}</span><div class="button-row" style="margin-top:20px"><a class="btn btn-light" href="/services/{{ $service['slug'] }}">معرفة المزيد</a><a class="btn btn-primary" href="/request-service?service={{ $service['slug'] }}">طلب الخدمة</a></div></article>@endforeach</div></div></section>

<section class="section"><div class="container"><div class="section-head"><p class="eyebrow">كيف نعمل؟</p><h2 class="section-title">خطوات منظمة من دراسة الاحتياج إلى الرخصة</h2></div><div class="grid four-grid">@foreach (['فهم الاحتياج' => 'نحدد نوع المشروع والمساحة والمدينة وطبيعة القرار المطلوب.', 'تطوير التصميم' => 'نحوّل الاحتياج إلى حل هندسي عملي قابل للمراجعة والتنفيذ.', 'تجهيز المتطلبات' => 'نرتب المستندات والمعلومات المطلوبة قبل الرفع أو المتابعة.', 'المتابعة والتوضيح' => 'نبقي المسار واضحاً ونراجع التفاصيل مع العميل خطوة بخطوة.'] as $title => $copy)<article class="card card-pad"><span class="icon-badge">{{ $loop->iteration }}</span><h3>{{ $title }}</h3><p>{{ $copy }}</p></article>@endforeach</div></div></section>

<section class="section warm-section"><div class="container two-col"><div><p class="eyebrow">لماذا الديوان؟</p><h2 class="section-title">مستشار هندسي يشرح القرار لا يبيع الخدمة فقط</h2><p class="section-copy">نساعد العميل على فهم المتطلبات والخطوات قبل بدء التصميم، بلغة واضحة وسياق محلي يراعي الكود السعودي وتكلفة التنفيذ.</p></div><div class="grid">@foreach (['توضيح المتطلبات قبل التصميم', 'سياق سعودي ومحلي', 'طلب خدمة جاهز للمراجعة'] as $item)<article class="card card-pad"><span class="icon-badge">✓</span><h3>{{ $item }}</h3><p>نقلل الغموض حول المستندات والخطوات حتى يبدأ المشروع على أساس مفهوم وقابل للمراجعة.</p></article>@endforeach</div></div></section>

<section class="section"><div class="container"><div class="section-head"><p class="eyebrow">مشاريع مختارة</p><h2 class="section-title">نماذج أعمال قابلة للتصنيف حسب الخدمة</h2></div><div class="grid three-grid">@foreach ($projects as $project)<article class="card" style="overflow:hidden"><div class="project-visual"><div class="project-pattern"><span></span><span></span><span></span><span></span><span></span></div></div><div class="card-pad"><div class="meta"><span>{{ $project['service'] }}</span><span>{{ $project['city'] }}</span></div><h3>{{ $project['title'] }}</h3><p>{{ $project['summary'] }}</p></div></article>@endforeach</div><div class="button-row" style="margin-top:24px"><a class="btn btn-light" href="/projects">كل المشاريع</a></div></div></section>

<section class="section dark-section"><div class="container assistant-layout"><div><p class="eyebrow">مساعد اختيار الخدمة</p><h2 class="section-title">غير متأكد من الخدمة المناسبة؟</h2><p class="section-copy">ابدأ بإدخال نوع العميل والخدمة والمدينة، وسنحوّل الطلب إلى ملخص واضح للفريق الداخلي.</p></div><form class="form-card form-grid" action="/request-service" method="GET"><label class="field">نوع العميل<select name="client_type"><option>مالك أرض أو عقار</option><option>مطور عقاري</option><option>مقاول</option></select></label><label class="field">نوع الخدمة<select name="service">@foreach ($services as $service)<option value="{{ $service['slug'] }}">{{ $service['title'] }}</option>@endforeach</select></label><label class="field">المدينة<input name="city" placeholder="مثال: المدينة المنورة"></label><label class="field">رقم الجوال<input name="phone" placeholder="05xxxxxxxx"></label><div class="span-2"><button class="btn btn-primary" type="submit" style="width:100%">انتقل إلى طلب الخدمة</button></div></form></div></section>

<section class="section"><div class="container"><div class="section-head"><p class="eyebrow">المعرفة الهندسية</p><h2 class="section-title">مقالات تساعد العميل قبل التواصل</h2></div><div class="grid three-grid">@foreach ($articles as $article)<article class="card card-pad"><span class="icon-badge">i</span><h3>{{ $article['title'] }}</h3><p>{{ $article['excerpt'] }}</p><div class="button-row" style="margin-top:18px"><a class="btn btn-light" href="/knowledge/{{ $article['slug'] }}">اقرأ المقال</a></div></article>@endforeach</div></div></section>

<section><div class="container" style="padding-block:56px;display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap"><div><h2 class="section-title">ابدأ مشروعك على أساس هندسي موثوق</h2><p class="section-copy">اطلب الخدمة وسنراجع التفاصيل معك بوضوح قبل الانتقال للخطوة التالية.</p></div><a class="btn btn-primary" href="/request-service">اطلب خدمة</a></div></section>
@endsection