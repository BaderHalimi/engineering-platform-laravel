<footer class="relative pt-16 pb-6 overflow-hidden" style="background: linear-gradient(135deg, var(--teal-dark) 0%, #1f2e34 100%);">
  <div class="absolute inset-0 geo-pattern opacity-5"></div>
  <div class="container mx-auto px-5 md:px-6 relative z-10 text-white">
    <div class="bg-gradient-to-l from-[var(--gold)] to-[var(--gold-dark)] rounded-3xl p-5 md:p-8 mb-10 md:mb-12 flex flex-col md:flex-row items-center justify-between gap-4 shadow-2xl">
      <div class="text-center md:text-start">
        <h3 class="text-lg md:text-2xl font-black text-white mb-1">{{ __('home.footer.cta_title') }}</h3>
        <p class="text-white/90 text-xs md:text-sm">{{ __('home.footer.cta_subtitle') }}</p>
      </div>
      <a href="#contact" @click.prevent="document.querySelector('#contact').scrollIntoView({behavior:'smooth'})" class="bg-white text-[var(--gold-dark)] font-extrabold text-sm md:text-base rounded-full inline-flex items-center gap-2 hover:scale-105 transition" style="padding:.7rem 1.5rem;">
        {{ __('home.footer.cta_button') }} <i class="ri-arrow-left-line rtl:inline ltr:hidden"></i><i class="ri-arrow-right-line ltr:inline rtl:hidden"></i>
      </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-10 mb-8 md:mb-10">
      <div class="col-span-2 md:col-span-1">
        @if($siteLogo)<img src="{{ $asset($siteLogo) }}" alt="{{ $siteName }}" class="mb-4 bg-white/10 rounded-2xl p-2" style="height:70px;width:auto;">@endif
        <p class="text-white/70 text-xs md:text-sm leading-relaxed mb-4 md:mb-5">{{ __('home.footer.about_text', ['name' => $siteName]) }}</p>
        <div class="flex items-center gap-2 md:gap-3">
          @foreach($socialLinks as $link)
            <a href="{{ $link['url'] ?? '#' }}" target="_blank" rel="noopener" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-white/10 hover:bg-[var(--gold)] flex items-center justify-center transition"><i class="{{ $link['icon'] ?? 'ri-links-line' }} text-base md:text-lg"></i></a>
          @endforeach
        </div>
      </div>
      <div>
        <h4 class="font-extrabold text-base md:text-lg mb-4 md:mb-5 relative inline-block">{{ __('home.footer.quick_links') }}<span class="absolute -bottom-2 start-0 h-1 w-10 bg-[var(--gold)] rounded-full"></span></h4>
        <ul class="space-y-2 md:space-y-3 text-xs md:text-sm text-white/70 mt-5">
          <li><a href="#home" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ri-arrow-left-s-line rtl:inline ltr:hidden text-xs text-[var(--gold)]"></i><i class="ri-arrow-right-s-line ltr:inline rtl:hidden text-xs text-[var(--gold)]"></i> {{ __('home.nav.home') }}</a></li>
          <li><a href="#services" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ri-arrow-left-s-line rtl:inline ltr:hidden text-xs text-[var(--gold)]"></i><i class="ri-arrow-right-s-line ltr:inline rtl:hidden text-xs text-[var(--gold)]"></i> {{ __('home.nav.services') }}</a></li>
          <li><a href="#projects" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ri-arrow-left-s-line rtl:inline ltr:hidden text-xs text-[var(--gold)]"></i><i class="ri-arrow-right-s-line ltr:inline rtl:hidden text-xs text-[var(--gold)]"></i> {{ __('home.nav.projects') }}</a></li>
          <li><a href="#about" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ri-arrow-left-s-line rtl:inline ltr:hidden text-xs text-[var(--gold)]"></i><i class="ri-arrow-right-s-line ltr:inline rtl:hidden text-xs text-[var(--gold)]"></i> {{ __('home.nav.about') }}</a></li>
          <li><a href="#articles" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ri-arrow-left-s-line rtl:inline ltr:hidden text-xs text-[var(--gold)]"></i><i class="ri-arrow-right-s-line ltr:inline rtl:hidden text-xs text-[var(--gold)]"></i> {{ __('home.nav.articles') }}</a></li>
          <li><a href="#media" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ri-arrow-left-s-line rtl:inline ltr:hidden text-xs text-[var(--gold)]"></i><i class="ri-arrow-right-s-line ltr:inline rtl:hidden text-xs text-[var(--gold)]"></i> {{ __('home.nav.media') }}</a></li>
          <li><a href="#contact" class="hover:text-[var(--gold)] transition flex items-center gap-2"><i class="ri-arrow-left-s-line rtl:inline ltr:hidden text-xs text-[var(--gold)]"></i><i class="ri-arrow-right-s-line ltr:inline rtl:hidden text-xs text-[var(--gold)]"></i> {{ __('home.nav.contact') }}</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-extrabold text-base md:text-lg mb-4 md:mb-5 relative inline-block">{{ __('home.nav.services') }}<span class="absolute -bottom-2 start-0 h-1 w-10 bg-[var(--gold)] rounded-full"></span></h4>
        <ul class="space-y-2 md:space-y-3 text-xs md:text-sm text-white/70 mt-5">
          @foreach($services->take(6) as $svc)
            <li><a href="#services" class="hover:text-[var(--gold)] transition">{{ $tr($svc->name) }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="col-span-2 md:col-span-1">
        <h4 class="font-extrabold text-base md:text-lg mb-4 md:mb-5 relative inline-block">{{ __('home.nav.contact') }}<span class="absolute -bottom-2 start-0 h-1 w-10 bg-[var(--gold)] rounded-full"></span></h4>
        <ul class="space-y-3 md:space-y-4 text-xs md:text-sm text-white/70 mt-5">
          @if($siteAddress)<li class="flex items-start gap-3"><i class="ri-map-pin-fill text-[var(--gold)] text-base md:text-lg shrink-0 mt-0.5"></i><span>{{ $siteAddress }}</span></li>@endif
          @if($sitePhone)<li class="flex items-start gap-3"><i class="ri-phone-fill text-[var(--gold)] text-base md:text-lg shrink-0 mt-0.5"></i><a href="tel:{{ $sitePhone }}" class="hover:text-[var(--gold)] transition" style="direction:ltr; display:inline-block;">{{ $sitePhone }}</a></li>@endif
          @if($siteEmail)<li class="flex items-start gap-3"><i class="ri-mail-fill text-[var(--gold)] text-base md:text-lg shrink-0 mt-0.5"></i><a href="mailto:{{ $siteEmail }}" class="hover:text-[var(--gold)] transition">{{ $siteEmail }}</a></li>@endif
          @if($workingHours)<li class="flex items-start gap-3"><i class="ri-time-line text-[var(--gold)] text-base md:text-lg shrink-0 mt-0.5"></i><span>{{ $workingHours }}</span></li>@endif
        </ul>
      </div>
    </div>
    <div class="border-t border-white/10 pt-5 md:pt-6 flex flex-col md:flex-row items-center justify-between gap-3 md:gap-4 text-xs md:text-sm text-white/50">
      <div>© {{ date('Y') }} {{ $siteName }}. {{ __('home.footer.rights') }}</div>
      <div class="flex items-center gap-4 md:gap-5">
        <a href="#" class="hover:text-[var(--gold)] transition">{{ __('home.footer.privacy') }}</a>
        <a href="#" class="hover:text-[var(--gold)] transition">{{ __('home.footer.terms') }}</a>
        <a href="#" class="hover:text-[var(--gold)] transition">{{ __('home.footer.sitemap') }}</a>
      </div>
    </div>
  </div>
</footer>

<button @click="window.scrollTo({top:0, behavior:'smooth'})"
        x-data="{ visible: false }"
        x-init="window.addEventListener('scroll', () => visible = window.scrollY > 400)"
        x-show="visible" x-cloak
        class="fixed bottom-6 start-6 z-50 w-12 h-12 rounded-full btn-primary flex items-center justify-center shadow-xl transition-all duration-300" style="padding:0;cursor:pointer;">
  <i class="ri-arrow-up-line text-xl"></i>
</button>

@if($sitePhone)
<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sitePhone) }}"
   target="_blank" rel="noopener"
   title="تواصل معنا عبر واتساب"
   class="fixed bottom-6 end-6 z-50 w-14 h-14 rounded-full flex items-center justify-center shadow-2xl pulse-ring transition-all duration-300 hover:scale-110"
   style="background:#25D366; padding:0;">
  <i class="ri-whatsapp-fill text-2xl text-white"></i>
</a>
@endif
