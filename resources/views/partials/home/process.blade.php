<section class="relative overflow-hidden">
  <div class="md:hidden min-h-screen flex flex-col bg-white">
    <div class="px-6 pt-6 pb-4 flex items-center justify-between shrink-0">
      <span class="font-display font-bold text-[11px] tracking-[0.35em]" style="color:var(--ink);">{{ $siteName }}</span>
      <span class="h-px flex-1 mx-3" style="background:var(--line);"></span>
      <span class="font-display font-bold text-[10px] tracking-[0.3em]" style="color:var(--gold);">EST. 2012</span>
    </div>
    <div class="px-6 text-start shrink-0 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
      <span class="font-display font-bold text-[11px] tracking-[0.3em]" style="color:var(--gold);">{{ __('home.process.eyebrow') }}</span>
      <h1 class="font-display font-black text-4xl mt-1 mb-2" style="color:var(--ink);">{{ __('home.process.title') }}</h1>
      <p class="text-sm font-medium leading-7" style="color:var(--teal);">{{ __('home.process.subtitle') }}</p>
    </div>
    <div class="px-6 mt-6 pb-8">
      <div class="relative">
        <div class="absolute top-2 bottom-2 start-[33px] w-px" style="background:var(--line);"></div>
        <div class="space-y-7">
          @foreach($workSteps as $i => $step)
          <div class="relative flex items-start gap-4 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
            <div class="w-[40px] h-[40px] rounded-full flex items-center justify-center font-display font-black text-base shrink-0 z-10" style="background:{{ $loop->last ? 'var(--gold)' : 'var(--ink)' }}; color:{{ $loop->last ? 'var(--ink)' : 'var(--gold)' }};">{{ $loop->iteration }}</div>
            <div class="text-start flex-1 pt-1.5">
              <h3 class="font-display font-black text-base mb-1" style="color:var(--gold);">{{ $tr($step['title'] ?? []) }}</h3>
              <p class="text-[13px] font-medium leading-relaxed" style="color:var(--teal);">{{ $tr($step['description'] ?? []) }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <div class="hidden md:flex relative min-h-[70vh] overflow-hidden flex-col py-16">
    <div class="px-10 text-start max-w-3xl ms-10 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
      <div class="flex items-center gap-2 mb-3">
        <span class="font-display font-bold text-[11px] tracking-[0.35em]" style="color:var(--gold);">{{ __('home.process.eyebrow') }}</span>
        <span class="w-8 h-px" style="background:var(--gold);"></span>
      </div>
      <h1 class="font-display font-black text-5xl mb-3" style="color:var(--gold);">{{ __('home.process.title') }}</h1>
      <p class="text-xl font-bold leading-relaxed" style="color:var(--teal);">{{ __('home.process.subtitle') }}</p>
    </div>
    <div class="flex-1 flex items-center px-16 mt-10">
      <div class="w-full grid grid-cols-{{ max(count($workSteps), 2) }} gap-6 relative">
        @foreach($workSteps as $i => $step)
        <div class="relative text-start generic-reveal" x-data x-intersect.once="$el.classList.add('visible')" style="transition-delay:{{ $loop->iteration * 0.1 }}s;">
          <div class="flex items-center justify-start mb-5">
            <div class="w-[68px] h-[68px] rounded-full flex items-center justify-center font-display font-black text-2xl shrink-0" style="background:{{ $loop->last ? 'var(--gold)' : 'var(--ink)' }}; color:{{ $loop->last ? 'var(--ink)' : 'var(--gold)' }};">{{ $loop->iteration }}</div>
          </div>
          <h3 class="font-display font-black text-xl mb-2" style="color:var(--gold);">{{ $tr($step['title'] ?? []) }}</h3>
          <p class="text-[15px] font-medium leading-relaxed" style="color:var(--teal);">{{ $tr($step['description'] ?? []) }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
