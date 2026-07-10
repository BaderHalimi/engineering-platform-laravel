<section id="home" class="blueprint-hero relative w-full overflow-hidden pt-6 md:pt-0 pl-44 pr-44">

  {{-- شبكة المخطط الهندسي (بديل الـ blobs) --}}
  <div class="bp-grid hidden md:block" aria-hidden="true"></div>

  {{-- علامات تسجيل الطباعة بزوايا القسم --}}
  <svg class="reg-mark reg-tl hidden md:block" viewBox="0 0 40 40" aria-hidden="true">
    <circle cx="20" cy="20" r="9" fill="none" stroke="currentColor" stroke-width="1"/>
    <line x1="20" y1="2" x2="20" y2="38" stroke="currentColor" stroke-width="1"/>
    <line x1="2" y1="20" x2="38" y2="20" stroke="currentColor" stroke-width="1"/>
  </svg>
  <svg class="reg-mark reg-tr hidden md:block" viewBox="0 0 40 40" aria-hidden="true">
    <circle cx="20" cy="20" r="9" fill="none" stroke="currentColor" stroke-width="1"/>
    <line x1="20" y1="2" x2="20" y2="38" stroke="currentColor" stroke-width="1"/>
    <line x1="2" y1="20" x2="38" y2="20" stroke="currentColor" stroke-width="1"/>
  </svg>

  {{-- صورة الهيرو - موبايل --}}
  <div class="md:hidden px-5">
    <div class="relative rounded-2xl overflow-hidden shadow-xl mb-5 bp-frame-mobile">
      <img src="{{ $heroImage }}" alt="{{ $siteName ?? '' }}" class="w-full h-64 object-cover">
      <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(30,42,48,0.4), transparent 50%);"></div>

      <div class="absolute top-3 start-3 bp-tag" dir="ltr">DWG.01 · SCALE 1:1</div>

      <div class="absolute bottom-4 end-4 bg-white/95 backdrop-blur rounded-xl px-4 py-2 flex items-center gap-2 shadow-lg border border-black/5">
        <i class="ri-trophy-fill text-[var(--gold,#f5ad2a)] text-xl"></i>
        <div>
          <div class="font-extrabold text-[var(--teal,#526970)] text-xs">{{ __('home.hero.projects_count') }}</div>
          <div class="text-[10px] text-gray-500">{{ __('home.hero.projects_done') }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="container mx-auto px-5 md:px-6 md:h-full md:flex md:items-center relative z-20">
    <div class="md:max-w-2xl text-start md:mt-20 md:ms-auto">

      {{-- طابع الاعتماد بدل البادج العادي --}}
      <div class="stamp-badge anim anim-1">
        <span class="stamp-ring">
          <i class="ri-shield-check-fill"></i>
        </span>
        <span>{{ __('home.hero.badge') }}</span>
      </div>

      @if($siteLogo)
        <img src="{{ $asset($siteLogo) }}" alt="{{ $siteName ?? '' }}" class="mb-5 hidden md:block anim anim-1" style="height:56px;">
      @endif

      <h1 class="hero-title anim anim-2" style="color:var(--teal,#526970);">
        {!! __('home.hero.title') !!}
      </h1>

      <p class="hero-subtitle anim anim-3">
        {{ __('home.hero.subtitle') }}
      </p>

      <div class="flex items-center justify-start gap-3 md:gap-4 mb-8 md:mb-12 anim anim-4">
        <a href="#contact" @click.prevent="document.querySelector('#contact').scrollIntoView({behavior:'smooth'})"
           class="btn-primary w-full md:w-auto text-sm md:text-lg font-bold rounded-full flex items-center justify-center md:justify-start gap-2" style="padding:.9rem 1.5rem;">
          <span>{{ __('home.hero.cta') }}</span>
          <i class="ri-arrow-left-line rtl:inline ltr:hidden text-base md:text-xl"></i>
          <i class="ri-arrow-right-line ltr:inline rtl:hidden text-base md:text-xl"></i>
        </a>
        <a href="#projects" @click.prevent="document.querySelector('#projects').scrollIntoView({behavior:'smooth'})"
           class="hero-btn-outline hidden md:flex">
          <span class="hero-play-dot"><i class="ri-play-fill"></i></span>
          {{ __('home.hero.watch_work') }}
        </a>
      </div>

      {{-- خط القياس + الإحصائيات كـ "أبعاد" مرسومة --}}
      <div class="dim-wrap anim anim-5">
        <svg class="dim-line" viewBox="0 0 600 16" preserveAspectRatio="none" aria-hidden="true">
          <line x1="4" y1="8" x2="596" y2="8" />
          <path d="M4 2 L4 14 M596 2 L596 14" />
        </svg>

        <div class="dim-stats">
          <div class="dim-stat">
            <span class="dim-tick" aria-hidden="true"></span>
            <div class="dim-num">+850</div>
            <div class="dim-label">{{ __('home.hero.stat_projects') }}</div>
          </div>
          <div class="dim-stat">
            <span class="dim-tick" aria-hidden="true"></span>
            <div class="dim-num">+1200</div>
            <div class="dim-label">{{ __('home.hero.stat_licenses') }}</div>
          </div>
          <div class="dim-stat">
            <span class="dim-tick" aria-hidden="true"></span>
            <div class="dim-num">98%</div>
            <div class="dim-label">{{ __('home.hero.stat_satisfaction') }}</div>
          </div>
        </div>
      </div>
    </div>

    {{-- صورة الهيرو - ديسكتوب، مؤطرة كورقة مخطط --}}
    <div class="hidden md:block relative w-[38%] shrink-0 anim anim-3">
      <svg class="dim-line dim-line-top" viewBox="0 0 400 16" preserveAspectRatio="none" aria-hidden="true">
        <line x1="4" y1="8" x2="396" y2="8" />
        <path d="M4 2 L4 14 M396 2 L396 14" />
      </svg>

      <div class="bp-frame">
        <svg class="reg-mark reg-mini reg-mini-tl" viewBox="0 0 24 24"><circle cx="12" cy="12" r="6" fill="none" stroke="currentColor"/><line x1="12" y1="1" x2="12" y2="23" stroke="currentColor"/><line x1="1" y1="12" x2="23" y2="12" stroke="currentColor"/></svg>
        <svg class="reg-mark reg-mini reg-mini-tr" viewBox="0 0 24 24"><circle cx="12" cy="12" r="6" fill="none" stroke="currentColor"/><line x1="12" y1="1" x2="12" y2="23" stroke="currentColor"/><line x1="1" y1="12" x2="23" y2="12" stroke="currentColor"/></svg>
        <svg class="reg-mark reg-mini reg-mini-bl" viewBox="0 0 24 24"><circle cx="12" cy="12" r="6" fill="none" stroke="currentColor"/><line x1="12" y1="1" x2="12" y2="23" stroke="currentColor"/><line x1="1" y1="12" x2="23" y2="12" stroke="currentColor"/></svg>
        <svg class="reg-mark reg-mini reg-mini-br" viewBox="0 0 24 24"><circle cx="12" cy="12" r="6" fill="none" stroke="currentColor"/><line x1="12" y1="1" x2="12" y2="23" stroke="currentColor"/><line x1="1" y1="12" x2="23" y2="12" stroke="currentColor"/></svg>

        <img src="{{ $heroImage }}" alt="{{ $siteName ?? '' }}" class="w-full h-[500px] object-cover">

        <div class="bp-title-block" dir="ltr">
          <span>DWG. HERO—01</span>
          <span>REV. {{ date('y') }}</span>
          <span>SCALE 1:1</span>
        </div>
      </div>
    </div>
  </div>

  {{-- شريط الخدمات كـ "قائمة بنود" (Bill of Quantities) --}}
  @if(($services ?? collect())->count() >= 4)
  <div class="hidden lg:block relative z-30 mt-10">
    <div class="container mx-auto px-6">
      <div class="bp-ledger">
        @foreach($services->take(4) as $svc)
        <div class="bp-ledger-item {{ ! $loop->last ? 'has-divider' : '' }}">
          <span class="bp-ledger-index" dir="ltr">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 overflow-hidden bp-ledger-icon">
            @if($svc->thumbnail ?? null)
              <img src="{{ $asset($svc->thumbnail) }}" class="w-full h-full object-cover">
            @else
              <i class="{{ $svc->icon ?? 'ri-building-2-line' }} text-xl"></i>
            @endif
          </div>
          <div>
            <div class="bp-ledger-title">{{ $tr(is_array($svc->title) ? $svc->title : ['ar'=>$svc->title]) }}</div>
            <div class="bp-ledger-desc">{{ $tr(is_array($svc->short_description ?? null) ? $svc->short_description : ['ar'=>$svc->short_description ?? '']) }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @endif
</section>

<style>
.blueprint-hero {
  --hero-teal: var(--teal, #526970);
  --hero-teal-dark: var(--teal-dark, #3d5258);
  --hero-gold: var(--gold, #f5ad2a);
  --hero-gold-dark: var(--gold-dark, #dc9415);
  --hero-ink: var(--ink, #1E2A30);
  --hero-line: var(--line, #E6E3DC);
  background: #fff;
}

/* ===== شبكة المخطط ===== */
.bp-grid {
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(82,105,112,.05) 1px, transparent 1px),
    linear-gradient(90deg, rgba(82,105,112,.05) 1px, transparent 1px);
  background-size: 32px 32px;
  z-index: 1;
  -webkit-mask-image: radial-gradient(ellipse 70% 65% at 70% 30%, #000 40%, transparent 85%);
  mask-image: radial-gradient(ellipse 70% 65% at 70% 30%, #000 40%, transparent 85%);
}

/* ===== علامات تسجيل زوايا القسم ===== */
.reg-mark { position: absolute; width: 34px; height: 34px; color: rgba(82,105,112,.28); z-index: 2; }
.reg-tl { top: 22px; inset-inline-start: 22px; }
.reg-tr { top: 22px; inset-inline-end: 22px; }

/* ===== طابع الاعتماد ===== */
.stamp-badge {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: #fff;
  border: 1.5px dashed rgba(197,155,60,.55);
  color: var(--hero-gold-dark);
  padding: 8px 18px 8px 8px;
  border-radius: 999px;
  font-size: .8rem;
  font-weight: 800;
  margin-bottom: 22px;
  box-shadow: 0 2px 10px rgba(0,0,0,.03);
}
.stamp-ring {
  width: 26px; height: 26px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  background: var(--hero-gold-dark);
  color: #fff;
  font-size: 14px;
  flex-shrink: 0;
}

/* ===== العنوان ===== */
.hero-title {
  font-family: 'Cairo', sans-serif;
  font-weight: 800;
  line-height: 1.15;
  margin-bottom: 18px;
  font-size: 2.4rem;
  letter-spacing: -0.01em;
}
@media (min-width: 768px) { .hero-title { font-size: 4.2rem; } }

.hero-subtitle {
  color: #667079;
  line-height: 1.8;
  margin-bottom: 28px;
  font-size: .95rem;
  max-width: 560px;
}
@media (min-width: 768px) { .hero-subtitle { font-size: 1.35rem; } }

/* ===== زر ثانوي ===== */
.hero-btn-outline {
  align-items: center;
  gap: 10px;
  background: transparent;
  border: 1.5px dashed var(--hero-teal);
  color: var(--hero-teal);
  font-weight: 700;
  font-size: 1rem;
  border-radius: 999px;
  padding: .85rem 1.6rem;
  transition: all .2s ease;
}
.hero-btn-outline:hover { background: var(--hero-teal); color: #fff; border-style: solid; }
.hero-play-dot {
  width: 26px; height: 26px;
  border-radius: 50%;
  border: 1.5px solid currentColor;
  display: flex; align-items: center; justify-content: center;
  font-size: 12px;
}

/* ===== خط القياس (Dimension Line) ===== */
.dim-wrap { margin-top: 6px; }
.dim-line {
  width: 100%; height: 14px;
  stroke: var(--hero-teal);
  stroke-width: 1;
  fill: none;
  opacity: .55;
  margin-bottom: 14px;
}
.dim-line line, .dim-line path { stroke-dasharray: 640; stroke-dashoffset: 640; animation: drawLine 1.1s .5s ease-out forwards; }
.dim-line-top { display: block; margin-bottom: 10px; }

@keyframes drawLine { to { stroke-dashoffset: 0; } }

.dim-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
}
@media (min-width: 768px) { .dim-stats { display: flex; gap: 40px; } }

.dim-stat { position: relative; padding-top: 10px; text-align: center; }
@media (min-width: 768px) { .dim-stat { text-align: start; } }

.dim-tick {
  position: absolute; top: 0; inset-inline-start: 50%;
  transform: translateX(-50%);
  width: 1px; height: 8px;
  background: var(--hero-gold-dark);
}
@media (min-width: 768px) { .dim-tick { inset-inline-start: 0; transform: none; } }

.dim-num { font-family: 'Cairo', sans-serif; font-weight: 900; font-size: 1.4rem; color: var(--hero-ink); }
@media (min-width: 768px) { .dim-num { font-size: 1.9rem; } }
.dim-label { font-size: .68rem; font-weight: 700; color: #94989c; margin-top: 2px; }
@media (min-width: 768px) { .dim-label { font-size: .8rem; } }

/* ===== إطار صورة الهيرو (ديسكتوب) ===== */
.bp-frame {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 30px 60px -20px rgba(30,42,48,.35);
  border: 1px solid rgba(255,255,255,.4);
}
.reg-mini { position: absolute; width: 22px; height: 22px; color: rgba(255,255,255,.75); z-index: 5; filter: drop-shadow(0 1px 2px rgba(0,0,0,.4)); }
.reg-mini-tl { top: 12px; inset-inline-start: 12px; }
.reg-mini-tr { top: 12px; inset-inline-end: 12px; }
.reg-mini-bl { bottom: 46px; inset-inline-start: 12px; }
.reg-mini-br { bottom: 46px; inset-inline-end: 12px; }

.bp-title-block {
  position: absolute;
  bottom: 0; inset-inline: 0;
  background: rgba(30,42,48,.82);
  backdrop-filter: blur(6px);
  color: #fff;
  display: flex;
  justify-content: space-between;
  padding: 10px 16px;
  font-size: .68rem;
  font-weight: 600;
  letter-spacing: .04em;
  font-family: 'IBM Plex Sans Arabic', monospace;
}
.bp-title-block span:nth-child(2) { color: var(--hero-gold); }

.bp-tag {
  background: rgba(30,42,48,.8);
  color: #fff;
  font-size: .6rem;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 6px;
  letter-spacing: .03em;
  z-index: 3;
}
.bp-frame-mobile { position: relative; }

/* ===== قائمة الخدمات (Ledger) ===== */
.bp-ledger {
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 25px 50px -20px rgba(30,42,48,.18);
  border: 1px solid var(--hero-line);
  padding: 26px 30px;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}
.bp-ledger-item {
  position: relative;
  display: flex;
  align-items: center;
  gap: 12px;
  padding-inline-end: 16px;
}
.bp-ledger-item.has-divider { border-inline-end: 1px dashed var(--hero-line); }
.bp-ledger-index {
  position: absolute;
  top: -16px;
  inset-inline-start: 0;
  font-size: .62rem;
  font-weight: 800;
  color: rgba(82,105,112,.35);
  letter-spacing: .05em;
}
.bp-ledger-icon { background: rgba(245,173,42,.12); color: var(--hero-gold-dark); }
.bp-ledger-title { font-weight: 800; font-size: 1rem; color: var(--hero-teal); }
.bp-ledger-desc { font-size: .75rem; color: #9aa0a6; }

/* ===== حركة الدخول ===== */
.anim { opacity: 0; transform: translateY(16px); animation: heroIn .6s ease-out forwards; }
.anim-1 { animation-delay: .05s; }
.anim-2 { animation-delay: .15s; }
.anim-3 { animation-delay: .25s; }
.anim-4 { animation-delay: .35s; }
.anim-5 { animation-delay: .45s; }
@keyframes heroIn { to { opacity: 1; transform: translateY(0); } }

@media (prefers-reduced-motion: reduce) {
  .anim { animation: none; opacity: 1; transform: none; }
  .dim-line line, .dim-line path { animation: none; stroke-dashoffset: 0; }
}
</style>
