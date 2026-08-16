{{-- @if($topNotice)
<div class="w-full bg-[var(--gold)] text-[var(--ink)] text-sm py-2 px-6 text-center font-bold">
  {{ $topNotice }}
</div>
@endif --}}

<div class="site-topbar w-full bg-gradient-to-l from-[var(--teal)] to-[var(--teal-dark)] text-white text-sm py-2 items-center gap-4 hidden md:flex">
  <div class="flex shrink-0 items-center gap-5">
    @if($sitePhone)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $sitePhone) }}" class="flex items-center gap-2 hover:text-[var(--gold)] transition"><i class="ri-phone-fill"></i> {{ $sitePhone }}</a>@endif
    @if($siteEmail)<a href="mailto:{{ $siteEmail }}" class="flex items-center gap-2 hover:text-[var(--gold)] transition"><i class="ri-mail-fill"></i> {{ $siteEmail }}</a>@endif
  </div>

  @if($siteAddress)
    <div class="flex min-w-0 flex-1 justify-center text-center font-bold leading-6">
      <span class="inline-flex max-w-full items-center justify-center gap-2">
        <i class="ri-map-pin-fill shrink-0"></i>
        <span>{{ $siteAddress }}</span>
      </span>
    </div>
  @endif

  <div class="flex shrink-0 items-center gap-3 text-white/80">
    @foreach($socialLinks as $link)
      @if(filled($link['url'] ?? null) && ($link['url'] ?? '#') !== '#')
        <a href="{{ $link['url'] }}" target="_blank" rel="noopener" aria-label="{{ $link['label'] ?? 'Social link' }}" class="hover:text-[var(--gold)] transition">
          <i class="{{ $link['icon'] ?? 'ri-links-line' }}"></i>
        </a>
      @endif
    @endforeach
    <span class="border-e border-white/30 h-4 mx-2"></span>

    {{-- ===== مبدّل اللغة (ar / en / fr) ===== --}}
<div class="relative flex items-center gap-1" x-data="{ langOpen: false }">
    <button
        @click="langOpen = !langOpen"
        @click.outside="langOpen = false"
        class="flex items-center gap-1 hover:text-[var(--gold)] transition uppercase font-bold">
        <i class="ri-global-line"></i>
        {{ app()->getLocale() }}
    </button>

    <div
        x-show="langOpen"
        x-cloak
        x-transition
        class="absolute top-full mt-2 right-0 w-28 bg-white text-[var(--teal)] rounded-xl shadow-2xl border border-gray-100 py-2 z-[99999]">
        @foreach(['ar' => 'العربية', 'en' => 'English'] as $code => $label)
            @if($code === 'en')
                <span class="block px-4 py-1.5 text-sm opacity-40 cursor-default">
                    {{ $label }}
                </span>
            @else
                <a
                   href="{{ route('set-locale', $code) }}"
                   class="block px-4 py-1.5 text-sm hover:bg-gray-50 {{ app()->getLocale() === $code ? 'font-bold text-[var(--gold-dark)]' : '' }}">
                    {{ $label }}
                </a>
            @endif
        @endforeach
    </div>
</div>

    <span class="border-e border-white/30 h-4 mx-2"></span>
    <a href="#" disabled class="disabled hover:text-[var(--gold)] transition flex items-center gap-1"><i class="ri-user-line"></i> {{ __('home.my_account') }}</a>
  </div>
</div>
