@if(count($whyAldiwan ?? []) > 0)
<section id="why-us" class="relative w-full py-16 md:py-24 overflow-hidden" style="background-color: rgb(241, 245, 247);">
  <div class="md:hidden px-5">
    <div class="why-reveal mb-8" x-data x-intersect.once="$el.classList.add('is-visible')">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 py-1.5 rounded-full text-xs font-bold mb-4">
        <i class="ri-question-line"></i> {{ __('home.why.badge') }}
      </div>
      <p class="text-3xl font-extrabold text-[var(--teal)] mb-3 leading-snug">{{ __('home.why.title') }}</p>
      <p class="text-lg font-bold text-[var(--gold-dark)] mb-3 leading-snug">{{ __('home.why.subtitle') }}</p>
      <div class="section-title-underline mb-4"></div>
      <p class="text-gray-500 text-sm leading-relaxed">{{ __('home.why.description') }}</p>
    </div>
    <div class="why-reveal relative mb-8" x-data x-intersect.once="$el.classList.add('is-visible')">
      <div class="absolute -top-4 -end-4 w-24 h-24 bg-[var(--gold)]/20 rounded-full blur-2xl"></div>
      <div class="absolute -bottom-4 -start-4 w-28 h-28 bg-[var(--teal)]/20 rounded-full blur-2xl"></div>
      <img src="https://files.catbox.moe/8jxeio.jpg" alt="{{ __('home.why.title') }}" class="relative rounded-3xl shadow-2xl w-full object-cover max-h-72">
    </div>
    <div class="space-y-5">
      @foreach($whyAldiwan as $why)
      <div class="why-reveal flex items-start gap-4" x-data x-intersect.once="$el.classList.add('is-visible')">
        <div class="w-11 h-11 rounded-2xl bg-[var(--gold)]/10 text-[var(--gold-dark)] flex items-center justify-center shrink-0"><i class="{{ $why['icon'] ?? 'ri-medal-line' }} text-lg"></i></div>
        <div>
          <h4 class="font-extrabold text-[var(--teal)] text-base mb-1">{{ $tr($why['title'] ?? []) }}</h4>
          <p class="text-gray-500 text-sm">{{ $tr($why['description'] ?? []) }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <div class="hidden md:block site-container">
    <div class="grid lg:grid-cols-2 gap-16 items-start">
      <div class="relative why-reveal lg:order-2 flex justify-start lg:ms-16 lg:mt-10" x-data x-intersect.once="$el.classList.add('is-visible')">
        <div class="absolute -top-6 -end-6 w-32 h-32 bg-[var(--gold)]/20 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-6 -start-6 w-40 h-40 bg-[var(--teal)]/20 rounded-full blur-2xl"></div>
        <img src="https://files.catbox.moe/3i7imq.webp" alt="{{ __('home.why.title') }}" class="relative rounded-3xl shadow-2xl w-auto max-w-full max-h-[520px]">
      </div>
      <div class="why-reveal lg:order-1" x-data x-intersect.once="$el.classList.add('is-visible')">
        <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-4 py-1.5 rounded-full text-sm font-bold mb-4">
          <i class="ri-question-line"></i> {{ __('home.why.badge') }}
        </div>
        <h2 class="text-3xl lg:text-4xl font-extrabold text-[var(--teal)] mb-3 leading-snug">{{ __('home.why.title') }}</h2>
        <p class="text-base lg:text-lg font-bold text-[var(--gold-dark)] mb-4 leading-snug">{{ __('home.why.subtitle') }}</p>
        <div class="section-title-underline mb-6"></div>
        <p class="text-gray-500 text-base font-normal mb-8 leading-relaxed">{{ __('home.why.description') }}</p>
        <div class="space-y-5">
          @foreach($whyAldiwan as $why)
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[var(--gold)]/10 text-[var(--gold-dark)] flex items-center justify-center shrink-0"><i class="{{ $why['icon'] ?? 'ri-medal-line' }} text-xl"></i></div>
            <div>
              <h4 class="font-extrabold text-[var(--teal)] text-lg mb-1">{{ $tr($why['title'] ?? []) }}</h4>
              <p class="text-gray-500">{{ $tr($why['description'] ?? []) }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@endif
