<!--
  ============================================================
  قسم الخدمات — إعادة تصميم كاملة للواجهة (Frontend)
  البنية الخلفية (Backend logic) محفوظة بالكامل من الكود الأصلي:
  - $services من قاعدة البيانات
  - $tr() لمعالجة الترجمة (name / short_description)
  - $asset() للثمبنيل
  - price_type labels (fixed / starting_from / quote)
  - documented / visit_required / estimated_time
  - رابط الطلب إلى #contact

  التصميم: مستوحى من "لوحة المخطط الهندسي" (Blueprint / Technical Drawing)
  — رمز مرجعي بأسلوب رموز الرسم الهندسي (A-01, A-02...)
  — خط قياس (ruler) يفصل الأقسام
  — "ختم مهندس معتمد" دائري كعنصر توقيع في الزاوية
  — المواصفات (سعر/وقت/توثيق) بشكل جدول فني مصغّر بدل الفقاعات
  ============================================================
-->
<section id="services" class="relative w-full py-16 md:py-28 bg-white overflow-hidden">

  <!-- خلفية شبكية دقيقة تحاكي ورق المخططات -->
  <div class="absolute inset-0 blueprint-grid pointer-events-none"></div>
  <div class="blob hidden md:block" style="width:280px;height:280px;background:var(--gold);top:80px;inset-inline-start:-60px;opacity:.08;"></div>

  <div class="site-container relative z-10">

    <!-- ===== عنوان القسم ===== -->
    <div x-data x-intersect.once="$el.classList.add('is-visible')" class="services-reveal text-center max-w-2xl mx-auto mb-14 md:mb-20">
      <div class="inline-flex items-center gap-2 border border-[var(--gold)]/40 text-[var(--gold-dark)] px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4 tracking-widest">
        <i class="ri-compasses-2-line"></i> {{ __('home.services.badge') }}
      </div>
      <h2 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-3 md:mb-4">{{ __('home.services.title') }}</h2>
      <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
      <p class="text-gray-500 text-sm md:text-lg">{{ __('home.services.subtitle') }}</p>
    </div>

    <!-- ===== شبكة الخدمات ===== -->
    @if(($services ?? collect())->count())
      @php
        $serviceItems = ($services ?? collect())->values();
        $serviceCount = max(1, $serviceItems->count());
        $itemsPerLoop = max($serviceCount, (int) ceil(14 / $serviceCount) * $serviceCount);
        $marqueeCopies = 2;
      @endphp
      <div class="services-marquee-shell" style="--marquee-copy-count: {{ $marqueeCopies }};">
        <div class="services-marquee-track">
          @for($copy = 0; $copy < $marqueeCopies; $copy++)
            <div class="services-marquee-group" aria-hidden="{{ $copy > 0 ? 'true' : 'false' }}" @if($copy > 0) inert @endif>
              @for($loopIndex = 0; $loopIndex < $itemsPerLoop; $loopIndex++)
                @php
                  $service = $serviceItems[$loopIndex % $serviceCount];
                  $index = $loopIndex % $serviceCount;
                @endphp
                @include('partials.home.service-card', [
                  'service' => $service,
                  'index' => $index,
                  'tr' => $tr,
                  'asset' => $asset,
                  'contactUrl' => $contactUrl ?? null,
                ])
              @endfor
            </div>
          @endfor
        </div>
      </div>
    @else
      <div class="text-center text-gray-400 py-10">{{ __('home.services.empty') }}</div>
    @endif
  </div>
</section>

