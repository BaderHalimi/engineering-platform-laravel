<x-filament-panels::page>

<style>
  /* إخفاء header الصفحة الافتراضي */
  .fi-page-header { display: none !important; }

  /* إخفاء section headers الافتراضية */
  .fi-section-header { display: none !important; }

  /* إخفاء أزرار Filament الافتراضية */
  .fi-page-footer { display: none !important; }

  /* تنسيق الـ inputs */
  .fi-input-wrp, .fi-input {
    border-radius: 0.75rem !important;
    border-color: #eef2f3 !important;
    box-shadow: 0 4px 20px rgba(82,105,112,0.12) !important;
    color: #526970 !important;
  }

  .fi-input:focus {
    border-color: #526970 !important;
    box-shadow: 0 0 0 2px rgba(82,105,112,0.2) !important;
  }

  /* labels */
  .fi-fo-field-wrp-label label {
    color: #526970 !important;
    font-weight: 500 !important;
    font-size: 0.875rem !important;
  }

  /* FileUpload */
  .fi-fo-file-upload {
    display: none !important;
  }

  /* إزالة borders من sections */
  .fi-section {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
  }

  .fi-section-content {
    padding: 0 !important;
  }
</style>

<form wire:submit="save" class="flex flex-col gap-6 w-full max-w-2xl mx-auto py-8">

  <!-- ====== البوكس الأول: الصورة + الاسم + الايميل ====== -->
  <div class="rounded-3xl p-8 flex flex-col gap-6"
       style="background: transparent;">

    <!-- بوكس الصورة من قاعدة البيانات -->
    <div class="rounded-2xl px-6 py-4 flex items-center gap-5"
         style="background: transparent;">

      <div class="w-16 h-16 rounded-full overflow-hidden shadow-md shrink-0"
           style="border: 4px solid #526970;">
        @if(Auth::user()->profile_image)
          <img src="{{ Storage::url(Auth::user()->profile_image) }}"
               alt="profile" class="w-full h-full object-cover"/>
        @else
          <div class="w-full h-full flex items-center justify-center text-white text-xl font-bold"
               style="background-color: #526970;">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </div>
        @endif
      </div>

      <div>
        <p class="font-semibold" style="color: #526970;">Upload a New Photo</p>
        <p class="text-sm" style="color: #526970; opacity: 0.6;">Profile-pic.jpg</p>
      </div>

      <label class="ml-auto px-5 py-2 rounded-xl text-sm font-medium cursor-pointer"
             style="border: 2px solid #526970; color: #526970; background: white;">
        Update
        {{-- FileUpload مخفي يتحكم فيه الزر --}}
        <div class="hidden">
          {{ $this->form->getComponent('profile_image') ?? '' }}
        </div>
      </label>

    </div>

    <!-- العنوان -->
    <h2 class="text-2xl font-bold" style="color: #526970;">Change your info</h2>

    <!-- Full Name + Email من الفورم مباشرة -->
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="text-sm mb-1 block" style="color: #526970;">Full Name <span style="color:#f5ad2a;">*</span></label>
        <input type="text"
               wire:model="data.name"
               class="w-full rounded-xl px-4 py-3 text-sm outline-none"
               style="background: transparent; color:#526970; box-shadow:0 4px 20px rgba(82,105,112,0.12); border:1.5px solid #eef2f3;"/>
        @error('data.name')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div>
        <label class="text-sm mb-1 block" style="color: #526970;">Email Address <span style="color:#f5ad2a;">*</span></label>
        <input type="email"
               wire:model="data.email"
               class="w-full rounded-xl px-4 py-3 text-sm outline-none"
               style="background: transparent; color:#526970; box-shadow:0 4px 20px rgba(82,105,112,0.12); border:1.5px solid #eef2f3;"/>
        @error('data.email')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>
    </div>

  </div>

  <!-- ====== البوكس الثاني: كلمات المرور ====== -->
  <div class="rounded-3xl p-8 flex flex-col gap-6"
       style="background: transparent;">

    <!-- عنوان القسم -->
    <div>
      <h3 class="text-lg font-bold" style="color: #526970;">Update Password</h3>
      <p class="text-sm mt-1" style="color: #526970; opacity: 0.6;">
        Leave the password fields blank if you don't want to change it.
      </p>
    </div>

    <!-- الباسوردات -->
    <div class="grid grid-cols-2 gap-4">

      <div>
        <label class="text-sm mb-1 block" style="color: #526970;">Current Password</label>
        <input type="password"
               wire:model="data.current_password"
               placeholder="••••••••"
               class="w-full rounded-xl px-4 py-3 text-sm outline-none"
               style="background: transparent; color:#526970; box-shadow:0 4px 20px rgba(82,105,112,0.12); border:1.5px solid #eef2f3;"/>
        @error('data.current_password')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="text-sm mb-1 block" style="color: #526970;">New Password</label>
        <input type="password"
               wire:model="data.new_password"
               placeholder="••••••••"
               class="w-full rounded-xl px-4 py-3 text-sm outline-none"
               style="background: transparent; color:#526970; box-shadow:0 4px 20px rgba(82,105,112,0.12); border:1.5px solid #eef2f3;"/>
        @error('data.new_password')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="col-span-2">
        <label class="text-sm mb-1 block" style="color: #526970;">Confirm New Password</label>
        <input type="password"
               wire:model="data.new_password_confirmation"
               placeholder="••••••••"
               class="w-full rounded-xl px-4 py-3 text-sm outline-none"
               style="background: transparent; color:#526970; box-shadow:0 4px 20px rgba(82,105,112,0.12); border:1.5px solid #eef2f3;"/>
      </div>

    </div>

    <!-- أزرار الحفظ والإلغاء -->
    <div class="flex gap-4">
      <button type="submit"
              class="flex-1 py-3 rounded-xl font-semibold text-sm transition hover:opacity-90"
              style="background-color: #f5ad2a; color: #ffffff;">
        Save Changes
      </button>
      <a href="{{ \App\Filament\User\Pages\ProfileSettings::getUrl() }}"
         class="flex-1 py-3 rounded-xl font-semibold text-sm text-center transition hover:opacity-90"
         style="border: 2px solid #526970; color: #526970; background: transparent;">
        Cancel
      </a>
    </div>

  </div>

</form>
<script>
function handlePhotoChange(input) {
  if (!input.files || !input.files[0]) return;

  const file = input.files[0];

  // Preview الصورة فوراً
  const reader = new FileReader();
  reader.onload = function(e) {
    const preview = document.getElementById('avatar-preview');
    if (preview.tagName === 'IMG') {
      preview.src = e.target.result;
    } else {
      // كان div بالحرف الأول، نحوله لـ img
      const img = document.createElement('img');
      img.src = e.target.result;
      img.id = 'avatar-preview';
      img.style = 'width:100%;height:100%;object-fit:cover;';
      preview.replaceWith(img);
    }
    document.getElementById('photo-name').textContent = file.name;
  };
  reader.readAsDataURL(file);

  // رفع الملف لـ Livewire عبر الـ FileUpload المخفي
  const filamentInput = document.querySelector('#profile-upload input[type=file]');
  if (filamentInput) {
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    filamentInput.files = dataTransfer.files;
    filamentInput.dispatchEvent(new Event('change', { bubbles: true }));
  }
}
</script>


</x-filament-panels::page>
