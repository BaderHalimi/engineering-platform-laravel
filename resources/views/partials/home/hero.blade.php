<section id="home" class="relative w-full overflow-hidden pt-6 md:pt-0">
  <div class="blob hidden md:block" style="width:380px;height:380px;background:var(--gold);top:80px;inset-inline-end:-100px;"></div>
  <div class="blob hidden md:block" style="width:300px;height:300px;background:var(--teal-light);bottom:60px;inset-inline-start:-80px;opacity:.15;"></div>
  <div class="absolute inset-0 geo-pattern opacity-50 hidden md:block"></div>

  {{-- صورة الهيرو (تظهر الآن دائماً - كانت تعتمد خطأً على شعار الموقع) --}}
  <div class="md:hidden px-5">
    <div class="relative rounded-3xl overflow-hidden shadow-xl mb-5">
      <img src="{{ $heroImage }}" alt="{{ $siteName ?? '' }}" class="w-full h-64 object-cover">
      <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(30,42,48,0.35), transparent 50%);"></div>
      <div class="absolute bottom-4 end-4 bg-white/95 backdrop-blur rounded-2xl px-4 py-2 flex items-center gap-2 shadow-lg">
        <i class="ri-trophy-fill text-[var(--gold)] text-xl"></i>
        <div>
          <div class="font-extrabold text-[var(--teal)] text-xs">{{ __('home.hero.projects_count') }}</div>
          <div class="text-[10px] text-gray-500">{{ __('home.hero.projects_done') }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="container mx-auto px-5 md:px-6 md:h-full md:flex md:items-center relative z-20">
    <div class="md:max-w-2xl text-start md:mt-24 md:ms-auto">
      <div class="inline-flex items-center gap-2 bg-white border border-[var(--gold)]/30 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 md:py-2 rounded-full text-xs md:text-sm font-bold mb-4 md:mb-6 shadow-sm">
        <span class="w-2 h-2 bg-[var(--gold)] rounded-full pulse-ring"></span>
        <span class="md:inline">{{ __('home.hero.badge') }}</span>
      </div>

      @if($siteLogo)
        <img src="{{ $asset($siteLogo) }}" alt="{{ $siteName ?? '' }}" class="mb-4 md:mb-6 hidden md:block" style="height:70px;">
      @endif

      <h1 class="font-extrabold leading-tight mb-3 md:mb-6 text-4xl md:text-7xl" style="color:var(--teal);">
        {!! __('home.hero.title') !!}
      </h1>

      <p class="text-gray-600 leading-relaxed mb-5 md:mb-8 text-sm md:text-2xl" style="max-width:580px;">
        {{ __('home.hero.subtitle') }}
      </p>

      <div class="flex items-center justify-start gap-3 md:gap-4 mb-6 md:mb-10">
        <a href="#contact" @click.prevent="document.querySelector('#contact').scrollIntoView({behavior:'smooth'})" class="btn-primary w-full md:w-auto text-sm md:text-lg font-bold rounded-full flex items-center justify-center md:justify-start gap-2" style="padding:.9rem 1.5rem;">
          <span>{{ __('home.hero.cta') }}</span>
          <i class="ri-arrow-left-line rtl:inline ltr:hidden text-base md:text-xl"></i>
          <i class="ri-arrow-right-line ltr:inline rtl:hidden text-base md:text-xl"></i>
        </a>
        <a href="#projects" @click.prevent="document.querySelector('#projects').scrollIntoView({behavior:'smooth'})" class="hidden md:flex bg-white border-2 border-[var(--teal)]/20 text-[var(--teal)] hover:border-[var(--teal)] text-lg font-bold rounded-full items-center gap-2 transition" style="padding:.9rem 2rem;">
          <i class="ri-play-circle-fill text-2xl text-[var(--gold)]"></i> {{ __('home.hero.watch_work') }}
        </a>
      </div>

      <div class="grid grid-cols-3 md:flex md:items-center gap-3 md:gap-8 text-center md:text-start">
        <div class="bg-white md:bg-transparent border md:border-0 border-gray-100 rounded-2xl md:rounded-none p-3 md:p-0">
          <div class="text-xl md:text-3xl font-black text-[var(--teal)]">+850</div>
          <div class="text-[10px] md:text-sm text-gray-500 font-bold">{{ __('home.hero.stat_projects') }}</div>
        </div>
        <div class="hidden md:block w-px h-10 bg-gray-200"></div>
        <div class="bg-white md:bg-transparent border md:border-0 border-gray-100 rounded-2xl md:rounded-none p-3 md:p-0">
          <div class="text-xl md:text-3xl font-black text-[var(--teal)]">+1200</div>
          <div class="text-[10px] md:text-sm text-gray-500 font-bold">{{ __('home.hero.stat_licenses') }}</div>
        </div>
        <div class="hidden md:block w-px h-10 bg-gray-200"></div>
        <div class="bg-white md:bg-transparent border md:border-0 border-gray-100 rounded-2xl md:rounded-none p-3 md:p-0">
          <div class="text-xl md:text-3xl font-black text-[var(--teal)]">98%</div>
          <div class="text-[10px] md:text-sm text-gray-500 font-bold">{{ __('home.hero.stat_satisfaction') }}</div>
        </div>
      </div>
    </div>

    {{-- صورة الهيرو - ديسكتوب --}}
    <div class="hidden md:block relative w-[38%] shrink-0">
      <img src="{{ $heroImage }}" alt="{{ $siteName ?? '' }}" class="w-full h-[520px] object-cover rounded-3xl shadow-2xl">
    </div>
  </div>

  {{-- Bottom services bar (desktop only) --}}
  @if(($services ?? collect())->count() >= 4)
  <div class="hidden lg:block relative z-30 mt-10">
    <div class="container mx-auto px-6">
      <div class="bg-white rounded-2xl shadow-2xl shadow-gray-300/40 border border-gray-100 px-8 py-6 grid grid-cols-4 gap-4">
        @foreach($services->take(4) as $svc)
        <div class="flex items-center gap-3 justify-start text-start {{ ! $loop->last ? 'border-e border-gray-100 pe-4' : '' }}">
          <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 overflow-hidden" style="background:rgba(245,173,42,.12);">
            @if($svc->thumbnail ?? null)
              <img src="{{ $asset($svc->thumbnail) }}" class="w-full h-full object-cover">
            @else
              <i class="{{ $svc->icon ?? 'ri-building-2-line' }} text-xl" style="color:var(--gold-dark);"></i>
            @endif
          </div>
          <div>
            <div class="font-bold text-base" style="color:var(--teal);">{{ $tr(is_array($svc->title) ? $svc->title : ['ar'=>$svc->title]) }}</div>
            <div class="text-xs text-gray-400">{{ $tr(is_array($svc->short_description ?? null) ? $svc->short_description : ['ar'=>$svc->short_description ?? '']) }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @endif
</section>
