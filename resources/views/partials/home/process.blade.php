@php
  $steps = collect($workSteps ?? [])->values();
@endphp

@if($steps->isNotEmpty())
<section id="process" class="process-section relative overflow-hidden py-16 md:py-24 bg-white">
  <div class="absolute inset-0 process-grid pointer-events-none"></div>
  <div class="absolute -top-28 -end-24 h-72 w-72 rounded-full bg-[var(--gold)]/10 blur-3xl pointer-events-none"></div>

  <div class="site-container relative z-10">
    <div class="generic-reveal mx-auto max-w-3xl text-center mb-12 md:mb-16" x-data x-intersect.once="$el.classList.add('visible')">
      <div class="inline-flex items-center gap-2 rounded-full border border-[var(--gold)]/40 bg-white/80 px-4 py-1.5 text-xs md:text-sm font-extrabold text-[var(--gold-dark)] shadow-sm">
        <i class="ri-route-line"></i>
        {{ __('home.process.eyebrow') }}
      </div>
      <h2 class="mt-4 text-3xl md:text-5xl font-black text-[var(--teal)] leading-tight">{{ __('home.process.title') }}</h2>
      <div class="section-title-underline mx-auto my-4"></div>
      <p class="text-sm md:text-lg leading-8 text-gray-500">{{ __('home.process.subtitle') }}</p>
    </div>

    <div class="relative">
      <div class="hidden lg:block absolute top-[52px] start-0 end-0 h-px process-connector"></div>

      <div class="process-steps-grid grid gap-5 md:grid-cols-2" style="--process-cols: {{ min($steps->count(), 4) }};">
        @foreach($steps as $index => $step)
          @php
            $number = str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
            $icon = $step['icon'] ?? 'ri-compasses-2-line';
          @endphp

          <article
            class="process-card generic-reveal group relative flex min-h-[255px] flex-col rounded-2xl border border-[var(--line)] bg-white p-6 shadow-sm transition duration-500 hover:-translate-y-1 hover:border-[var(--gold)] hover:shadow-2xl hover:shadow-[rgba(82,105,112,.12)]"
            x-data
            x-intersect.once="$el.classList.add('visible')"
            style="transition-delay:{{ $loop->iteration * 0.08 }}s;"
          >
            <div class="mb-6 flex items-start justify-between gap-4">
              <div class="process-step-mark relative z-10 flex h-16 w-16 items-center justify-center rounded-2xl bg-[var(--teal)] text-xl font-black text-white shadow-lg shadow-[rgba(82,105,112,.22)] transition group-hover:bg-[var(--gold)] group-hover:text-white">
                {{ $number }}
              </div>

              <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[var(--gold)]/10 text-2xl text-[var(--gold-dark)] transition group-hover:scale-110 group-hover:bg-[var(--teal)] group-hover:text-white">
                <i class="{{ $icon }}"></i>
              </div>
            </div>

            <h3 class="text-xl font-black leading-snug text-[var(--teal)] mb-3">{{ $tr($step['title'] ?? []) }}</h3>
            <p class="text-sm leading-7 font-semibold text-gray-500">{{ $tr($step['description'] ?? []) }}</p>

            <div class="mt-auto pt-6">
              <div class="h-px w-full process-ruler"></div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </div>
</section>

<style>
  .process-grid{
    background-image:
      linear-gradient(rgba(82,105,112,.045) 1px, transparent 1px),
      linear-gradient(90deg, rgba(82,105,112,.045) 1px, transparent 1px);
    background-size: 42px 42px;
    mask-image: radial-gradient(ellipse 80% 65% at 50% 25%, black 0%, transparent 78%);
  }
  .process-connector{
    background-image: repeating-linear-gradient(to left, rgba(216,147,32,.45) 0 10px, transparent 10px 20px);
  }
  .process-ruler{
    background-image: repeating-linear-gradient(to left, var(--line) 0 8px, transparent 8px 16px);
  }
  @media (min-width: 1024px){
    .process-steps-grid{
      grid-template-columns: repeat(var(--process-cols), minmax(0, 1fr));
    }
  }
  .process-card::before{
    content:"";
    position:absolute;
    inset:0;
    border-radius:1rem;
    background:linear-gradient(135deg, rgba(245,173,42,.08), transparent 42%);
    opacity:0;
    transition:opacity .45s ease;
    pointer-events:none;
  }
  .process-card:hover::before{ opacity:1; }
  @media (max-width: 767px){
    .process-card{ min-height:0; }
  }
</style>
@endif
