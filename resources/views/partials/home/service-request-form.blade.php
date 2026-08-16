@php
  $selectedServiceId = old('service_id', $selectedServiceId ?? null);
@endphp

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
            {{ (string) $selectedServiceId === (string) $svc->id ? 'selected' : '' }}
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

  <div id="documents-section" class="mb-4 md:mb-5 hidden">
    <label class="block text-sm font-bold text-[var(--teal)] mb-2">
      {{ __('home.contact.documents') }}
      <span class="text-xs font-normal text-gray-400">({{ __('home.contact.documents_hint') }})</span>
    </label>

    <label for="documents_input" class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 rounded-2xl p-6 cursor-pointer hover:border-[var(--gold)] hover:bg-gray-50 transition">
      <i class="ri-upload-cloud-2-line text-3xl text-[var(--teal)]"></i>
      <span class="text-sm font-semibold text-[var(--teal)]">{{ __('home.contact.upload_click') }}</span>
      <span class="text-xs text-gray-400">PDF, JPG, PNG - {{ __('home.contact.max_size') }} 5MB</span>
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
  </p>
</form>

@once
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const serviceSelect = document.getElementById('service_id');
        const docsSection = document.getElementById('documents-section');
        const docsInput = document.getElementById('documents_input');
        const docsPreview = document.getElementById('documents-preview');

        if (!serviceSelect || !docsSection || !docsInput || !docsPreview) return;

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
        toggleDocsSection();

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
  @endpush
@endonce
