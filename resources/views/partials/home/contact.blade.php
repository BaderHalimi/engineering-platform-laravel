<section id="contact" class="relative py-16 md:py-24 bg-white overflow-hidden">
  <div class="site-container">
    <div class="text-center max-w-2xl mx-auto mb-10 md:mb-16 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
      <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-3 md:px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
        <i class="ri-mail-open-line"></i> {{ __('home.contact.badge') }}
      </div>
      <h2 class="text-3xl md:text-4xl font-extrabold text-[var(--teal)] mb-3 md:mb-4 leading-snug">{{ __('home.contact.title') }}</h2>
      <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
      <p class="text-gray-500 text-sm md:text-base font-normal leading-relaxed">{{ __('home.contact.subtitle') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
      @if($sitePhone)
      <div class="card-hover bg-white border border-gray-100 rounded-3xl p-5 md:p-6 flex items-start gap-3 md:gap-4 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[var(--gold)] to-[var(--gold-dark)] text-white flex items-center justify-center shrink-0"><i class="ri-phone-fill text-xl md:text-2xl"></i></div>
        <div>
          <h4 class="font-extrabold text-[var(--teal)] mb-1 text-sm md:text-base">{{ __('home.contact.call_us') }}</h4>
          <p class="text-gray-500 text-xs md:text-sm mb-1">{{ $workingHours ?: __('home.contact.default_hours') }}</p>
          <a href="tel:{{ $sitePhone }}" class="font-bold text-[var(--teal)] text-sm md:text-base" style="direction:ltr; display:inline-block;">{{ $sitePhone }}</a>
        </div>
      </div>
      @endif

      @if($siteEmail)
      <div class="card-hover bg-white border border-gray-100 rounded-3xl p-5 md:p-6 flex items-start gap-3 md:gap-4 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[var(--gold)] to-[var(--gold-dark)] text-white flex items-center justify-center shrink-0"><i class="ri-mail-fill text-xl md:text-2xl"></i></div>
        <div>
          <h4 class="font-extrabold text-[var(--teal)] mb-1 text-sm md:text-base">{{ __('home.contact.email') }}</h4>
          <p class="text-gray-500 text-xs md:text-sm mb-1">{{ __('home.contact.reply_time') }}</p>
          <a href="mailto:{{ $siteEmail }}" class="font-bold text-[var(--teal)] text-sm md:text-base">{{ $siteEmail }}</a>
        </div>
      </div>
      @endif

      @if($siteAddress)
      <div class="card-hover bg-white border border-gray-100 rounded-3xl p-5 md:p-6 flex items-start gap-3 md:gap-4 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[var(--gold)] to-[var(--gold-dark)] text-white flex items-center justify-center shrink-0"><i class="ri-map-pin-fill text-xl md:text-2xl"></i></div>
        <div>
          <h4 class="font-extrabold text-[var(--teal)] mb-1 text-sm md:text-base">{{ __('home.contact.headquarters') }}</h4>
          <p class="text-gray-500 text-xs md:text-sm">{{ $siteAddress }}</p>
        </div>
      </div>
      @endif
    </div>

    <div class="mt-8">
      <div class="mx-auto max-w-4xl rounded-3xl border border-[var(--gold)]/25 bg-white p-5 md:p-6 shadow-xl shadow-gray-200/60 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <div class="mb-5 flex items-start gap-4">
          <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[var(--gold)]/10 text-2xl text-[var(--gold-dark)] shrink-0">
            <i class="ri-mail-send-line"></i>
          </div>
          <div>
            <h3 class="mb-1 text-lg md:text-xl font-black text-[var(--teal)]">اشترك بالحملة البريدية</h3>
            <p class="text-sm leading-7 text-gray-500">تحديثات مختصرة عن الخدمات، المقالات، وآخر الأعمال الهندسية.</p>
          </div>
        </div>
        <form action="{{ $siteEmail ? 'mailto:' . $siteEmail : '#' }}" method="GET" class="flex flex-col md:flex-row gap-3">
          <input type="hidden" name="subject" value="اشتراك بالحملة البريدية">
          <input type="email" name="body" class="field rounded-full text-center md:text-start" placeholder="example@email.com">
          <button type="submit" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-[var(--gold)] px-6 py-3 text-sm font-extrabold text-white shadow-lg shadow-[rgba(245,173,42,.25)] transition hover:bg-[var(--gold-dark)]">
            اشترك الآن
            <i class="ri-arrow-left-line rtl:inline ltr:hidden"></i><i class="ri-arrow-right-line ltr:inline rtl:hidden"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>
