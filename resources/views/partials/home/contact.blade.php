<section id="contact" class="relative py-16 md:py-24 bg-white overflow-hidden">
  <div class="container mx-auto px-5 md:px-6">
    <div class="text-center max-w-2xl mx-auto mb-10 md:mb-16 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ri-mail-open-line"></i> {{ __('home.contact.badge') }}
      </div>
      <h2 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-3 md:mb-4">{{ __('home.contact.title') }}</h2>
      <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
      <p class="text-gray-500 text-sm md:text-lg">{{ __('home.contact.subtitle') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 md:gap-10">
      <div class="lg:col-span-2 space-y-4 md:space-y-5 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
        @if($sitePhone)
        <div class="card-hover bg-white border border-gray-100 rounded-3xl p-5 md:p-6 flex items-start gap-3 md:gap-4">
          <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[var(--gold)] to-[var(--gold-dark)] text-white flex items-center justify-center shrink-0"><i class="ri-phone-fill text-xl md:text-2xl"></i></div>
          <div>
            <h4 class="font-extrabold text-[var(--teal)] mb-1 text-sm md:text-base">{{ __('home.contact.call_us') }}</h4>
            <p class="text-gray-500 text-xs md:text-sm mb-1">{{ $workingHours ?: __('home.contact.default_hours') }}</p>
            <a href="tel:{{ $sitePhone }}" class="font-bold text-[var(--teal)] text-sm md:text-base" style="direction:ltr; display:inline-block;">{{ $sitePhone }}</a>
          </div>
        </div>
        @endif
        @if($siteEmail)
        <div class="card-hover bg-white border border-gray-100 rounded-3xl p-5 md:p-6 flex items-start gap-3 md:gap-4">
          <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[var(--gold)] to-[var(--gold-dark)] text-white flex items-center justify-center shrink-0"><i class="ri-mail-fill text-xl md:text-2xl"></i></div>
          <div>
            <h4 class="font-extrabold text-[var(--teal)] mb-1 text-sm md:text-base">{{ __('home.contact.email') }}</h4>
            <p class="text-gray-500 text-xs md:text-sm mb-1">{{ __('home.contact.reply_time') }}</p>
            <a href="mailto:{{ $siteEmail }}" class="font-bold text-[var(--teal)] text-sm md:text-base">{{ $siteEmail }}</a>
          </div>
        </div>
        @endif
        @if($siteAddress)
        <div class="card-hover bg-white border border-gray-100 rounded-3xl p-5 md:p-6 flex items-start gap-3 md:gap-4">
          <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[var(--gold)] to-[var(--gold-dark)] text-white flex items-center justify-center shrink-0"><i class="ri-map-pin-fill text-xl md:text-2xl"></i></div>
          <div>
            <h4 class="font-extrabold text-[var(--teal)] mb-1 text-sm md:text-base">{{ __('home.contact.headquarters') }}</h4>
            <p class="text-gray-500 text-xs md:text-sm">{{ $siteAddress }}</p>
          </div>
        </div>
        @endif
      </div>

      <div class="lg:col-span-3 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <form action="{{ route('service-request.store') }}" method="POST" class="bg-white border border-gray-100 rounded-3xl p-6 md:p-8 shadow-xl shadow-gray-200/50">
          @csrf
          <h3 class="text-xl md:text-2xl font-extrabold text-[var(--teal)] mb-2">{{ __('home.contact.form_title') }}</h3>
          <p class="text-gray-500 text-sm mb-5 md:mb-7">{{ __('home.contact.form_subtitle') }}</p>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5 mb-4 md:mb-5">
            <div>
              <label class="block text-sm font-bold text-[var(--teal)] mb-2">{{ __('home.contact.full_name') }} *</label>
              <input type="text" name="customer_name" value="{{ old('customer_name') }}" required class="field @error('customer_name') border-red-500 @enderror" placeholder="{{ __('home.contact.full_name_placeholder') }}">
              @error('customer_name')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>
            <div>
              <label class="block text-sm font-bold text-[var(--teal)] mb-2">{{ __('home.contact.phone') }} *</label>
              <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" required class="field @error('customer_phone') border-red-500 @enderror" placeholder="05xxxxxxxx">
              @error('customer_phone')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5 mb-4 md:mb-5">
            <div>
              <label class="block text-sm font-bold text-[var(--teal)] mb-2">{{ __('home.contact.email_label') }}</label>
              <input type="email" name="customer_email" value="{{ old('customer_email') }}" class="field @error('customer_email') border-red-500 @enderror" placeholder="example@email.com">
              @error('customer_email')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>
            <div>
              <label class="block text-sm font-bold text-[var(--teal)] mb-2">{{ __('home.contact.service_type') }} *</label>
              <select name="service_id" required class="field @error('service_id') border-red-500 @enderror">
                <option value="">-- {{ __('home.contact.choose_service') }} --</option>
                @foreach($services as $svc)
                  <option value="{{ $svc->id }}" {{ old('service_id') == $svc->id ? 'selected' : '' }}>
                    {{ $tr($svc->title) }}
                  </option>
                @endforeach
              </select>
              @error('service_id')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="mb-4 md:mb-5">
            <label class="block text-sm font-bold text-[var(--teal)] mb-2">{{ __('home.contact.address') }}</label>
            <input type="text" name="customer_address" value="{{ old('customer_address') }}" class="field" placeholder="{{ __('home.contact.address_placeholder') }}">
          </div>

          <div class="mb-4 md:mb-5">
            <label class="block text-sm font-bold text-[var(--teal)] mb-2">{{ __('home.contact.request_title') }} *</label>
            <input type="text" name="title" value="{{ old('title') }}" required maxlength="255" class="field @error('title') border-red-500 @enderror" placeholder="{{ __('home.contact.request_title_placeholder') }}">
            @error('title')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
          </div>

          <div class="mb-4 md:mb-5">
            <label class="block text-sm font-bold text-[var(--teal)] mb-2">{{ __('home.contact.details') }}</label>
            <textarea name="details" rows="5" class="field" placeholder="{{ __('home.contact.details_placeholder') }}">{{ old('details') }}</textarea>
          </div>

          <button type="submit" class="btn-primary w-full text-base md:text-lg font-bold rounded-full inline-flex items-center justify-center gap-2" style="padding:.9rem 1rem;">
            {{ __('home.contact.submit') }} <i class="ri-send-plane-fill text-lg md:text-xl"></i>
          </button>
          <p class="text-xs text-gray-400 mt-3 md:mt-4 text-center">{!! __('home.contact.privacy_notice') !!}</p>
        </form>
      </div>
    </div>
  </div>
</section>
