@php
  use App\Models\Setup;

  $locale = app()->getLocale();
  $siteName = Setup::get('site_name', config('app.name'));
  $heroSliderEnabled = (bool) Setup::get('hero_slider_enabled', true);
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

@if($heroSliderEnabled && $slides->isNotEmpty())
<section
  id="home"
  class="home-hero-slider relative overflow-hidden bg-[#11191d]"
  x-data="{ active: 0, total: {{ $slides->count() }}, timer: null, start() { this.timer = setInterval(() => this.active = (this.active + 1) % this.total, 5000) }, stop() { if (this.timer) clearInterval(this.timer) } }"
  x-init="start()"
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
      <div class="absolute inset-0 bg-gradient-to-l from-[#11191d]/72 via-[#11191d]/38 to-[#11191d]/14"></div>
      <div class="absolute inset-0 home-slider-grid"></div>
    </div>
  @endforeach

  <div class="site-container relative z-10 flex min-h-[560px] items-center pt-32 pb-28 md:min-h-[620px] md:pt-36 md:pb-32 lg:min-h-[680px] lg:pt-40 lg:pb-36">
    @foreach($slides as $index => $slide)
      @php
        $title = $trSlide($slide, 'title');
        $description = $trSlide($slide, 'description');
        $buttonText = $trSlide($slide, 'button_text');
        $buttonUrl = $slide['button_url'] ?? '';
      @endphp
      <div
        class="max-w-3xl text-white"
        x-show="active === {{ $index }}"
        x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0 translate-y-8"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-cloak
      >
        <div class="inline-flex items-center gap-3 rounded-full border border-white/20 bg-white/10 px-4 md:px-5 py-2 md:py-2.5 text-xs md:text-sm font-bold backdrop-blur-md mb-5">
          <span class="h-2.5 w-2.5 rounded-full bg-[var(--gold)]"></span>
          {{ __('home.hero.badge') }}
        </div>
        @if($title && $index === 0)
          <h1 class="hero-slider-title max-w-3xl font-black text-white mb-5">{{ $title }}<span class="sr-only"> - {{ $siteName }}</span></h1>
        @elseif($title)
          <p class="hero-slider-title max-w-3xl font-black text-white mb-5">{{ $title }}</p>
        @endif
        @if($description)
          <p class="max-w-2xl text-sm md:text-base lg:text-lg font-normal leading-8 text-white/86 mb-6">{{ $description }}</p>
        @endif
        <div class="flex flex-wrap items-center gap-4">
          @if($buttonText && $buttonUrl)
            <a href="{{ $buttonUrl }}" class="inline-flex items-center gap-2 rounded-full bg-[var(--gold)] px-6 md:px-8 py-3 md:py-3.5 text-sm md:text-base font-bold text-white shadow-lg shadow-black/25 transition hover:-translate-y-1 hover:shadow-xl">
              {{ $buttonText }}
              <i class="ri-arrow-left-line rtl:inline ltr:hidden"></i><i class="ri-arrow-right-line ltr:inline rtl:hidden"></i>
            </a>
          @endif
          <a href="{{ route('home_pages.services.index') }}" class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-6 md:px-8 py-3 md:py-3.5 text-sm md:text-base font-medium text-white backdrop-blur-md transition hover:-translate-y-1 hover:bg-white hover:text-[var(--teal)]">
            {{ __('home.nav.services') }}
          </a>
        </div>
      </div>
    @endforeach
  </div>

  @if($slides->count() > 1)
    <div class="absolute bottom-5 md:bottom-8 left-0 right-0 z-20">
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
          <button type="button" @click="active = (active - 1 + total) % total" class="h-12 w-12 rounded-full border border-white/30 bg-white/18 text-white shadow-lg shadow-black/20 backdrop-blur-md transition hover:bg-white hover:text-[var(--teal)]"><i class="ri-arrow-right-line text-xl"></i></button>
          <button type="button" @click="active = (active + 1) % total" class="h-12 w-12 rounded-full border border-white/30 bg-white/18 text-white shadow-lg shadow-black/20 backdrop-blur-md transition hover:bg-white hover:text-[var(--teal)]"><i class="ri-arrow-left-line text-xl"></i></button>
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
    min-height: clamp(560px, 76svh, 740px);
  }
  .hero-slider-title {
    font-size: clamp(2.2rem, 4.8vw, 4.25rem);
    line-height: 1.22;
    text-wrap: balance;
  }
  .hero-slide-media {
    object-fit: cover;
    object-position: center center;
  }
  @media (max-width: 900px) {
    .home-hero-slider {
      min-height: 600px;
    }
    .hero-slide-media {
      object-fit: contain;
      object-position: left bottom;
      background: #11191d;
    }
    [dir="ltr"] .hero-slide-media {
      object-position: right bottom;
    }
  }
  @media (max-width: 640px) {
    .home-hero-slider {
      min-height: 620px;
    }
    .hero-slider-title {
      font-size: clamp(2rem, 10vw, 3.1rem);
    }
    .hero-slide-media {
      object-fit: cover;
      opacity: .72;
    }
  }
</style>
@endif
