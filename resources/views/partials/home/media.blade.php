@php
  $videoItems = collect($videos ?? []);
  $imageItems = collect($images ?? []);
  $hasVideos = $videoItems->isNotEmpty();
  $hasImages = $imageItems->isNotEmpty();
  $videoGridClass = $videoItems->count() === 1
    ? 'grid grid-cols-1 gap-5 md:gap-7 mb-14 md:mb-20 max-w-md mx-auto'
    : ($videoItems->count() === 2
      ? 'grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-7 mb-14 md:mb-20 max-w-5xl mx-auto'
      : 'grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-7 mb-14 md:mb-20');
  $imageGridClass = $imageItems->count() === 1
    ? 'grid grid-cols-1 gap-5 md:gap-7 max-w-md mx-auto'
    : ($imageItems->count() === 2
      ? 'grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-7 max-w-5xl mx-auto'
      : 'grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-7');
@endphp

@if($hasVideos || $hasImages)
<section id="media" class="relative py-16 md:py-24 bg-[var(--bg-soft)] overflow-hidden">
  <div class="site-container">

    {{-- ====== فيديوهات (تُعرض عبر الثمبنيل - يُفتح الفيديو عند الضغط) ====== --}}
    @if($hasVideos)
    <div class="text-center max-w-2xl mx-auto mb-10 md:mb-12 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ri-play-circle-line"></i> {{ __('home.media.videos_badge') }}
      </div>
      <h2 class="text-3xl md:text-4xl font-black text-[var(--teal)] mb-3">{{ __('home.media.videos_title') }}</h2>
      <div class="section-title-underline mx-auto mb-4"></div>
    </div>

    <div class="{{ $videoGridClass }}">
        @foreach($videoItems as $video)
        <div class="card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal"
             x-data="{ playing: false }" x-intersect.once="$el.classList.add('visible')">
          <div class="relative overflow-hidden h-52 bg-black">
            <template x-if="!playing">
        <a href="{{ route('home_pages.videos.view', $video->slug) }}" class="w-full h-full block relative">
                <img src="{{ $asset($video->thumbnail) }}" alt="{{ $video->title }}" class="w-full h-full object-cover" loading="lazy">
                <span class="absolute inset-0 flex items-center justify-center bg-black/20">
                  <i class="ri-play-fill text-white text-4xl bg-black/40 rounded-full p-3"></i>
                </span>
                @if($video->duration)
                  <span class="absolute bottom-3 start-3 bg-black/80 text-white text-xs font-bold px-2 py-1 rounded-lg">
                    {{ gmdate('i:s', $video->duration) }}
                  </span>
                @endif
              </a>
            </template>
            <template x-if="playing">
              <div class="w-full h-full">
                @php $embed = $video->embed ?: $videoEmbed($video->video_path); @endphp
                @if($embed)
                  <iframe src="{{ $embed }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @else
                  <video src="{{ $asset($video->video_path) }}" class="w-full h-full object-cover" controls autoplay></video>
                @endif
              </div>
            </template>
          </div>
          <div class="p-5">
            <h3 class="font-extrabold text-[var(--teal)] text-base mb-2 line-clamp-2">{{ $video->title }}</h3>
            @if($video->description)<p class="text-gray-500 text-xs mb-3 line-clamp-2">{{ Str::limit(strip_tags($video->description), 90) }}</p>@endif
            <div class="flex items-center justify-between text-xs text-gray-500">
              @if($video->published_at)<span class="flex items-center gap-1"><i class="ri-calendar-line"></i> {{ $video->published_at->format('Y-m-d') }}</span>@endif
              <span class="flex items-center gap-1"><i class="ri-eye-line"></i> {{ $video->views }}</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    @endif

    {{-- ====== معرض الصور (روابط storage) ====== --}}
    @if($hasImages)
    <div class="text-center max-w-2xl mx-auto mb-10 md:mb-12 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ri-image-line"></i> {{ __('home.media.gallery_badge') }}
      </div>
      <h2 class="text-3xl md:text-4xl font-black text-[var(--teal)] mb-3">{{ __('home.media.gallery_title') }}</h2>
      <div class="section-title-underline mx-auto mb-4"></div>
    </div>

    <div class="{{ $imageGridClass }}">
        @foreach($imageItems as $img)
        @php($imageLink = filled($img->link_url ?? null) ? $img->link_url : null)
      <div class="card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal group" x-data x-intersect.once="$el.classList.add('visible')">
        @if($imageLink)
          <a
            href="{{ $imageLink }}"
            aria-label="{{ $img->title ?: ($img->alt_text ?: __('home.media.gallery_title')) }}"
            class="relative overflow-hidden h-64 block"
          >
        @else
          <div class="relative overflow-hidden h-64 block">
        @endif
            <img src="{{ $asset($img->image_path) }}" alt="{{ $img->alt_text ?: $img->title }}" class="w-full h-full object-cover project-img" loading="lazy">
            <div class="project-overlay absolute inset-0 bg-gradient-to-t from-[var(--teal)]/90 to-transparent flex items-end p-5">
              <div class="text-white">
                @if($img->title)<h4 class="font-extrabold text-sm mb-1">{{ $img->title }}</h4>@endif
                @if($img->description)<p class="text-xs text-white/80 line-clamp-2">{{ $img->description }}</p>@endif
              </div>
            </div>
            @if($img->featured)<span class="absolute top-4 end-4 bg-[var(--gold)] text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ __('home.media.featured') }}</span>@endif
        @if($imageLink)
          </a>
        @else
          </div>
        @endif
        <div class="p-4 flex items-center justify-between text-xs text-gray-500">
          <span class="flex items-center gap-1"><i class="ri-eye-line"></i> {{ $img->views }}</span>
          <span class="flex items-center gap-1"><i class="ri-heart-line"></i> {{ $img->likes }}</span>
        </div>
      </div>
      @endforeach
    </div>
    @endif

  </div>
</section>
@endif
