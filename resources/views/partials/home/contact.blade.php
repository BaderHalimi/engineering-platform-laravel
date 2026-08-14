<section id="contact" class="relative py-16 md:py-24 bg-white overflow-hidden">
  <div class="site-container">
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

        <div class="relative overflow-hidden rounded-3xl border border-[var(--gold)]/30 bg-gradient-to-br from-[var(--teal-dark)] to-[var(--teal)] p-5 md:p-6 text-white shadow-xl shadow-[rgba(82,105,112,.18)]">
          <div class="absolute -top-12 -end-10 h-32 w-32 rounded-full bg-[var(--gold)]/20 blur-2xl"></div>
          <div class="relative">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-2xl text-[var(--gold)]">
              <i class="ri-mail-send-line"></i>
            </div>
            <h3 class="mb-2 text-lg md:text-xl font-black">اشترك بالحملة البريدية</h3>
            <p class="mb-5 text-sm leading-7 text-white/75">استقبل تحديثات الخدمات، المقالات، وآخر الأعمال الهندسية مباشرة على بريدك.</p>
            <form action="{{ $siteEmail ? 'mailto:' . $siteEmail : '#' }}" method="GET" class="flex flex-col gap-3">
              <input type="email" name="email" class="w-full rounded-full border border-white/15 bg-white/10 px-4 py-3 text-sm font-bold text-white outline-none placeholder:text-white/55 focus:border-[var(--gold)]" placeholder="example@email.com">
              <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[var(--gold)] px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-black/10 transition hover:bg-[var(--gold-dark)]">
                اشترك الآن
                <i class="ri-arrow-left-line rtl:inline ltr:hidden"></i><i class="ri-arrow-right-line ltr:inline rtl:hidden"></i>
              </button>
            </form>
          </div>
        </div>
      </div>

      <div class="lg:col-span-3 generic-reveal" x-data x-intersect.once="$el.classList.add('visible')">
        <form action="{{ route('service-request.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-100 rounded-3xl p-6 md:p-8 shadow-xl shadow-gray-200/50">
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
              <select name="service_id" id="service_id" required class="field @error('service_id') border-red-500 @enderror">
                <option value="">-- {{ __('home.contact.choose_service') }} --</option>
                @foreach($services as $svc)
                  <option
                    value="{{ $svc->id }}"
                    data-documented="{{ $svc->documented ? '1' : '0' }}"
                    {{ old('service_id') == $svc->id ? 'selected' : '' }}
                  >
                    {{ $tr($svc->name) }}
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

          {{-- ===== حقل رفع المستندات (يظهر فقط إذا الخدمة موثّقة) ===== --}}
          <div id="documents-section" class="mb-4 md:mb-5 hidden">
            <label class="block text-sm font-bold text-[var(--teal)] mb-2">
              {{ __('home.contact.documents') }}
              <span class="text-xs font-normal text-gray-400">({{ __('home.contact.documents_hint') }})</span>
            </label>

            <label for="documents_input" class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 rounded-2xl p-6 cursor-pointer hover:border-[var(--gold)] hover:bg-gray-50 transition">
              <i class="ri-upload-cloud-2-line text-3xl text-[var(--teal)]"></i>
              <span class="text-sm font-semibold text-[var(--teal)]">{{ __('home.contact.upload_click') }}</span>
              <span class="text-xs text-gray-400">PDF, JPG, PNG — {{ __('home.contact.max_size') }} 5MB</span>
              <input
                type="file"
                name="documents[]"
                id="documents_input"
                multiple
                accept=".pdf,.jpg,.jpeg,.png"
                class="hidden"
              >
            </label>

            <div id="documents-preview" class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-3"></div>

            @error('documents')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            @error('documents.*')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
          </div>

          <button type="submit" class="btn-primary w-full text-base md:text-lg font-bold rounded-full inline-flex items-center justify-center gap-2" style="padding:.9rem 1rem;">
            {{ __('home.contact.submit') }} <i class="ri-send-plane-fill text-lg md:text-xl"></i>
          </button>
<p class="text-xs text-gray-400 mt-3 md:mt-4 text-center">
    <a href="{{ route('privacy-policy') }}"
       target="_blank"
       rel="noopener noreferrer"
       class="hover:text-[var(--gold)] transition duration-300 hover:underline">
        {!! __('home.contact.privacy_notice') !!}
    </a>
</p>        </form>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const serviceSelect = document.getElementById('service_id');
  const docsSection = document.getElementById('documents-section');
  const docsInput = document.getElementById('documents_input');
  const docsPreview = document.getElementById('documents-preview');

  if (!serviceSelect) return;

  function toggleDocsSection() {
    const selected = serviceSelect.options[serviceSelect.selectedIndex];
    const isDocumented = selected && selected.dataset.documented === '1';

    if (isDocumented) {
      docsSection.classList.remove('hidden');
    } else {
      docsSection.classList.add('hidden');
      docsInput.value = '';
      docsPreview.innerHTML = '';
    }
  }

  serviceSelect.addEventListener('change', toggleDocsSection);
  toggleDocsSection(); // في حال في old() قيمة محفوظة بعد فشل تحقق

  docsInput.addEventListener('change', function () {
    docsPreview.innerHTML = '';
    Array.from(docsInput.files).forEach(function (file) {
      const sizeKb = (file.size / 1024).toFixed(0);
      const item = document.createElement('div');
      item.className = 'flex items-center gap-2 text-xs bg-gray-50 border border-gray-100 rounded-xl px-3 py-2 text-[var(--teal)]';
      item.innerHTML = `<i class="ri-file-line"></i> <span class="truncate">${file.name}</span> <span class="text-gray-400 mr-auto">${sizeKb} KB</span>`;
      docsPreview.appendChild(item);
    });
  });
});
</script>
