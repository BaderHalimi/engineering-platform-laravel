<section id="about" class="relative w-full py-16 md:py-24 mt-8 font-body">
  @if(count($aboutUs) > 0)
  <div class="md:hidden max-w-md mx-auto px-5">
    <div x-data x-intersect.once="$el.classList.add('is-visible')" class="reveal flex items-center justify-between mb-6">
      <span class="text-[11px] tracking-[0.3em] font-bold text-[var(--teal)]/70 font-display">AL-DIWAN ENG.</span>
      <span class="text-[11px] tracking-[0.3em] font-bold font-display" style="color:var(--gold);">01</span>
    </div>
    <div x-data x-intersect.once="$el.classList.add('is-visible')" class="reveal relative rounded-3xl overflow-hidden shadow-xl border border-[var(--line)]">
      <img src="https://files.catbox.moe/3i7imq.webp" alt="" class="w-full h-80 object-cover">
      <div class="absolute inset-0 bg-gradient-to-t from-[var(--ink)] via-[var(--ink)]/10 to-transparent"></div>
      <div class="corner corner-tl"></div>
      <div class="corner corner-br"></div>
      <div class="absolute bottom-0 end-0 p-5 text-end">
        <h1 class="font-black text-white text-4xl leading-none mb-1 font-display">{{ $tr($aboutUs[0]['title'] ?? ['ar'=>'من نحن']) }}</h1>
        <h2 class="font-bold text-white/90 text-lg font-display">{{ $siteName }}</h2>
      </div>
    </div>
    <div x-data x-intersect.once="$el.classList.add('is-visible')" class="reveal mt-8 pe-4 border-e-4 ruler" style="border-color:var(--gold);">
      <p class="text-[15px] leading-8">{{ $tr($aboutUs[0]['description'] ?? []) }}</p>
    </div>
    <div class="mt-10 space-y-5">
      @foreach(array_slice($aboutUs, 1) as $i => $card)
      <div x-data x-intersect.once="$el.classList.add('is-visible')" class="reveal reveal-delay-{{ min($i + 1, 3) }} relative bg-white rounded-2xl shadow-lg border border-[var(--line)] p-5 pe-6 overflow-hidden">
        <span class="absolute top-0 bottom-0 end-0 w-1.5" style="background:var(--gold);"></span>
        <span class="text-xs font-bold tracking-widest font-display" style="color:var(--gold);">{{ strtoupper($tr($card['label'] ?? ['ar'=>''])) }}</span>
        <p class="mt-2 text-[15px] leading-8">{{ $tr($card['description'] ?? []) }}</p>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  <!-- Desktop about -->
  <div class="hidden md:flex container mx-auto px-6 items-center justify-between gap-10">
    <img x-data x-intersect.once="$el.classList.add('is-visible')" src="https://files.catbox.moe/3i7imq.webp" alt="" class="reveal order-2 h-auto w-auto max-w-[35%] object-contain rounded-2xl shadow-xl">
    <div class="order-1 max-w-[42%] text-start" style="color:var(--teal);">
      <div x-data x-intersect.once="$el.classList.add('is-visible')" class="reveal mb-10">
        <h1 class="text-6xl font-bold leading-none mb-1">{{ $tr($aboutUs[0]['title'] ?? ['ar'=>'من نحن']) }}</h1>
        <h2 class="text-4xl font-bold">{{ $siteName }}</h2>
      </div>
      @foreach(array_slice($aboutUs, 1) as $i => $card)
      <div x-data x-intersect.once="$el.classList.add('is-visible')" class="reveal reveal-delay-{{ min($i + 1, 3) }} {{ $loop->last ? '' : 'bg-white' }} rounded-2xl shadow-xl border border-gray-100 p-5 mb-4">
        <h3 class="text-3xl font-bold mb-2" style="color:var(--gold);">{{ $tr($card['title'] ?? []) }}</h3>
        <p class="text-2xl">{{ $tr($card['description'] ?? []) }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>
