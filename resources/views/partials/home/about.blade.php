@php
  $aboutItems = collect($aboutUs ?? [])->values();
  $aboutMain = $aboutItems->first();
  $aboutFeatures = $aboutItems->slice(1)->values();
  $aboutFeatureIcons = [
    'ri-building-2-line',
    'ri-shield-check-line',
    'ri-customer-service-2-line',
    'ri-compasses-2-line',
  ];
@endphp

@if($aboutItems->isNotEmpty())
<section id="about" class="relative w-full overflow-hidden bg-white py-16 md:py-24 font-body">
  <div class="absolute inset-0 blueprint-grid pointer-events-none"></div>
  <div class="absolute -top-24 -start-24 h-72 w-72 rounded-full bg-[var(--gold)]/10 blur-3xl pointer-events-none"></div>

  <div class="site-container relative z-10">
    <div class="grid items-center gap-10 lg:grid-cols-[0.92fr_1.08fr] lg:gap-16" dir="ltr">
      <div
        x-data
        x-intersect.once="$el.classList.add('is-visible')"
        class="reveal order-2 lg:order-1"
      >
        <div class="relative overflow-hidden rounded-3xl border border-white shadow-2xl shadow-[rgba(82,105,112,.12)]">
          <img
            src="https://files.catbox.moe/3i7imq.webp"
            alt="{{ $siteName }} - {{ $tr($aboutMain['title'] ?? ['ar' => 'من نحن']) }}"
            class="h-[340px] w-full object-cover md:h-[520px]"
          >
        </div>
      </div>

      <div class="order-1 lg:order-2 text-start" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" style="color:var(--teal);">
        <div
          x-data
          x-intersect.once="$el.classList.add('is-visible')"
          class="reveal mb-8"
        >
          <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-[var(--gold)]/10 px-4 py-1.5 text-xs md:text-sm font-bold text-[var(--gold-dark)]">
            <i class="ri-information-line"></i>
            {{ $tr($aboutMain['label'] ?? ['ar' => 'من نحن']) }}
          </div>

          <h2 class="text-4xl md:text-5xl font-bold leading-tight">
            {{ $tr($aboutMain['title'] ?? ['ar' => 'من نحن']) }}
          </h2>

          <p class="mt-3 text-xl md:text-2xl font-medium leading-relaxed text-[var(--gold-dark)]">
            {{ $siteName }}
          </p>

          <div class="section-title-underline mt-5 mb-8"></div>

          @if(filled($tr($aboutMain['description'] ?? [])))
            <p class="max-w-3xl text-base md:text-lg font-medium leading-9 text-gray-500">
              {{ $tr($aboutMain['description'] ?? []) }}
            </p>
          @endif
        </div>

        @if($aboutFeatures->isNotEmpty())
          <div class="space-y-6">
            @foreach($aboutFeatures as $i => $card)
              <div
                x-data
                x-intersect.once="$el.classList.add('is-visible')"
                class="reveal reveal-delay-{{ min($i + 1, 3) }} flex items-start gap-4"
              >
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[var(--gold)]/10 text-2xl text-[var(--gold-dark)]">
                  <i class="{{ $card['icon'] ?? $aboutFeatureIcons[$i % count($aboutFeatureIcons)] }}"></i>
                </div>

                <div>
                  <h3 class="text-xl md:text-2xl font-bold leading-snug text-[var(--teal)]">
                    {{ $tr($card['title'] ?? $card['label'] ?? []) }}
                  </h3>

                  @if(filled($tr($card['description'] ?? [])))
                    <p class="mt-1 text-sm md:text-base font-medium leading-8 text-gray-500">
                      {{ $tr($card['description'] ?? []) }}
                    </p>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endif
