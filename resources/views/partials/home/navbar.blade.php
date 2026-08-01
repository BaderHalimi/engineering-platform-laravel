{{-- Nav: desktop (md+) --}}
<nav class="bg-white/95 backdrop-blur border border-gray-100 rounded-full shadow-lg shadow-gray-200/50 px-4 md:px-6 py-2.5 md:py-3 mx-4 md:mx-6 mt-4 md:mt-5 flex items-center justify-between sticky top-2 md:top-3 z-50 transition-all duration-300">
  @if($siteLogo)
    <img src="{{ $asset($siteLogo) }}" alt="{{ $siteName ?? '' }}" class="h-8" style="height:52px;width:auto;">
  @else
    <div class="w-10"></div>
  @endif

  <ul class="hidden md:flex items-center gap-3 text-gray-600 text-base font-bold">
    <li><a href="#home" @click.prevent="activeSection = 'home'; $el.scrollIntoView ? document.querySelector('#home').scrollIntoView({behavior:'smooth'}) : null" :class="activeSection === 'home' ? 'nav-link active' : 'nav-link'" class="block px-5 py-2 rounded-full">{{ __('home.nav.home') }}</a></li>
    <li><a href="#services" @click.prevent="activeSection = 'services'; document.querySelector('#services').scrollIntoView({behavior:'smooth'})" :class="activeSection === 'services' ? 'nav-link active' : 'nav-link'" class="block px-5 py-2 rounded-full">{{ __('home.nav.services') }}</a></li>
    <li><a href="#projects" @click.prevent="activeSection = 'projects'; document.querySelector('#projects').scrollIntoView({behavior:'smooth'})" :class="activeSection === 'projects' ? 'nav-link active' : 'nav-link'" class="block px-5 py-2 rounded-full">{{ __('home.nav.projects') }}</a></li>
    <li><a href="#about" @click.prevent="activeSection = 'about'; document.querySelector('#about').scrollIntoView({behavior:'smooth'})" :class="activeSection === 'about' ? 'nav-link active' : 'nav-link'" class="block px-5 py-2 rounded-full">{{ __('home.nav.about') }}</a></li>
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
<div x-show="mobileMenuOpen" x-cloak x-transition class="md:hidden mx-4 mt-3 bg-white border border-gray-100 rounded-3xl shadow-lg shadow-gray-200/50 p-3">
  <ul class="flex flex-col text-gray-600 text-base font-bold divide-y divide-gray-100">
    @foreach([
        ['home', 'home.nav.home'],
        ['services', 'home.nav.services'],
        ['projects', 'home.nav.projects'],
        ['about', 'home.nav.about'],
        ['articles', 'home.nav.articles'],
        ['media', 'home.nav.media'],
        ['faqs', 'home.nav.faqs'],
        ['contact', 'home.nav.contact'],
    ] as [$section, $label])
    <li>
      <a href="#{{ $section }}"
         @click.prevent="activeSection = '{{ $section }}'; mobileMenuOpen = false; document.querySelector('#{{ $section }}').scrollIntoView({behavior:'smooth'})"
         class="block px-4 py-3 rounded-2xl"
         :style="activeSection === '{{ $section }}' ? 'color:#fff;background-color:#f5ad2a;' : ''">
        {{ __($label) }}
      </a>
    </li>
    @endforeach
  </ul>
</div>
