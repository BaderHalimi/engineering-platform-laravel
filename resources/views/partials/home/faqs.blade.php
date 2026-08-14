@php
  $faqItems = collect($faqs ?? []);
  $faqCount = $faqItems->count();
  $faqListClass = $faqCount === 2 ? 'grid gap-3 md:grid-cols-2 md:gap-5' : 'space-y-3';
  $faqContainerClass = $faqCount === 1 ? 'max-w-2xl' : ($faqCount === 2 ? 'max-w-5xl' : 'max-w-3xl');
@endphp

@if($faqItems->isNotEmpty())
<section id="faqs" class="relative py-16 md:py-24 bg-white overflow-hidden">
  <div class="container mx-auto px-5 md:px-6 {{ $faqContainerClass }}">
    <div class="text-center mb-10 md:mb-14 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ri-question-answer-line"></i> {{ __('home.faqs.badge') }}
      </div>
      <h2 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-3 md:mb-4">{{ __('home.faqs.title') }}</h2>
      <div class="section-title-underline mx-auto"></div>
    </div>

    <div class="{{ $faqListClass }}">
      @foreach($faqItems as $faq)
        <div class="border border-gray-100 rounded-2xl overflow-hidden bg-white shadow-sm" x-data="{ open: false }">
          {{-- سؤال قابل للطي (collapsed) --}}
          <button type="button" @click="open = !open" class="w-full flex items-center justify-between gap-4 p-4 md:p-5 text-start">
            <span class="font-bold text-[var(--teal)] text-sm md:text-base line-clamp-1" :class="open ? '' : ''">
              {{ Str::limit(strip_tags($faq->ask), 140) }}
            </span>
            <i class="ri-arrow-down-s-line faq-chevron text-xl text-[var(--gold-dark)] shrink-0" :class="{ 'open': open }"></i>
          </button>
          <div x-show="open" x-collapse x-cloak class="px-4 md:px-5 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-50 pt-4">
            {{ $faq->answer }}
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif
