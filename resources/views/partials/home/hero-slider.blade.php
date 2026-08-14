@php
  $locale = app()->getLocale();
  $slides = collect($heroSlides ?? [])
    ->filter(fn ($slide) => filled($slide['media_path'] ?? null))
    ->values();

  $trSlide = function (array $slide, string $field) use ($locale) {
      $value = $slide[$field] ?? '';
      if (is_array($value)) {
          return $value[$locale] ?? $value['ar'] ?? (reset($value) ?: '');
      }
      return $value ?: '';
  };

  $mediaUrl = function (string $path) {
      if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
          return $path;
      }

      return asset('storage/' . ltrim($path, '/'));
  };
@endphp

@if($slides->isNotEmpty())
<section
  id="home"
  class="home-hero-slider relative overflow-hidden bg-[#11191d]"
  x-data="{ active: 0, total: {{ $slides->count() }}, timer: null, start() { this.timer = setInterval(() => this.active = (this.active + 1) % this.total, 6500) }, stop() { if (this.timer) clearInterval(this.timer) } }"
  x-init="start()"
  @mouseenter="stop()"
  @mouseleave="start()"
>
  @foreach($slides as $index => $slide)
    @php
      $type = $slide['type'] ?? 'image';
      $url = $mediaUrl($slide['media_path']);
      $title = $trSlide($slide, 'title');
      $description = $trSlide($slide, 'description');
      $buttonText = $trSlide($slide, 'button_text');
      $buttonUrl = $slide['button_url'] ?? '';
    @endphp

    <div
      class="absolute inset-0 transition-opacity duration-1000"
      x-show="active === {{ $index }}"
      x-transition.opacity
      x-cloak
    >
      @if($type === 'video')
        <video class="hero-slide-media absolute inset-0 h-full w-full" autoplay muted loop playsinline>
          <source src="{{ $url }}">
        </video>
      @else
        <img src="{{ $url }}" alt="{{ $title }}" class="hero-slide-media absolute inset-0 h-full w-full">
      @endif
      <div class="absolute inset-0 bg-gradient-to-l from-[#11191d]/92 via-[#11191d]/68 to-[#11191d]/28"></div>
      <div class="absolute inset-0 home-slider-grid"></div>
    </div>
  @endforeach

  <div class="site-container relative z-10 flex min-h-[560px] items-center py-24 md:min-h-[640px] md:py-28 lg:min-h-[690px] lg:py-32">
    @foreach($slides as $index => $slide)
      @php
        $title = $trSlide($slide, 'title');
        $description = $trSlide($slide, 'description');
        $buttonText = $trSlide($slide, 'button_text');
        $buttonUrl = $slide['button_url'] ?? '';
      @endphp
      <div
        class="hero-slide-content max-w-[680px] text-white"
        x-show="active === {{ $index }}"
        x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0 translate-y-8"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-cloak
      >
        <div class="mb-5 inline-flex items-center gap-3 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-bold backdrop-blur-md md:px-5 md:py-2.5 md:text-sm">
          <span class="h-2.5 w-2.5 rounded-full bg-[var(--gold)]"></span>
          {{ __('home.hero.badge') }}
        </div>
        @if($title)
          <h1 class="mb-5 max-w-[720px] text-4xl font-black leading-[1.18] md:text-5xl lg:text-6xl">{{ $title }}</h1>
        @endif
        @if($description)
          <p class="mb-7 max-w-[560px] text-base leading-8 text-white/82 md:text-lg">{{ $description }}</p>
        @endif
        <div class="flex flex-wrap items-center gap-4">
          @if($buttonText && $buttonUrl)
            <a href="{{ $buttonUrl }}" class="inline-flex items-center gap-2 rounded-full bg-[var(--gold)] px-6 py-3.5 text-sm font-extrabold text-white shadow-2xl shadow-black/20 transition hover:-translate-y-0.5 md:px-8 md:py-4 md:text-base">
              {{ $buttonText }}
              <i class="ri-arrow-left-line rtl:inline ltr:hidden"></i><i class="ri-arrow-right-line ltr:inline rtl:hidden"></i>
            </a>
          @endif
          <a href="{{ route('home_pages.services.index') }}" class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-6 py-3.5 text-sm font-bold text-white backdrop-blur-md transition hover:bg-white hover:text-[var(--teal)] md:px-7 md:py-4 md:text-base">
            {{ __('home.nav.services') }}
          </a>
        </div>
      </div>
    @endforeach
  </div>

  @if($slides->count() > 1)
    <div class="absolute bottom-8 left-0 right-0 z-20">
      <div class="site-container flex items-center justify-between gap-4">
        <div class="flex items-center gap-2">
          @foreach($slides as $index => $slide)
            <button
              type="button"
              @click="active = {{ $index }}"
              class="h-2.5 rounded-full bg-white/45 transition-all"
              :class="active === {{ $index }} ? 'w-10 bg-[var(--gold)]' : 'w-2.5'"
              aria-label="Slide {{ $index + 1 }}"
            ></button>
          @endforeach
        </div>
        <div class="flex items-center gap-2">
          <button type="button" @click="active = (active - 1 + total) % total" class="h-11 w-11 rounded-full border border-white/25 bg-white/10 text-white backdrop-blur-md transition hover:bg-white hover:text-[var(--teal)]"><i class="ri-arrow-right-line"></i></button>
          <button type="button" @click="active = (active + 1) % total" class="h-11 w-11 rounded-full border border-white/25 bg-white/10 text-white backdrop-blur-md transition hover:bg-white hover:text-[var(--teal)]"><i class="ri-arrow-left-line"></i></button>
        </div>
      </div>
    </div>
  @endif
</section>

<style>
  .home-slider-grid {
    background-image:
      linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px);
    background-size: 42px 42px;
    mask-image: linear-gradient(to bottom, black, transparent 86%);
  }
  .home-hero-slider {
    min-height: clamp(560px, 76vh, 760px);
  }
  .hero-slide-media {
    object-fit: contain;
    object-position: left bottom;
    transform: scale(.92);
    transform-origin: left bottom;
  }
  [dir="rtl"] .hero-slide-media {
    object-position: left bottom;
    transform-origin: left bottom;
  }
  [dir="ltr"] .hero-slide-media {
    object-position: right bottom;
    transform-origin: right bottom;
  }
  .hero-slide-content {
    margin-inline-start: auto;
  }
  [dir="ltr"] .hero-slide-content {
    margin-inline-start: 0;
    margin-inline-end: auto;
  }
  @media (max-width: 767px) {
    .home-hero-slider {
      min-height: 620px;
    }
    .hero-slide-media {
      object-fit: cover;
      object-position: center bottom;
      transform: none;
      opacity: .72;
    }
    .hero-slide-content,
    [dir="ltr"] .hero-slide-content {
      margin-inline: 0;
      max-width: 100%;
    }
  }
</style>
@endif
