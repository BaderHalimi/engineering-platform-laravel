<section id="feedback" class="relative py-16 md:py-24 bg-[var(--bg-soft)] overflow-hidden">
  <div class="container mx-auto px-5 md:px-6 max-w-2xl">
    <div class="text-center mb-10 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ri-feedback-line"></i> {{ __('home.feedback.badge') }}
      </div>
      <h2 class="text-3xl md:text-4xl font-extrabold text-[var(--teal)] mb-3 leading-snug">{{ __('home.feedback.title') }}</h2>
      <div class="section-title-underline mx-auto mb-4"></div>
      <p class="text-gray-500 text-sm md:text-base font-normal leading-relaxed">{{ __('home.feedback.subtitle') }}</p>
    </div>

    <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white border border-gray-100 rounded-3xl p-6 md:p-8 shadow-xl shadow-gray-200/50 generic-reveal"
          x-data x-intersect.once="$el.classList.add('visible')">
      @csrf

      <div class="mb-4 md:mb-5">
        <label class="block text-sm font-bold text-[var(--teal)] mb-2">{{ __('home.feedback.email') }} *</label>
        <input type="email" name="email" value="{{ old('email') }}" required class="field @error('email') border-red-500 @enderror" placeholder="example@email.com">
        @error('email')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
      </div>

      <div class="mb-4 md:mb-5">
        <label class="block text-sm font-bold text-[var(--teal)] mb-2">{{ __('home.feedback.subject') }} *</label>
        <input type="text" name="title" value="{{ old('title') }}" required maxlength="255" class="field @error('title') border-red-500 @enderror" placeholder="{{ __('home.feedback.subject_placeholder') }}">
        @error('title')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
      </div>

      <div class="mb-4 md:mb-5">
        <label class="block text-sm font-bold text-[var(--teal)] mb-2">{{ __('home.feedback.content') }} *</label>
        <textarea name="content" rows="5" required class="field @error('content') border-red-500 @enderror" placeholder="{{ __('home.feedback.content_placeholder') }}">{{ old('content') }}</textarea>
        @error('content')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
      </div>

      <div class="mb-5 md:mb-6">
        <label class="block text-sm font-bold text-[var(--teal)] mb-2">{{ __('home.feedback.attachments') }}</label>
        <input type="file" name="attachments[]" multiple class="field">
      </div>

      <button type="submit" class="btn-blue w-full text-base md:text-lg font-bold rounded-full inline-flex items-center justify-center gap-2" style="padding:.9rem 1rem;">
        {{ __('home.feedback.submit') }} <i class="ri-send-plane-fill text-lg md:text-xl"></i>
      </button>
    </form>
  </div>
</section>
