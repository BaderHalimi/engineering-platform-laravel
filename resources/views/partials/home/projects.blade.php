<section id="projects" class="relative py-16 md:py-24 bg-[var(--bg-soft)] overflow-hidden">
  <div class="container mx-auto px-5 md:px-6">
    <div class="text-center max-w-2xl mx-auto mb-10 md:mb-16 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ri-building-4-line"></i> {{ __('home.projects.badge') }}
      </div>
      <h2 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-3 md:mb-4">{{ __('home.projects.title') }}</h2>
      <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
      <p class="text-gray-500 text-sm md:text-lg">{{ __('home.projects.subtitle') }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-7">
      @forelse($projects as $project)
      <div class="project-card card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <div class="relative overflow-hidden h-64">
          <img src="{{ $asset($project->image) ?: 'https://files.catbox.moe/8jxeio.jpg' }}" alt="{{ $project->title }}" class="project-img w-full h-full object-cover">
          <div class="project-overlay absolute inset-0 bg-gradient-to-t from-[var(--teal)]/90 to-transparent flex items-end p-6">
            <a href="{{ url('/projects/'.$project->slug) }}" class="bg-white text-[var(--teal)] w-12 h-12 rounded-full flex items-center justify-center hover:bg-[var(--gold)] hover:text-white transition">
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
      @empty
      <div class="col-span-3 text-center text-gray-400 py-10">{{ __('home.projects.empty') }}</div>
      @endforelse
    </div>
  </div>
</section>
