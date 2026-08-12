<section id="articles" class="relative py-16 md:py-24 bg-white overflow-hidden">
  <div class="container mx-auto px-5 md:px-6">
    <div class="text-center max-w-2xl mx-auto mb-10 md:mb-16 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ri-newspaper-line"></i> {{ __('home.articles.badge') }}
      </div>
      <h2 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-3 md:mb-4">{{ __('home.articles.title') }}</h2>
      <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
      <p class="text-gray-500 text-sm md:text-lg">{{ __('home.articles.subtitle') }}</p>
    </div>

    @forelse($articlesByCategory as $categoryName => $categoryArticles)
      <div class="mb-12 md:mb-16">
        <div class="flex items-center gap-3 mb-6">
          <h3 class="text-xl md:text-2xl font-extrabold text-[var(--teal)]">{{ $categoryName }}</h3>
          <span class="flex-1 h-px bg-gray-100"></span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-7">
          @foreach($categoryArticles as $article)
          <article class="card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
            <div class="relative overflow-hidden h-52">
              <img src="{{ $asset($article->thumbnail) ?: 'https://files.catbox.moe/8jxeio.jpg' }}" alt="{{ $article->title }}" class="w-full h-full object-cover project-img">
            </div>
            <div class="p-5 md:p-6">
              <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                <span class="flex items-center gap-1"><i class="ri-calendar-line"></i> {{ optional($article->published_at)->format('Y-m-d') }}</span>
                <span class="flex items-center gap-1"><i class="ri-eye-line"></i> {{ $article->views }}</span>
              </div>
              <h3 class="font-extrabold text-[var(--teal)] text-base md:text-lg mb-2 leading-snug line-clamp-2">{{ $article->title }}</h3>
              <p class="text-gray-500 text-xs md:text-sm mb-4 md:mb-5 line-clamp-2">{{ Str::limit(strip_tags($article->content), 110) }}</p>
              <a href="{{ url('/articles/'.$article->slug) }}" class="inline-flex items-center gap-1 text-[var(--gold-dark)] font-bold text-sm hover:gap-3 transition-all">
                {{ __('home.articles.read') }}
                <i class="ri-arrow-left-line rtl:inline ltr:hidden"></i><i class="ri-arrow-right-line ltr:inline rtl:hidden"></i>
              </a>
            </div>
          </article>
          @endforeach
        </div>
      </div>
    @empty
      <div class="text-center text-gray-400 py-10">{{ __('home.articles.empty') }}</div>
    @endforelse
  </div>
</section>
