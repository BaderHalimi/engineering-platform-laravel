<section id="home" class="hero-modern relative w-full overflow-hidden min-h-screen flex items-center">

  {{-- الخلفية الهندسية --}}
  <div class="hero-bg-grid absolute inset-0 opacity-30" aria-hidden="true"></div>

  {{-- دوائر زخرفية خلفية --}}
  <div class="hero-orb hero-orb-1 absolute rounded-full" aria-hidden="true"></div>
  <div class="hero-orb hero-orb-2 absolute rounded-full" aria-hidden="true"></div>

  <div class="container relative z-10 mx-auto px-6 py-16 md:py-24">
    <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">

      {{-- المحتوى النصي --}}
      <div class="flex-1 text-center lg:text-right order-2 lg:order-1">

        {{-- الشارة --}}
        <div class="inline-flex items-center gap-3 bg-white/90 backdrop-blur-sm border border-[#E6E3DC] rounded-full px-5 py-2.5 mb-6 shadow-sm">
          <span class="w-2.5 h-2.5 rounded-full bg-[#f5ad2a] animate-pulse"></span>
          <span class="text-sm font-bold text-[#526970] tracking-wide">{{ __('home.hero.badge') }}</span>
        </div>

        {{-- العنوان --}}
        <h1 class="hero-headline font-bold leading-[1.1] mb-5">
          {!! __('home.hero.title') !!}
        </h1>

        {{-- الوصف --}}
        <p class="hero-description text-lg md:text-xl leading-relaxed mb-8 max-w-2xl lg:mx-0 mx-auto">
          {{ __('home.hero.subtitle') }}
        </p>

        {{-- الأزرار --}}
        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 mb-10">
          <a href="#contact" @click.prevent="document.querySelector('#contact').scrollIntoView({behavior:'smooth'})"
             class="btn-primary inline-flex items-center gap-2.5 px-8 py-4 rounded-full text-white font-bold text-base transition-all duration-300 hover:shadow-2xl hover:-translate-y-0.5">
            <span>{{ __('home.hero.cta') }}</span>
            <i class="ri-arrow-right-line text-xl"></i>
          </a>
          <a href="#projects" @click.prevent="document.querySelector('#projects').scrollIntoView({behavior:'smooth'})"
             class="btn-secondary inline-flex items-center gap-3 px-7 py-4 rounded-full font-bold text-base transition-all duration-300 hover:bg-[#526970] hover:text-white hover:border-[#526970]">
            <span class="w-9 h-9 rounded-full border-2 border-current flex items-center justify-center text-sm">
              <i class="ri-play-fill"></i>
            </span>
            {{ __('home.hero.watch_work') }}
          </a>
        </div>

        {{-- الإحصائيات --}}
        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-8 md:gap-12 pt-4 border-t border-[#E6E3DC]">
          <div class="text-center lg:text-right">
            <div class="text-3xl md:text-4xl font-black text-[#1E2A30]">+850</div>
            <div class="text-sm font-semibold text-[#8A9298] mt-0.5">{{ __('home.hero.stat_projects') }}</div>
          </div>
          <div class="text-center lg:text-right">
            <div class="text-3xl md:text-4xl font-black text-[#1E2A30]">+1200</div>
            <div class="text-sm font-semibold text-[#8A9298] mt-0.5">{{ __('home.hero.stat_licenses') }}</div>
          </div>
          <div class="text-center lg:text-right">
            <div class="text-3xl md:text-4xl font-black text-[#1E2A30]">98%</div>
            <div class="text-sm font-semibold text-[#8A9298] mt-0.5">{{ __('home.hero.stat_satisfaction') }}</div>
          </div>
        </div>
      </div>

      {{-- صورة الهيرو --}}
      <div class="flex-1 order-1 lg:order-2 w-full max-w-lg lg:max-w-none">
        <div class="relative hero-image-wrapper">

          {{-- إطار الصورة --}}
          <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white/80">
            <img src="{{ $heroImage }}" alt="{{ $siteName ?? '' }}" class="w-full h-auto object-cover aspect-[4/3]">

            {{-- تراكب متدرج --}}
            <div class="absolute inset-0 bg-gradient-to-t from-[#1E2A30]/60 via-transparent to-transparent"></div>

            {{-- علامات زوايا --}}
            <div class="absolute top-4 left-4 w-10 h-10 border-t-2 border-l-2 border-white/60 rounded-tl-lg"></div>
            <div class="absolute top-4 right-4 w-10 h-10 border-t-2 border-r-2 border-white/60 rounded-tr-lg"></div>
            <div class="absolute bottom-4 left-4 w-10 h-10 border-b-2 border-l-2 border-white/60 rounded-bl-lg"></div>
            <div class="absolute bottom-4 right-4 w-10 h-10 border-b-2 border-r-2 border-white/60 rounded-br-lg"></div>

            {{-- بطاقة المعلومات --}}
            <div class="absolute bottom-6 left-6 right-6 flex items-center justify-between">
              <div class="bg-white/95 backdrop-blur-md rounded-2xl px-5 py-3 shadow-xl border border-white/30">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-xl bg-[#f5ad2a]/15 flex items-center justify-center">
                    <i class="ri-file-chart-line text-[#f5ad2a] text-xl"></i>
                  </div>
                  <div>
                    <div class="text-xs font-bold text-[#526970] tracking-wider">DWG. HERO—01</div>
                    <div class="text-[10px] font-semibold text-[#8A9298]">REV. {{ date('y') }} · SCALE 1:1</div>
                  </div>
                </div>
              </div>

              <div class="bg-[#f5ad2a] text-white rounded-2xl px-4 py-3 shadow-xl flex items-center gap-2.5">
                <i class="ri-star-fill text-sm"></i>
                <span class="font-extrabold text-sm">98%</span>
              </div>
            </div>
          </div>

          {{-- عنصر زخرفي خلف الصورة --}}
          <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-[#f5ad2a]/10 rounded-3xl -z-10 hidden lg:block"></div>
          <div class="absolute -top-6 -left-6 w-32 h-32 border-2 border-[#f5ad2a]/20 rounded-full -z-10 hidden lg:block"></div>
        </div>
      </div>

    </div>
  </div>

  {{-- شريط الخدمات السفلي --}}
  @if(($services ?? collect())->count() >= 4)
  <div class="absolute bottom-0 left-0 right-0 hidden xl:block">
    <div class="container mx-auto px-6">
      <div class="services-strip bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-[#E6E3DC] px-8 py-5 -mb-8 grid grid-cols-4 gap-4">
        @foreach($services->take(4) as $svc)
        <div class="flex items-center gap-4 {{ !$loop->last ? 'border-r border-[#E6E3DC]' : '' }} pr-5 last:pr-0">
          <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background: rgba(245,173,42,0.12); color: #f5ad2a;">
            @if($svc->thumbnail ?? null)
              <img src="{{ $asset($svc->thumbnail) }}" class="w-full h-full object-cover rounded-2xl">
            @else
              <i class="{{ $svc->icon ?? 'ri-building-2-line' }} text-2xl"></i>
            @endif
          </div>
          <div class="min-w-0">
            <div class="text-sm font-extrabold text-[#1E2A30] truncate">{{ $tr(is_array($svc->title) ? $svc->title : ['ar'=>$svc->title]) }}</div>
            <div class="text-xs font-medium text-[#8A9298] truncate">{{ $tr(is_array($svc->short_description ?? null) ? $svc->short_description : ['ar'=>$svc->short_description ?? '']) }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @endif

</section>

<style>
/* ===== الهوية اللونية ===== */
:root {
  --hero-teal: #526970;
  --hero-teal-dark: #3d5258;
  --hero-gold: #f5ad2a;
  --hero-gold-dark: #dc9415;
  --hero-ink: #1E2A30;
  --hero-line: #E6E3DC;
}

/* ===== الخلفية ===== */
.hero-modern {
  background: #fafaf8;
  min-height: 100vh;
}

/* ===== شبكة الخلفية ===== */
.hero-bg-grid {
  background-image:
    linear-gradient(rgba(82,105,112,0.06) 1px, transparent 1px),
    linear-gradient(90deg, rgba(82,105,112,0.06) 1px, transparent 1px);
  background-size: 40px 40px;
  mask-image: radial-gradient(ellipse at 70% 50%, black 30%, transparent 70%);
  -webkit-mask-image: radial-gradient(ellipse at 70% 50%, black 30%, transparent 70%);
}

/* ===== الكرات الزخرفية ===== */
.hero-orb {
  border-radius: 50%;
  filter: blur(80px);
  pointer-events: none;
}
.hero-orb-1 {
  width: 600px;
  height: 600px;
  top: -200px;
  right: -100px;
  background: rgba(245,173,42,0.08);
}
.hero-orb-2 {
  width: 400px;
  height: 400px;
  bottom: -100px;
  left: -100px;
  background: rgba(82,105,112,0.06);
}

/* ===== العنوان ===== */
.hero-headline {
  font-size: clamp(2.5rem, 6vw, 4.8rem);
  color: var(--hero-ink);
}
.hero-headline span {
  color: var(--hero-teal);
  position: relative;
}
.hero-headline span::after {
  content: '';
  position: absolute;
  bottom: 4px;
  left: 0;
  right: 0;
  height: 6px;
  background: rgba(245,173,42,0.3);
  border-radius: 4px;
}

/* ===== الوصف ===== */
.hero-description {
  color: #5A6770;
  font-weight: 400;
}

/* ===== الأزرار ===== */
.btn-primary {
  background: linear-gradient(135deg, var(--hero-teal), var(--hero-teal-dark));
  box-shadow: 0 8px 24px rgba(82,105,112,0.3);
}
.btn-primary:hover {
  box-shadow: 0 12px 36px rgba(82,105,112,0.4);
  transform: translateY(-2px);
}

.btn-secondary {
  background: transparent;
  color: var(--hero-teal);
  border: 2px solid var(--hero-line);
}
.btn-secondary:hover {
  background: var(--hero-teal);
  color: #fff;
  border-color: var(--hero-teal);
}

/* ===== صورة الهيرو ===== */
.hero-image-wrapper {
  perspective: 1000px;
}
.hero-image-wrapper > div:first-child {
  transform: rotateY(-3deg) rotateX(2deg);
  transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
}
.hero-image-wrapper:hover > div:first-child {
  transform: rotateY(0deg) rotateX(0deg);
}

/* ===== شريط الخدمات ===== */
.services-strip {
  transform: translateY(50%);
  box-shadow: 0 20px 60px rgba(30,42,48,0.08);
}
.services-strip > div:last-child {
  border-right: none !important;
  padding-right: 0 !important;
}

/* ===== استجابة ===== */
@media (max-width: 1023px) {
  .services-strip {
    display: none;
  }
  .hero-modern {
    min-height: auto;
    padding: 2rem 0 4rem;
  }
}

@media (max-width: 767px) {
  .hero-headline {
    font-size: 2.2rem;
  }
  .hero-headline span::after {
    height: 4px;
    bottom: 2px;
  }
  .hero-description {
    font-size: 1rem;
  }
  .btn-primary, .btn-secondary {
    padding: 0.75rem 1.5rem;
    font-size: 0.9rem;
  }
}

/* ===== حركات ===== */
.hero-modern * {
  animation-fill-mode: both;
}
.hero-headline {
  animation: fadeUp 0.8s 0.1s ease-out both;
}
.hero-description {
  animation: fadeUp 0.8s 0.2s ease-out both;
}
.hero-modern .inline-flex:first-child {
  animation: fadeUp 0.8s 0s ease-out both;
}
.hero-modern .flex-wrap {
  animation: fadeUp 0.8s 0.3s ease-out both;
}
.hero-modern .border-t {
  animation: fadeUp 0.8s 0.4s ease-out both;
}
.hero-image-wrapper > div:first-child {
  animation: fadeIn 1s 0.2s ease-out both;
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
  from { opacity: 0; transform: rotateY(-6deg) rotateX(3deg) scale(0.96); }
  to { opacity: 1; transform: rotateY(-3deg) rotateX(2deg) scale(1); }
}

@media (prefers-reduced-motion: reduce) {
  .hero-modern * {
    animation: none !important;
    opacity: 1 !important;
    transform: none !important;
  }
}
</style>
