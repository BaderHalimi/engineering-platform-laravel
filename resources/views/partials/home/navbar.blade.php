{{-- Nav: desktop (md+) --}}
@php
  $floating = $floating ?? false;
  $navPositionClass = $floating
      ? 'fixed left-4 right-4 md:left-6 md:right-6'
      : 'sticky top-2 md:top-3 mx-4 md:mx-6 mt-4 md:mt-5';
  $mobileMenuPositionClass = $floating
      ? 'fixed left-4 right-4 top-24'
      : 'relative mx-4 mt-3';
@endphp

<nav
  @if($floating)
    x-data="{ scrolled: window.scrollY > 48 }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 48, { passive: true })"
    :class="scrolled ? 'top-4 md:top-5 bg-[rgba(17,25,29,0.42)] border-white/20 shadow-black/25' : 'top-20 md:top-24 bg-white/16 border-white/25 shadow-black/20'"
  @endif
  class="{{ $navPositionClass }} {{ $floating ? '' : 'bg-white/95 border-gray-100 shadow-gray-200/50' }} backdrop-blur-xl border rounded-full shadow-lg px-4 md:px-6 py-2.5 md:py-3 flex items-center justify-between z-50 transition-[top,transform,box-shadow,background-color,border-color] duration-500 ease-out"
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

  <ul class="hidden md:flex items-center gap-3 text-base font-bold {{ $floating ? 'text-white/90' : 'text-gray-600' }}">
    <li><a href="{{ route('home') }}" :class="activeSection === 'home' ? 'nav-link active' : 'nav-link'" class="block px-5 py-2 rounded-full">{{ __('home.nav.home') }}</a></li>
    <li><a href="{{ route('home_pages.services.index') }}" class="block px-5 py-2 rounded-full nav-link">{{ __('home.nav.services') }}</a></li>
    <li><a href="{{ route('home_pages.projects.index') }}" class="block px-5 py-2 rounded-full nav-link">{{ __('home.nav.projects') }}</a></li>
    <li><a href="{{ route('home_pages.aboutus') }}" class="block px-5 py-2 rounded-full nav-link">{{ __('home.nav.about') }}</a></li>
    <li><a href="#articles" @click.prevent="activeSection = 'articles'; document.querySelector('#articles').scrollIntoView({behavior:'smooth'})" :class="activeSection === 'articles' ? 'nav-link active' : 'nav-link'" class="block px-5 py-2 rounded-full">{{ __('home.nav.articles') }}</a></li>
    <li><a href="#media" @click.prevent="activeSection = 'media'; document.querySelector('#media').scrollIntoView({behavior:'smooth'})" :class="activeSection === 'media' ? 'nav-link active' : 'nav-link'" class="block px-5 py-2 rounded-full">{{ __('home.nav.media') }}</a></li>
    <li><a href="#faqs" @click.prevent="activeSection = 'faqs'; document.querySelector('#faqs').scrollIntoView({behavior:'smooth'})" :class="activeSection === 'faqs' ? 'nav-link active' : 'nav-link'" class="block px-5 py-2 rounded-full">{{ __('home.nav.faqs') }}</a></li>
    <li><a href="#contact" @click.prevent="activeSection = 'contact'; document.querySelector('#contact').scrollIntoView({behavior:'smooth'})" :class="activeSection === 'contact' ? 'nav-link active' : 'nav-link'" class="block px-5 py-2 rounded-full">{{ __('home.nav.contact') }}</a></li>
  </ul>

  <a href="#contact" class="btn-blue text-sm md:text-base font-bold px-4 md:px-6 py-2 md:py-2.5 rounded-full flex items-center gap-2">
    {{ __('home.nav.request_service') }} <i class="ri-arrow-left-line rtl:inline ltr:hidden"></i><i class="ri-arrow-right-line ltr:inline rtl:hidden"></i>
  </a>

  <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden w-10 h-10 flex items-center justify-center rounded-full" style="background-color:#f5ad2a;">
    <i class="ri-menu-line text-white text-xl" x-show="!mobileMenuOpen"></i>
    <i class="ri-close-line text-white text-xl" x-show="mobileMenuOpen" x-cloak></i>
  </button>
</nav>

{{-- Mobile menu (drawer) --}}
<div x-show="mobileMenuOpen" x-cloak x-transition class="{{ $mobileMenuPositionClass }} z-50 md:hidden bg-white border border-gray-100 rounded-3xl shadow-lg shadow-gray-200/50 p-3">
  <ul class="flex flex-col text-gray-600 text-base font-bold divide-y divide-gray-100">
    @foreach([
        ['home', 'home.nav.home'],
        [route('home_pages.services.index'), 'home.nav.services', false],
        [route('home_pages.projects.index'), 'home.nav.projects', false],
        [route('home_pages.aboutus'), 'home.nav.about', false],
        ['articles', 'home.nav.articles'],
        ['media', 'home.nav.media'],
        ['faqs', 'home.nav.faqs'],
        ['contact', 'home.nav.contact'],
    ] as $item)
    @php
      $section = $item[2] ?? $item[0];
      $href = str_starts_with($item[0], 'http') || str_starts_with($item[0], '/') ? $item[0] : '#' . $item[0];
      $label = $item[1];
      $isSection = $item[2] ?? true;
    @endphp
    <li>
      <a href="{{ $href }}"
         @if($isSection) @click.prevent="activeSection = '{{ $section }}'; mobileMenuOpen = false; document.querySelector('#{{ $section }}')?.scrollIntoView({behavior:'smooth'})" @else @click="mobileMenuOpen = false" @endif
         class="block px-4 py-3 rounded-2xl"
         :style="activeSection === '{{ $section }}' ? 'color:#fff;background-color:#f5ad2a;' : ''">
        {{ __($label) }}
      </a>
    </li>
    @endforeach
  </ul>
</div>
