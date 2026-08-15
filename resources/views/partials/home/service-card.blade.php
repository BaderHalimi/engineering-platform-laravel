@php
  $svcName = is_array($service->name) ? $tr($service->name) : $service->name;
  $svcShort = is_array($service->short_description) ? $tr($service->short_description) : $service->short_description;

  $priceLabels = [
      'fixed' => __('home.services.price_fixed'),
      'starting_from' => __('home.services.price_from'),
      'quote' => __('home.services.price_quote'),
  ];

  $refCode = 'A-' . str_pad($index + 1, 2, '0', STR_PAD_LEFT);
@endphp

<div class="blueprint-card service-marquee-card group relative bg-white flex flex-col">
  <div class="stamp-seal absolute -top-5 inset-inline-end-5 z-20">
    <div class="stamp-ring">
      <span class="stamp-code">{{ $refCode }}</span>
    </div>
  </div>

  <div class="blueprint-head relative overflow-hidden">
    @if($service->thumbnail)
      <img src="{{ $asset($service->thumbnail) }}" alt="{{ $svcName }}" class="blueprint-thumb">
      <div class="blueprint-head-overlay"></div>
    @else
      <div class="blueprint-icon-only">
        <i class="{{ $service->icon ?? 'ri-building-2-line' }}"></i>
      </div>
    @endif
    <span class="blueprint-corner-tag">{{ $refCode }}</span>
  </div>

  <div class="p-6 md:p-7 flex flex-col flex-1 text-right">
    <h3 class="text-lg md:text-xl font-bold text-[var(--teal)] mb-2">{{ $svcName }}</h3>

    @if($svcShort)
      <p class="text-gray-500 text-sm md:text-base leading-relaxed mb-5">{{ $svcShort }}</p>
    @endif

    <div class="ruler-divider mb-5"></div>

    @if($service->estimated_time || $service->price || $service->documented || $service->visit_required)
      <div class="spec-table mb-6">
        @if($service->estimated_time)
          <div class="spec-row">
            <span class="spec-label"><i class="ri-time-line"></i> {{ __('home.services.duration_label') ?? 'المدة' }}</span>
            <span class="spec-value">{{ $service->estimated_time }}</span>
          </div>
        @endif

        @if($service->price)
          <div class="spec-row">
            <span class="spec-label"><i class="ri-price-tag-3-line"></i> {{ $priceLabels[$service->price_type] ?? '' }}</span>
            <span class="spec-value spec-value-gold">{{ $service->price }}</span>
          </div>
        @endif

        @if($service->documented)
          <div class="spec-row">
            <span class="spec-label"><i class="ri-shield-check-line"></i> {{ __('home.services.documented') }}</span>
            <span class="spec-value spec-check"><i class="ri-check-line"></i></span>
          </div>
        @endif

        @if($service->visit_required)
          <div class="spec-row">
            <span class="spec-label"><i class="ri-map-pin-line"></i> {{ __('home.services.visit_required') }}</span>
            <span class="spec-value spec-check spec-amber"><i class="ri-check-line"></i></span>
          </div>
        @endif
      </div>
    @endif

    <a href="{{ $contactUrl ?? '#contact' }}" @if(empty($contactUrl)) @click.prevent="document.querySelector('#contact')?.scrollIntoView({behavior:'smooth'})" @endif
       class="mt-auto request-link inline-flex items-center justify-center gap-2 font-bold text-sm">
      {{ __('home.services.request') }}
      <i class="ri-arrow-left-line rtl:inline ltr:hidden"></i><i class="ri-arrow-right-line ltr:inline rtl:hidden"></i>
    </a>
    <a href="{{ route('home_pages.services.view', $service->slug) }}" class="mt-3 inline-flex items-center justify-center gap-2 text-sm font-bold text-[var(--teal)] hover:text-[var(--gold-dark)] transition">
      {{ app()->getLocale() === 'ar' ? 'معرفة المزيد' : 'Learn more' }}
      <i class="ri-arrow-left-line rtl:inline ltr:hidden"></i><i class="ri-arrow-right-line ltr:inline rtl:hidden"></i>
    </a>
  </div>
</div>
