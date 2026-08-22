<section id="trust" class="relative w-full py-16 md:py-24 bg-white overflow-hidden">
  <div class="absolute inset-0 blueprint-grid pointer-events-none"></div>
  <div class="blob hidden md:block" style="width:340px;height:340px;background:var(--gold);bottom:-60px;inset-inline-start:-60px;opacity:.07;"></div>

  <div class="site-container relative z-10">
    <div class="grid items-center gap-12 lg:grid-cols-[1fr_1.1fr] lg:gap-20">

      {{-- ===== الجانب النصي ===== --}}
      <div class="reveal" x-data x-intersect.once="$el.classList.add('is-visible')">
        <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-5">
          <i class="ri-shield-check-line"></i> {{ __('home.trust.badge') }}
        </div>
        <h2 class="text-3xl md:text-4xl font-extrabold text-[var(--teal)] leading-snug mb-4">
          {{ __('home.trust.title') }}
        </h2>
        <div class="section-title-underline mb-6"></div>
        <p class="text-base font-normal leading-relaxed text-gray-500 max-w-md">
          {{ __('home.trust.description') }}
        </p>
      </div>

      {{-- ===== نقاط الثقة ===== --}}
      <div class="grid grid-cols-1 gap-4">
        @foreach(__('home.trust.points') as $i => $point)
        <div
          class="reveal reveal-delay-{{ min($i, 3) }} flex items-start gap-4 rounded-2xl border border-[var(--line)] bg-[var(--bg-soft)] px-5 py-4 transition hover:border-[var(--gold)]/50 hover:shadow-md hover:shadow-[rgba(245,173,42,.08)]"
          x-data x-intersect.once="$el.classList.add('is-visible')"
        >
          <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[var(--gold)] text-white shadow-md shadow-[rgba(245,173,42,.30)]">
            <i class="ri-check-line text-lg font-bold"></i>
          </div>
          <div class="pt-1">
            <p class="text-base font-bold text-[var(--teal)] leading-snug">{{ $point }}</p>
          </div>
        </div>
        @endforeach
      </div>

    </div>
  </div>
</section>
