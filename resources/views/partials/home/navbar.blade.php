{{-- Nav: desktop (md+) --}}
@php
  $floating = $floating ?? false;
  $navAvailability = array_merge([
      'services' => true,
      'projects' => true,
      'about' => true,
      'articles' => true,
      'media' => true,
      'faqs' => true,
      'contact' => true,
  ], $navAvailability ?? []);
  $isHomePage = request()->routeIs('home');
  $sectionHref = fn (string $section) => $isHomePage ? '#' . $section : route('home') . '#' . $section;
  $sectionClick = fn (string $section) => $isHomePage
      ? "activeSection = '{$section}'; document.querySelector('#{$section}')?.scrollIntoView({behavior:'smooth'})"
      : null;
  $navItems = [
      ['key' => 'home', 'label' => __('home.nav.home'), 'href' => route('home'), 'route' => 'home', 'section' => null],
      ['key' => 'services', 'label' => __('home.nav.services'), 'href' => route('home_pages.services.index'), 'route' => 'home_pages.services.*', 'section' => null],
      ['key' => 'projects', 'label' => __('home.nav.projects'), 'href' => route('home_pages.projects.index'), 'route' => 'home_pages.projects.*', 'section' => null],
      ['key' => 'about', 'label' => __('home.nav.about'), 'href' => route('home_pages.aboutus'), 'route' => 'home_pages.aboutus', 'section' => null],
      ['key' => 'articles', 'label' => __('home.nav.articles'), 'href' => $sectionHref('articles'), 'route' => 'home_pages.articles.*', 'section' => 'articles'],
      ['key' => 'media', 'label' => __('home.nav.media'), 'href' => route('home_pages.media.index'), 'route' => 'home_pages.media.*|home_pages.images.*|home_pages.videos.*|pages.image-show', 'section' => null],
      ['key' => 'faqs', 'label' => __('home.nav.faqs'), 'href' => $sectionHref('faqs'), 'route' => null, 'section' => 'faqs'],
      ['key' => 'contact', 'label' => __('home.nav.contact'), 'href' => $sectionHref('contact'), 'route' => null, 'section' => 'contact'],
  ];
  $navPositionClass = $floating
      ? 'fixed left-4 right-4 md:left-6 md:right-6'
      : 'sticky top-2 md:top-3 mx-4 md:mx-6 mt-2 md:mt-3';
  $mobileMenuPositionClass = $floating
      ? 'fixed left-4 right-4 top-24'
      : 'relative mx-4 mt-3';
@endphp

<nav
  @if($floating)
    x-data="{ scrolled: window.scrollY > 48 }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 48, { passive: true })"
    :class="scrolled ? 'top-3 md:top-4 bg-[rgba(17,25,29,0.26)] border-white/25 shadow-black/15' : 'top-10 md:top-12 bg-[rgba(17,25,29,0.26)] border-white/25 shadow-black/15'"
  @endif
  class="{{ $navPositionClass }} {{ $floating ? '' : 'bg-[rgba(17,25,29,0.26)] border-white/25 shadow-black/15' }} backdrop-blur-xl border rounded-full shadow-lg px-4 md:px-6 py-2.5 md:py-3 flex items-center justify-between z-50 transition-[top,transform,box-shadow,background-color,border-color] duration-500 ease-out"
>
  <!-- @if($siteLogo)
    <img src="{{ $asset($siteLogo) }}" alt="{{ $siteName ?? '' }}" class="h-8" style="height:52px;width:auto;">
  @else
    <div class="w-10"></div>
  @endif -->
@if($siteLogo)
  <img src="{{ $asset($siteLogo) }}" alt="{{ $siteName ?? '' }}"
       class="h-8 md:hidden"
       style="filter: drop-shadow(0 1px 2px rgba(0,0,0,0.35));">
  <img src="{{ $asset($siteLogo) }}" alt="{{ $siteName ?? '' }}"
       class="h-9 hidden md:block"
       style="height:52px;width:auto; filter: drop-shadow(0 1px 2px rgba(0,0,0,0.35));">
@endif <div class="w-10 hidden md:block"></div>

  <ul class="hidden md:flex items-center gap-3 text-base text-white/90" @if($floating) :class="scrolled ? 'text-[var(--teal)]' : 'text-white/90'" @endif>
    @foreach($navItems as $item)
      @continue($item['key'] !== 'home' && empty($navAvailability[$item['key']]))
      @php
        $routePatterns = $item['route'] ? explode('|', $item['route']) : [];
        $isRouteActive = collect($routePatterns)->contains(fn ($pattern) => request()->routeIs($pattern));
        $staticActive = ! $isHomePage && $isRouteActive;
        $click = $item['section'] ? $sectionClick($item['section']) : null;
      @endphp
      <li>
        <a href="{{ $item['href'] }}"
           @if($click) @click.prevent="{{ $click }}" @endif
           @if($isHomePage) :class="activeSection === '{{ $item['section'] ?? $item['key'] }}' ? 'nav-link active' : 'nav-link'" @endif
           class="block px-5 py-2 rounded-full nav-link {{ $staticActive ? 'active' : '' }}">
          {{ $item['label'] }}
        </a>
      </li>
    @endforeach
  </ul>

  <a href="{{ route('service-request.create') }}"
     class="btn-blue text-sm md:text-base font-bold px-4 md:px-6 py-2 md:py-2.5 rounded-full flex items-center gap-2">
    {{ __('home.nav.request_service') }} <i class="ri-arrow-left-line rtl:inline ltr:hidden"></i><i class="ri-arrow-right-line ltr:inline rtl:hidden"></i>
  </a>

  <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden w-10 h-10 flex items-center justify-center rounded-full" style="background-color:#f5ad2a;">
    <i class="ri-menu-line text-white text-xl" x-show="!mobileMenuOpen"></i>
    <i class="ri-close-line text-white text-xl" x-show="mobileMenuOpen" x-cloak></i>
  </button>
</nav>

{{-- Mobile menu (drawer) --}}
<div x-show="mobileMenuOpen" x-cloak x-transition class="{{ $mobileMenuPositionClass }} z-50 md:hidden bg-[rgba(17,25,29,0.52)] backdrop-blur-xl border border-white/20 rounded-3xl shadow-lg shadow-black/20 p-3">
  <ul class="flex flex-col text-white/90 text-base font-bold divide-y divide-white/10">
    @foreach($navItems as $item)
    @continue($item['key'] !== 'home' && empty($navAvailability[$item['key']]))
    @php
      $section = $item['section'];
      $href = $item['href'];
      $isSection = filled($section);
      $routePatterns = $item['route'] ? explode('|', $item['route']) : [];
      $isRouteActive = collect($routePatterns)->contains(fn ($pattern) => request()->routeIs($pattern));
    @endphp
    <li>
      <a href="{{ $href }}"
         @if($isHomePage && $isSection) @click.prevent="activeSection = '{{ $section }}'; mobileMenuOpen = false; document.querySelector('#{{ $section }}')?.scrollIntoView({behavior:'smooth'})" @else @click="mobileMenuOpen = false" @endif
         class="block px-4 py-3 rounded-2xl"
         @if($isHomePage && $isSection) :style="activeSection === '{{ $section }}' ? 'color:#fff;background-color:#f5ad2a;' : ''" @endif
         @if($isRouteActive) style="color:#fff;background-color:#f5ad2a;" @endif>
        {{ $item['label'] }}
      </a>
    </li>
    @endforeach
  </ul>
</div>
