{{-- @if($topNotice)
<div class="w-full bg-[var(--gold)] text-[var(--ink)] text-sm py-2 px-6 text-center font-bold">
  {{ $topNotice }}
</div>
@endif --}}

<div class="site-topbar w-full bg-gradient-to-l from-[var(--teal)] to-[var(--teal-dark)] text-white text-sm py-2 items-center justify-between hidden md:flex">
  <div class="flex items-center gap-5">
    @if($sitePhone)<span class="flex items-center gap-2"><i class="ri-phone-fill"></i> {{ $sitePhone }}</span>@endif
    @if($siteEmail)<span class="flex items-center gap-2"><i class="ri-mail-fill"></i> {{ $siteEmail }}</span>@endif
    @if($siteAddress)<span class="flex items-center gap-2"><i class="ri-map-pin-fill"></i> {{ $siteAddress }}</span>@endif
  </div>
  <div class="flex items-center gap-3 text-white/80">
    @foreach($socialLinks as $link)
      <a href="{{ $link['url'] ?? '#' }}" target="_blank" rel="noopener" class="hover:text-[var(--gold)] transition"><i class="{{ $link['icon'] ?? 'ri-links-line' }}"></i></a>
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
            <a
               @if($code === 'en') style="opacity:.4;pointer-events:none;cursor:default;" @endif
               href="{{ $code === 'en' ? '#' : route('set-locale', $code) }}"
               class="block px-4 py-1.5 text-sm hover:bg-gray-50 {{ app()->getLocale() === $code ? 'font-bold text-[var(--gold-dark)]' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>

    <span class="border-e border-white/30 h-4 mx-2"></span>
    <a href="{{ route('login', [], false) ?: '#' }}" class="hover:text-[var(--gold)] transition flex items-center gap-1"><i class="ri-user-line"></i> {{ __('home.my_account') }}</a>
  </div>
</div>