<style>
  /* ===== خلفية ورق المخططات ===== */
  .blueprint-grid{
    background-image:
      linear-gradient(rgba(82,105,112,.05) 1px, transparent 1px),
      linear-gradient(90deg, rgba(82,105,112,.05) 1px, transparent 1px);
    background-size: 36px 36px;
    mask-image: radial-gradient(ellipse 80% 60% at 50% 30%, black 0%, transparent 75%);
  }

  /* ===== الكارت ===== */
  .services-marquee-shell{
    position: relative;
    width: 100vw;
    margin-inline: calc(50% - 50vw);
    overflow: hidden;
    padding-block: 1.5rem 2.25rem;
    -webkit-mask-image: linear-gradient(270deg, transparent 0, #000 8%, #000 92%, transparent 100%);
    mask-image: linear-gradient(270deg, transparent 0, #000 8%, #000 92%, transparent 100%);
  }
  .services-marquee-track{
    display: flex;
    width: max-content;
    gap: 0;
    direction: ltr;
    animation: services-marquee 42s linear infinite;
    will-change: transform;
  }
  .services-marquee-shell:hover .services-marquee-track{
    animation-play-state: paused;
  }
  .services-marquee-group{
    display: flex;
    align-items: stretch;
    gap: 1.75rem;
    padding-inline: .875rem;
  }
  .services-marquee-group[aria-hidden="true"]{
    pointer-events: none;
  }
  .service-marquee-card{
    width: min(82vw, 390px);
    min-height: 100%;
    flex: 0 0 min(82vw, 390px);
  }
  @keyframes services-marquee{
    from{ transform: translateX(0); }
    to{ transform: translateX(calc(-100% / var(--marquee-copy-count))); }
  }
  .blueprint-card{
    border: 1.5px solid #e7e2d8;
    border-radius: 22px;
    overflow: visible;
    transition: transform .45s cubic-bezier(.2,.8,.2,1), box-shadow .45s ease, border-color .45s ease;
  }
  .blueprint-card:hover{
    transform: translateY(-8px);
    border-color: var(--gold);
    box-shadow: 0 28px 48px -26px rgba(82,105,112,.4);
  }

  /* ===== ختم المهندس ===== */
  .stamp-seal{ width:64px; height:64px; }
  .stamp-ring{
    width:100%; height:100%; border-radius:50%;
    border:2px dashed var(--gold-dark);
    background: radial-gradient(circle, #fff 55%, rgba(245,173,42,.08) 100%);
    display:flex; align-items:center; justify-content:center;
    box-shadow: 0 8px 18px -8px rgba(82,105,112,.35);
    transition: transform .5s cubic-bezier(.2,.8,.2,1), border-color .4s ease;
  }
  .blueprint-card:hover .stamp-ring{
    transform: rotate(18deg) scale(1.08);
    border-color: var(--teal);
  }
  .stamp-code{
    font-size: 11px; font-weight: 900; letter-spacing: .05em;
    color: var(--teal-dark);
    font-family:var(--font-primary);
  }

  /* ===== رأس الكارت (صورة/أيقونة) ===== */
  .blueprint-head{
    height: 168px;
    border-radius: 22px 22px 0 0;
    background: linear-gradient(135deg, rgba(82,105,112,.06), rgba(245,173,42,.05));
  }
  .blueprint-thumb{
    width:100%; height:100%; object-fit:cover;
    filter: grayscale(.15) contrast(1.02);
    transition: transform .6s cubic-bezier(.2,.8,.2,1), filter .5s ease;
  }
  .blueprint-card:hover .blueprint-thumb{
    transform: scale(1.06);
    filter: grayscale(0) contrast(1.05);
  }
  .blueprint-head-overlay{
    position:absolute; inset:0;
    background: linear-gradient(to top, rgba(30,42,48,.35), transparent 60%);
  }
  .blueprint-icon-only{
    height:100%; display:flex; align-items:center; justify-content:center;
    font-size: 2.75rem; color: var(--gold-dark);
  }
  .blueprint-corner-tag{
    position:absolute; bottom:10px; inset-inline-start:14px;
    font-size:10px; font-weight:800; letter-spacing:.15em;
    color:#fff; background: rgba(30,42,48,.55); backdrop-filter: blur(4px);
    padding:3px 10px; border-radius:999px;
  }

  /* ===== خط القياس الفاصل ===== */
  .ruler-divider{
    height:1px;
    background-image: repeating-linear-gradient(to left, var(--line) 0 6px, transparent 6px 12px);
  }

  /* ===== جدول المواصفات الفنية ===== */
  .spec-table{
    border: 1px solid #eee9de;
    border-radius: 14px;
    overflow: hidden;
  }
  .spec-row{
    display:flex; align-items:center; justify-content:space-between;
    padding: 9px 14px;
    font-size: 13px;
    border-bottom: 1px solid #f1eee5;
    background: var(--bg-soft);
  }
  .spec-row:last-child{ border-bottom:none; }
  .spec-label{
    display:flex; align-items:center; gap:6px;
    color: var(--teal-dark); font-weight:700;
  }
  .spec-label i{ color: var(--gold-dark); font-size:14px; }
  .spec-value{ color:#6b7280; font-weight:700; }
  .spec-value-gold{ color: var(--gold-dark); }
  .spec-check{
    width:20px; height:20px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    background: rgba(34,197,94,.12); color:#16a34a; font-size:12px;
  }
  .spec-check.spec-amber{ background: rgba(245,173,42,.15); color: var(--gold-dark); }

  /* ===== رابط الطلب ===== */
  .request-link{
    color:#fff; background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    padding: .7rem 1.2rem; border-radius: 999px;
    box-shadow: 0 10px 22px -10px rgba(245,173,42,.55);
    transition: transform .3s ease, box-shadow .3s ease, gap .3s ease;
  }
  .request-link:hover{
    transform: translateY(-2px);
    box-shadow: 0 14px 26px -8px rgba(245,173,42,.65);
    gap: .6rem;
  }

  @media (prefers-reduced-motion: reduce){
    .services-marquee-track{ animation:none !important; }
    .blueprint-card, .blueprint-thumb, .stamp-ring, .request-link{ transition:none !important; }
  }
</style>
