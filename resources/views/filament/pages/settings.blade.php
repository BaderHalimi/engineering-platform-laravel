{{-- resources/views/filament/pages/settings.blade.php --}}

<x-filament-panels::page>

@if ($statusMessage)
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 4000)"
    x-show="show"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="mb-5 flex items-center gap-3 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700"
>
    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <p class="text-sm font-medium text-emerald-700 dark:text-emerald-300">{{ $statusMessage }}</p>
</div>
@endif

<div class="space-y-6" dir="rtl">

    {{-- ===== بطاقة الإعدادات العامة ===== --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">

        {{-- رأس البطاقة --}}
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">الإعدادات العامة</h2>
        </div>

        <form wire:submit="saveGeneralSettings" class="p-6 space-y-5">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- اسم الموقع --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        اسم الموقع
                    </label>
                    <input
                        type="text"
                        wire:model="site_name"
                        placeholder="اسم موقعك"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 text-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 dark:focus:border-primary-400 transition-all"
                    />
                    @error('site_name')
                        <p class="text-red-500 text-xs flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- إيميل الموقع --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        إيميل الموقع
                    </label>
                    <input
                        type="email"
                        wire:model="site_email"
                        placeholder="example@domain.com"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 text-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 dark:focus:border-primary-400 transition-all"
                        dir="ltr"
                    />
                    @error('site_email')
                        <p class="text-red-500 text-xs flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        رقم الهاتف
                    </label>
                    <input
                        type="text"
                        wire:model="phone_number"
                        placeholder="123-456-7890"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 text-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 dark:focus:border-primary-400 transition-all"
                        dir="ltr"
                    />
                    @error('phone_number')
                        <p class="text-red-500 text-xs flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>




            </div>

            {{-- عنوان الموقع --}}
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    العنوان
                </label>
                <textarea
                    wire:model="site_address"
                    rows="2"
                    placeholder="عنوان الموقع / الشركة"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 text-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 dark:focus:border-primary-400 transition-all resize-none"
                ></textarea>
                @error('site_address')
                    <p class="text-red-500 text-xs flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- اللوقو --}}
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    صورة الموقع (اللوقو)
                </label>

                <div class="flex items-center gap-4 p-4 rounded-xl border border-dashed border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">

                    {{-- الصورة الحالية — ✅ الإصلاح هنا --}}
                    @if ($current_logo_path)
                        <div class="relative group">
                            <img
                                src="{{ asset('storage/' . $current_logo_path) }}"
                                class="w-16 h-16 object-cover rounded-xl border-2 border-gray-200 dark:border-gray-600 shadow-sm"
                                alt="اللوقو الحالي"
                                onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 64 64%22><rect width=%2264%22 height=%2264%22 fill=%22%23f3f4f6%22/><text x=%2232%22 y=%2236%22 text-anchor=%22middle%22 fill=%22%239ca3af%22 font-size=%2210%22>Logo</text></svg>'"
                            />
                            <span class="absolute -top-1.5 -right-1.5 bg-emerald-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">حالي</span>
                        </div>
                    @endif

                    {{-- معاينة الصورة الجديدة --}}
                    @if ($site_logo)
                        <div class="relative">
                            <img
                                src="{{ $site_logo->temporaryUrl() }}"
                                class="w-16 h-16 object-cover rounded-xl border-2 border-primary-400 shadow-sm"
                                alt="معاينة جديدة"
                            />
                            <span class="absolute -top-1.5 -right-1.5 bg-primary-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">جديد</span>
                        </div>
                    @endif

                    <div class="flex flex-col gap-2 flex-1">
                        <label class="cursor-pointer inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition w-fit shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            اختر صورة
                            <input type="file" wire:model="site_logo" accept="image/*" class="hidden"/>
                        </label>

                        <div wire:loading wire:target="site_logo" class="text-xs text-gray-400 flex items-center gap-1">
                            <svg class="animate-spin w-3 h-3" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            جاري الرفع...
                        </div>

                        @if ($current_logo_path)
                            <button
                                type="button"
                                wire:click="removeLogo"
                                wire:confirm="هل تريد حذف الصورة الحالية؟"
                                class="text-red-500 text-xs hover:text-red-600 flex items-center gap-1 w-fit transition"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                حذف الصورة
                            </button>
                        @endif
                    </div>
                </div>

                @error('site_logo')
                    <p class="text-red-500 text-xs flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="pt-1">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="saveGeneralSettings"
                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 disabled:opacity-60 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm shadow-primary-200 dark:shadow-none"
                >
                    <span wire:loading.remove wire:target="saveGeneralSettings">حفظ الإعدادات</span>
                    <span wire:loading wire:target="saveGeneralSettings" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        جاري الحفظ...
                    </span>
                </button>
            </div>

        </form>
    </div>

    {{-- ===== بطاقة حالة الموقع ===== --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg {{ $site_active ? 'bg-emerald-50 dark:bg-emerald-900/30' : 'bg-red-50 dark:bg-red-900/30' }} flex items-center justify-center transition-colors">
                <svg class="w-4 h-4 {{ $site_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500 dark:text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">حالة الموقع</h2>
        </div>

        <div class="p-6 space-y-5">

            {{-- زر التفعيل / الإيقاف --}}
            <div class="flex items-center justify-between p-4 rounded-xl border {{ $site_active ? 'border-emerald-200 dark:border-emerald-800 bg-emerald-50/50 dark:bg-emerald-900/10' : 'border-red-200 dark:border-red-800 bg-red-50/50 dark:bg-red-900/10' }} transition-colors">
                <div>
                    <p class="text-sm font-semibold {{ $site_active ? 'text-emerald-700 dark:text-emerald-300' : 'text-red-600 dark:text-red-400' }}">
                        {{ $site_active ? '✓ الموقع يعمل بشكل طبيعي' : '✕ الموقع موقوف حالياً' }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $site_active ? 'الزوار يمكنهم الوصول إلى الموقع' : 'الزوار يرون رسالة الصيانة' }}
                    </p>
                </div>

                {{-- Toggle Switch --}}
                <button
                    type="button"
                    wire:click="toggleSiteStatus"
                    wire:loading.attr="disabled"
                    wire:target="toggleSiteStatus"
                    class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $site_active ? 'bg-emerald-500 focus:ring-emerald-400' : 'bg-gray-300 dark:bg-gray-600 focus:ring-gray-400' }}"
                >
                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow-md transition-transform {{ $site_active ? 'translate-x-1' : 'translate-x-6' }}"></span>
                </button>
            </div>

            {{-- رسالة الصيانة --}}
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    رسالة الصيانة
                </label>
                <p class="text-xs text-gray-400 mb-2">تظهر هذه الرسالة للزوار عند إيقاف الموقع</p>
                <textarea
                    wire:model="maintenance_message"
                    rows="2"
                    placeholder="الموقع تحت الصيانة حالياً، يرجى المحاولة لاحقاً."
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 text-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 dark:focus:border-primary-400 transition-all resize-none"
                ></textarea>
            </div>

            <div>
                <button
                    type="button"
                    wire:click="saveMaintenanceMessage"
                    wire:loading.attr="disabled"
                    wire:target="saveMaintenanceMessage"
                    class="inline-flex items-center gap-2 bg-gray-800 dark:bg-gray-100 hover:bg-gray-700 dark:hover:bg-white disabled:opacity-60 text-white dark:text-gray-900 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm"
                >
                    <span wire:loading.remove wire:target="saveMaintenanceMessage">حفظ الرسالة</span>
                    <span wire:loading wire:target="saveMaintenanceMessage" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        جاري الحفظ...
                    </span>
                </button>
            </div>
        </div>
    </div>

    {{-- ===== بطاقة الباك أب ===== --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">النسخ الاحتياطي</h2>
            </div>

            <button
                type="button"
                wire:click="openBackupModal"
                class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all shadow-sm shadow-primary-200 dark:shadow-none"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                إنشاء باك أب
            </button>
        </div>

        <div class="p-6 space-y-4">

            @error('backup')
                <div class="flex items-center gap-2 p-3 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 text-sm">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </div>
            @enderror

            {{-- قائمة الباك أبات --}}
            <div class="space-y-2">
                @forelse ($backupsList as $backup)
                    <div class="flex items-center justify-between p-3.5 rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-200 leading-tight">{{ $backup['name'] }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $backup['date'] }} &bull; {{ $backup['size'] }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-1">
                            <button
                                type="button"
                                wire:click="downloadBackup('{{ $backup['name'] }}')"
                                class="p-2 rounded-lg text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition"
                                title="تحميل"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </button>
                            <button
                                type="button"
                                wire:click="confirmRestoreFromServer('{{ $backup['name'] }}')"
                                class="p-2 rounded-lg text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition"
                                title="استعادة"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </button>
                            <button
                                type="button"
                                wire:click="deleteBackup('{{ $backup['name'] }}')"
                                wire:confirm="هل تريد حذف هذا الباك أب نهائياً؟"
                                class="p-2 rounded-lg text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition"
                                title="حذف"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-sm text-gray-400">لا توجد نسخ احتياطية حتى الآن</p>
                    </div>
                @endforelse
            </div>

            {{-- رفع باك أب لاستعادته --}}
            <div class="border-t border-gray-100 dark:border-gray-800 pt-5">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                    رفع ملف باك أب للاستعادة
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    <label class="cursor-pointer inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition w-fit shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                        </svg>
                        {{ $uploadedRestoreFile ? $uploadedRestoreFile->getClientOriginalName() : 'اختر ملف ZIP' }}
                        <input type="file" wire:model="uploadedRestoreFile" accept=".zip" class="hidden"/>
                    </label>

                    <button
                        type="button"
                        wire:click="confirmRestoreFromUpload"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 disabled:opacity-50 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm shadow-amber-200 dark:shadow-none"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        استعادة من الملف
                    </button>

                    <div wire:loading wire:target="uploadedRestoreFile" class="text-xs text-gray-400 flex items-center gap-1">
                        <svg class="animate-spin w-3 h-3" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        جاري الرفع...
                    </div>
                </div>

                @error('uploadedRestoreFile')
                    <p class="text-red-500 text-xs flex items-center gap-1 mt-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </div>

</div>

{{-- ===== Modal: إعدادات الباك أب ===== --}}
@if ($showBackupModal)
<div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" dir="rtl">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-6 w-full max-w-md space-y-5 border border-gray-100 dark:border-gray-800">

        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-gray-800 dark:text-gray-100">إنشاء نسخة احتياطية</h3>
        </div>

        <label class="flex items-start gap-3 p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700/50 transition">
            <input type="checkbox" wire:model="includeStorageInBackup" class="mt-0.5 rounded text-primary-500"/>
            <div>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-200">تضمين ملفات الموقع</p>
                <p class="text-xs text-gray-400 mt-0.5">يشمل الصور والمرفقات من storage — يزيد الحجم وقد يستغرق وقتاً أطول</p>
            </div>
        </label>

        <div class="flex justify-end gap-3 pt-1">
            <button type="button" wire:click="closeBackupModal" class="px-4 py-2 rounded-xl text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                إلغاء
            </button>
            <button
                type="button"
                wire:click="runBackup"
                wire:loading.attr="disabled"
                wire:target="runBackup"
                class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 disabled:opacity-50 text-white px-5 py-2 rounded-xl text-sm font-semibold transition shadow-sm"
            >
                <span wire:loading.remove wire:target="runBackup">بدء الإنشاء</span>
                <span wire:loading wire:target="runBackup" class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                    جاري الإنشاء...
                </span>
            </button>
        </div>
    </div>
</div>
@endif

{{-- ===== Modal: تحذير الاستعادة ===== --}}
@if ($showRestoreWarning)
<div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" dir="rtl">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-6 w-full max-w-lg space-y-5 border-2 border-red-400 dark:border-red-600">

        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-red-600 dark:text-red-400">تحذير: إجراء لا يمكن التراجع عنه</h3>
        </div>

        <div class="p-4 rounded-xl bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 space-y-2">
            <p class="text-sm text-gray-700 dark:text-gray-200 font-medium">هذا الإجراء سيقوم بـ:</p>
            <ul class="space-y-1.5 mt-2">
                @foreach ([
                    'حذف جميع البيانات الحالية في قاعدة البيانات بشكل نهائي',
                    'استبدالها بالكامل ببيانات الباك أب المحدد',
                    'حذف واستبدال جميع الملفات إن وُجدت بالباك أب',
                    'هذا الإجراء لا يمكن التراجع عنه إطلاقاً',
                ] as $item)
                    <li class="flex items-start gap-2 text-sm text-red-600 dark:text-red-400">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        {{ $item }}
                    </li>
                @endforeach
            </ul>
        </div>

        <p class="text-sm font-bold text-gray-800 dark:text-gray-100">هل أنت متأكد تماماً من المتابعة؟</p>

        <div class="flex justify-end gap-3">
            <button type="button" wire:click="cancelRestore" class="px-4 py-2 rounded-xl text-sm text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                إلغاء
            </button>
            <button
                type="button"
                wire:click="executeRestore"
                wire:loading.attr="disabled"
                wire:target="executeRestore"
                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 disabled:opacity-50 text-white px-5 py-2 rounded-xl text-sm font-semibold transition shadow-sm"
            >
                <span wire:loading.remove wire:target="executeRestore">نعم، نفّذ الاستعادة</span>
                <span wire:loading wire:target="executeRestore" class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                    جاري الاستعادة...
                </span>
            </button>
        </div>
    </div>
</div>
@endif

</x-filament-panels::page>
