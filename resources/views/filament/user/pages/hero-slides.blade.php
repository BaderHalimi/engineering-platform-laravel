<x-filament-panels::page>
    <div class="space-y-6" dir="rtl">
        @if ($statusMessage)
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700 dark:border-emerald-900/50 dark:bg-emerald-950/30 dark:text-emerald-300">
                {{ $statusMessage }}
            </div>
        @endif

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-base font-bold text-gray-900 dark:text-gray-100">حالة السلايدر</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">يمكنك إيقاف ظهور السلايدر من الصفحة الرئيسية بدون حذف السلايدات.</p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <label class="inline-flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800">
                        <input type="checkbox" wire:model="hero_slider_enabled" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="text-sm font-bold text-gray-700 dark:text-gray-200">
                            {{ $hero_slider_enabled ? 'مفعل' : 'متوقف' }}
                        </span>
                    </label>

                    <button type="button" wire:click="saveHeroSliderStatus" wire:loading.attr="disabled" class="inline-flex items-center justify-center rounded-xl bg-primary-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-primary-700 disabled:opacity-60">
                        حفظ الحالة
                    </button>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-4 border-b border-gray-100 px-6 py-5 dark:border-gray-800 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">سلايدر الشاشة الرئيسية</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">أضف صور أو فيديوهات لسلايدر أول سكشن في الصفحة الرئيسية. عند عدم وجود سلايدات سيختفي السكشن تلقائياً.</p>
                </div>

                <button
                    type="button"
                    wire:click="addHeroSlide"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-100 px-4 py-2.5 text-sm font-bold text-gray-700 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    إضافة سلايد
                </button>
            </div>

            <div class="space-y-5 p-6">
                @forelse ($hero_slides as $index => $slide)
                    <div wire:key="hero-slide-page-{{ $index }}" x-data="{ open: true, locale: 'ar' }" class="overflow-hidden rounded-2xl border border-gray-100 bg-gray-50/70 dark:border-gray-800 dark:bg-gray-800/50">
                        <div @click="open = !open" class="flex cursor-pointer flex-col gap-3 px-5 py-4 transition hover:bg-gray-100 dark:hover:bg-gray-700 md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center gap-3">
                                <span class="rounded-full bg-primary-50 px-3 py-1 text-xs font-bold text-primary-700 dark:bg-primary-950/40 dark:text-primary-300">سلايد #{{ $index + 1 }}</span>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $slide['title']['ar'] ?? 'سلايد جديد' }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="button" wire:click.stop="moveHeroSlide({{ $index }}, 'up')" class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-200 dark:hover:bg-gray-700">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                </button>
                                <button type="button" wire:click.stop="moveHeroSlide({{ $index }}, 'down')" class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-200 dark:hover:bg-gray-700">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <button type="button" wire:click.stop="removeHeroSlide({{ $index }})" wire:confirm="هل تريد حذف هذا السلايد؟" class="rounded-lg p-1.5 text-red-400 transition hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                <span class="text-gray-400 transition" :class="open ? 'rotate-180' : ''">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </span>
                            </div>
                        </div>

                        <div x-show="open" class="space-y-5 border-t border-gray-100 p-5 dark:border-gray-700">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">نوع الوسيط</label>
                                    <select wire:model="hero_slides.{{ $index }}.type" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-gray-700 dark:bg-gray-900">
                                        <option value="image">صورة</option>
                                        <option value="video">فيديو</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">رفع صورة أو فيديو</label>
                                    <input type="file" wire:model="hero_slide_uploads.{{ $index }}" accept="image/*,video/mp4,video/webm,video/ogg" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900"/>
                                    <div wire:loading wire:target="hero_slide_uploads.{{ $index }}" class="text-xs text-gray-400">جاري الرفع...</div>
                                    @if (!empty($slide['media_path']))
                                        <p class="mt-1 text-xs text-gray-400" dir="ltr">{{ $slide['media_path'] }}</p>
                                    @endif
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">مسار/رابط يدوي اختياري</label>
                                    <input type="text" wire:model="hero_slides.{{ $index }}.media_path" dir="ltr" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-gray-700 dark:bg-gray-900"/>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">رابط الزر</label>
                                    <input type="text" wire:model="hero_slides.{{ $index }}.button_url" dir="ltr" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-gray-700 dark:bg-gray-900"/>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <label class="whitespace-nowrap text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">اللغة:</label>
                                <select x-model="locale" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900">
                                    <option value="ar">العربية</option>
                                    <option value="en">English</option>
                                    <option value="fr">Francais</option>
                                </select>
                            </div>

                            @foreach (['ar' => 'العربية', 'en' => 'English', 'fr' => 'Francais'] as $loc => $label)
                                <div x-show="locale === '{{ $loc }}'" x-cloak class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">العنوان ({{ $label }})</label>
                                        <input type="text" wire:model="hero_slides.{{ $index }}.title.{{ $loc }}" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-gray-700 dark:bg-gray-900"/>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">نص الزر ({{ $label }})</label>
                                        <input type="text" wire:model="hero_slides.{{ $index }}.button_text.{{ $loc }}" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-gray-700 dark:bg-gray-900"/>
                                    </div>

                                    <div class="space-y-1.5 md:col-span-2">
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">الوصف ({{ $label }})</label>
                                        <textarea wire:model="hero_slides.{{ $index }}.description.{{ $loc }}" rows="3" class="w-full resize-y rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-gray-700 dark:bg-gray-900"></textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-gray-200 py-16 text-center dark:border-gray-700">
                        <p class="text-sm text-gray-400">لا توجد سلايدات بعد. عند عدم وجود سلايدات سيختفي سكشن السلايدر من الصفحة الرئيسية.</p>
                    </div>
                @endforelse
            </div>

            <div class="border-t border-gray-100 p-6 dark:border-gray-800">
                <button type="button" wire:click="saveHeroSlides" wire:loading.attr="disabled" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-primary-700 disabled:opacity-60">
                    <span wire:loading.remove>حفظ السلايدر</span>
                    <span wire:loading class="flex items-center gap-2">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
</x-filament-panels::page>
