@php
  $projectItems = collect($projects ?? [])->values();
  $projectCount = $projectItems->count();
  $siteDir = in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur'], true) ? 'rtl' : 'ltr';
  $firstSliderCount = $projectCount > 0 ? (int) ceil($projectCount / 2) : 0;
  $projectRows = $projectCount > 0
    ? collect([$projectItems->take($firstSliderCount)->values(), $projectItems->slice($firstSliderCount)->values()])
        ->filter(fn ($row) => $row->isNotEmpty())
        ->values()
    : collect();
  $marqueeCopies = 3;
@endphp

@if($projectItems->isNotEmpty())  
<section id="projects" class="relative py-16 md:py-24 bg-[var(--bg-soft)] overflow-hidden" style="background-color: rgb(241, 245, 247);">
  <div class="site-container">
    <div class="text-center max-w-2xl mx-auto mb-10 md:mb-16 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ri-building-4-line"></i> {{ __('home.projects.badge') }}
      </div>
      <h2 class="text-3xl md:text-4xl font-extrabold text-[var(--teal)] mb-3 md:mb-4 leading-snug">{{ __('home.projects.title') }}</h2>
      <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
      <p class="text-gray-500 text-sm md:text-base font-normal leading-relaxed">{{ __('home.projects.subtitle') }}</p>
    </div>

    <div class="projects-marquee-stack">
      @foreach($projectRows as $rowIndex => $projectRow)
        @php
          $rowProjectCount = $projectRow->count();
          $itemsPerLoop = max($rowProjectCount, (int) ceil(12 / $rowProjectCount) * $rowProjectCount);
        @endphp
        <div class="projects-marquee-shell" data-marquee-dir="{{ $siteDir }}" data-row="{{ $rowIndex + 1 }}" style="--project-copy-count: {{ $marqueeCopies }};">
          <div class="projects-marquee-track">
            @for($copy = 0; $copy < $marqueeCopies; $copy++)
              <div class="projects-marquee-group" aria-hidden="{{ $copy > 0 ? 'true' : 'false' }}" @if($copy > 0) inert @endif>
                @for($loopIndex = 0; $loopIndex < $itemsPerLoop; $loopIndex++)
                  @php
                    $project = $projectRow[$loopIndex % $rowProjectCount];
                  @endphp
                  <div class="project-slide-card project-card card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
                    <div class="relative overflow-hidden h-80">
                      <img src="{{ $asset($project->image) ?: 'https://files.catbox.moe/8jxeio.jpg' }}" alt="{{ $project->title }}" class="project-img w-full h-full object-cover">
                      <div class="project-overlay absolute inset-0 bg-gradient-to-t from-[var(--teal)]/90 to-transparent flex items-end p-6">
                        <a href="{{ url('/projects/'.$project->slug) }}" aria-label="{{ $project->title }}" class="bg-white text-[var(--teal)] w-12 h-12 rounded-full flex items-center justify-center hover:bg-[var(--gold)] hover:text-white transition">
                          <i class="ri-arrow-up-line rtl:rotate-45 ltr:-rotate-45 text-xl"></i>
                        </a>
                      </div>
                      @if($project->category)
                        <span class="absolute top-4 end-4 bg-[var(--gold)] text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ $project->category->name }}</span>
                      @endif
                    </div>
                    <div class="p-5 md:p-6">
                      <h3 class="font-extrabold text-[var(--teal)] text-base md:text-lg mb-2">{{ $project->title }}</h3>
                      <p class="text-gray-500 text-xs md:text-sm mb-3 md:mb-4">{{ Str::limit(strip_tags($project->description ?? ''), 100) }}</p>
                    </div>
                  </div>

                  @if($project->separator_image)
                    <div class="project-separator-card" aria-hidden="true">
                      <img src="{{ $asset($project->separator_image) }}" alt="" loading="lazy">
                    </div>
                  @endif
                @endfor
              </div>
            @endfor
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<style>
  .projects-static-grid{
    display:grid;
    gap:1.75rem;
    margin-inline:auto;
    align-items:stretch;
  }
  .projects-static-grid-1{
    max-width:520px;
    grid-template-columns:minmax(0, 1fr);
  }
  .projects-static-grid-2{
    max-width:1100px;
    grid-template-columns:repeat(2, minmax(0, 1fr));
  }
  .projects-static-grid-3{
    max-width:1180px;
    grid-template-columns:repeat(3, minmax(0, 1fr));
  }
  .projects-marquee-shell{
    position: relative;
    width: 100%;
    margin-inline: 0;
    overflow: hidden;
    direction: ltr;
    padding-block: .75rem 1rem;
    -webkit-mask-image: linear-gradient(to right, transparent 0, #000 8%, #000 92%, transparent 100%);
    mask-image: linear-gradient(to right, transparent 0, #000 8%, #000 92%, transparent 100%);
  }
  .projects-marquee-stack{
    display:grid;
    gap:1.75rem;
  }
  .projects-marquee-track{
    display: flex;
    width: max-content;
    gap: 0;
    flex-direction: row;
    direction: ltr;
    animation: projects-marquee-ltr 110s linear infinite;
    will-change: transform;
  }
  .projects-marquee-shell[data-row="2"] .projects-marquee-track{
    animation-duration:125s;
    animation-direction:reverse;
  }
  .projects-marquee-shell[data-marquee-dir="ltr"] .projects-marquee-track{
    direction:ltr;
    animation-name:projects-marquee-ltr;
  }
  .projects-marquee-shell[data-marquee-dir="rtl"] .projects-marquee-track{
    direction:rtl;
    animation-name:projects-marquee-rtl;
  }
  .projects-marquee-shell:hover .projects-marquee-track{
    animation-play-state: paused;
  }
  .projects-marquee-group{
    display: flex;
    flex-direction: row;
    align-items: stretch;
    gap: 1.75rem;
    padding-inline: .875rem;
    direction: ltr;
    flex-shrink: 0;
  }
  .projects-marquee-group[aria-hidden="true"]{ pointer-events: none; }
  .project-slide-card{
    width: min(84vw, 430px);
    flex: 0 0 min(84vw, 430px);
  }
  .projects-static-grid .project-slide-card{
    width: 100%;
    flex: auto;
  }
  .project-separator-card{
    width:min(42vw, 150px);
    flex:0 0 min(42vw, 150px);
    align-self:center;
    border-radius:28px;
    overflow:hidden;
    background:white;
    border:1px solid rgba(82,105,112,.14);
    box-shadow:0 20px 40px -28px rgba(34,38,43,.3);
  }
  .project-separator-card img{
    width:100%;
    aspect-ratio:3 / 4;
    object-fit:cover;
    display:block;
  }
  @keyframes projects-marquee-ltr{
    from{ transform: translateX(0); }
    to{ transform: translateX(calc(-100% / var(--project-copy-count))); }
  }
  @keyframes projects-marquee-rtl{
    from{ transform: translateX(0); }
    to{ transform: translateX(calc(100% / var(--project-copy-count))); }
  }
  @media (prefers-reduced-motion: reduce){
    .projects-marquee-track{ animation: none !important; }
  }
  @media (max-width: 767px){
    .projects-static-grid-2,
    .projects-static-grid-3{
      grid-template-columns: minmax(0, 1fr);
      max-width: 430px;
    }
  }
</style>
@endif
