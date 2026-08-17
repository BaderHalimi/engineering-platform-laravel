<section id="madinah" class="relative w-full overflow-hidden bg-[var(--bg-soft)]">

  {{-- زخرفة شبكة هندسية خفيفة --}}
  <div class="absolute inset-0 pointer-events-none" style="
    background-image:
      linear-gradient(rgba(82,105,112,.05) 1px, transparent 1px),
      linear-gradient(90deg, rgba(82,105,112,.05) 1px, transparent 1px);
    background-size: 40px 40px;
    mask-image: radial-gradient(ellipse 85% 70% at 30% 50%, black 0%, transparent 80%);
  "></div>

  {{-- كرة ضوء ذهبية --}}
  <div class="blob hidden md:block" style="width:380px;height:380px;background:var(--gold);top:-60px;inset-inline-end:-80px;opacity:.08;"></div>
  <div class="blob hidden md:block" style="width:200px;height:200px;background:var(--teal);bottom:-40px;inset-inline-start:10%;opacity:.06;"></div>

  <div class="site-container relative z-10">
    <div class="grid items-center gap-0 lg:grid-cols-2" dir="ltr">

      {{-- ===== الجانب الأيسر: الصورة ===== --}}
      <div class="reveal order-2 lg:order-1 flex items-center justify-center py-12 lg:py-16"
           x-data x-intersect.once="$el.classList.add('is-visible')">
        <div class="relative overflow-hidden rounded-3xl border border-white shadow-2xl shadow-[rgba(82,105,112,.12)] w-full">
          <img
            src="https://files.catbox.moe/3i7imq.webp"
            alt="{{ $siteName ?? '' }} — {{ __('home.madinah.title') }}"
            class="h-[340px] w-full object-cover md:h-[520px]"
            style="object-position: center center;"
          >
          {{-- badge موقع --}}
          <div class="absolute bottom-5 start-5 inline-flex items-center gap-2 rounded-full bg-black/40 backdrop-blur-md border border-white/20 px-4 py-2 text-xs font-bold text-white">
            <i class="ri-map-pin-2-fill text-[var(--gold)]"></i>
            {{ __('home.madinah.badge') }}
          </div>
        </div>
      </div>

      {{-- ===== الجانب الأيمن: المحتوى ===== --}}
      <div class="reveal order-1 lg:order-2 py-16 md:py-20 lg:py-24 px-0 lg:px-12"
           dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
           x-data x-intersect.once="$el.classList.add('is-visible')">

        <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-5">
          <i class="ri-compasses-2-line"></i>
          {{ __('home.madinah.eyebrow') }}
        </div>

        <h2 class="text-3xl md:text-4xl font-extrabold leading-snug mb-4 text-[var(--teal)]">
          {{ __('home.madinah.title') }}
        </h2>

        <div class="section-title-underline mb-6"></div>

        <p class="text-base md:text-lg font-normal leading-relaxed text-gray-500 mb-4 max-w-lg">
          {{ __('home.madinah.description1') }}
        </p>
        <p class="text-sm md:text-base font-normal leading-relaxed text-gray-400 mb-8 max-w-lg">
          {{ __('home.madinah.description2') }}
        </p>

        {{-- الأيقونات --}}
        <div class="flex flex-wrap gap-3 mb-8">
          @foreach(['ri-pencil-ruler-2-line' => __('home.madinah.tag_design'), 'ri-file-list-3-line' => __('home.madinah.tag_permits'), 'ri-shield-check-line' => __('home.madinah.tag_safety'), 'ri-building-2-line' => __('home.madinah.tag_supervision')] as $icon => $label)
          <span class="madinah-tag inline-flex items-center gap-2 rounded-full border border-[var(--line)] bg-white px-4 py-2 text-sm font-medium text-[var(--teal-dark)]"
                style="animation-delay: {{ $loop->index * 110 }}ms">
            <i class="{{ $icon }} text-base text-[var(--gold-dark)]"></i> {{ $label }}
          </span>
          @endforeach
        </div>

        {{-- الأزرار --}}
        <div class="flex flex-wrap items-center gap-3">
          @if(filled($sitePhone ?? ''))
          <a href="https://wa.me/{{ preg_replace('/\D/', '', $sitePhone ?? '') }}"
             target="_blank" rel="noopener noreferrer"
             class="inline-flex items-center gap-2 rounded-full bg-[#25D366] px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-black/10 transition hover:-translate-y-1 hover:shadow-xl">
            <i class="ri-whatsapp-line text-base"></i>
            {{ __('home.madinah.cta_whatsapp') }}
          </a>
          @endif
          <a href="{{ route('home_pages.services.index') }}"
             class="inline-flex items-center gap-2 rounded-full border border-[var(--teal)]/30 bg-transparent px-6 py-3.5 text-sm font-bold text-[var(--teal)] transition hover:-translate-y-1 hover:bg-[var(--teal)] hover:text-white hover:border-[var(--teal)]">
            {{ __('home.madinah.cta_services') }}
            <i class="ri-arrow-left-line rtl:inline ltr:hidden"></i><i class="ri-arrow-right-line ltr:inline rtl:hidden"></i>
          </a>
        </div>

      </div>
    </div>
  </div>
</section>

<style>
  @keyframes madinah-tag-in {
    from { opacity: 0; transform: translateY(10px) scale(.95); }
    to   { opacity: 1; transform: translateY(0)   scale(1);    }
  }
  .madinah-tag {
    opacity: 0;
    animation: madinah-tag-in .45s cubic-bezier(.2,.8,.2,1) forwards;
    transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
  }
  .madinah-tag:hover {
    transform: translateY(-3px) scale(1.04);
    border-color: var(--gold);
    box-shadow: 0 8px 20px -8px rgba(245,173,42,.35);
  }
  .madinah-tag i {
    transition: transform .35s cubic-bezier(.2,.8,.2,1);
  }
  .madinah-tag:hover i {
    transform: rotate(-12deg) scale(1.2);
  }
  @media (prefers-reduced-motion: reduce) {
    .madinah-tag { animation: none; opacity: 1; }
    .madinah-tag:hover { transform: none; }
  }
</style>
