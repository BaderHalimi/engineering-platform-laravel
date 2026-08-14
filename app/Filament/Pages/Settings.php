<?php
// app/Filament/Pages/Settings.php

namespace App\Filament\Pages;

use App\Models\Setup;
use App\Services\BackupService;
use App\Services\SitemapService;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Settings extends Page
{
    use WithFileUploads;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'الإعدادات';

    protected static ?string $title = 'الإعدادات';

    protected static ?int $navigationSort = 100;

    protected string $view = 'filament.pages.settings';

    // ===== حقول الإعدادات العامة (من قبل) =====

    #[Validate('required|string|max:255')]
    public string $site_name = '';

    #[Validate('nullable|email|max:255')]
    public string $site_email = '';

    #[Validate('nullable|string|max:500')]
    public string $site_address = '';

    public string $phone_number = '';



    #[Validate('nullable|image|max:2048')]
    public $site_logo = null;

    public ?string $current_logo_path = null;

    public bool $site_active = true;

    public ?string $maintenance_message = null;

    public ?string $statusMessage = null;

    public ?string $sitemapLastGenerated = null;

    public ?int $sitemapUrlCount = null;

    // ===== حقول المحتوى النصي =====

public array $terms_and_conditions = [];

    public array $privacy_policy = [];

    #[Validate('nullable|string|max:255')]
    public string $top_notice = '';

    #[Validate('nullable|string|max:255')]
    public string $working_hours = '';

    #[Validate('nullable|string')]
    public string $included_cdn = '';

    // ===== المجموعات JSON =====

    public array $locales = ['ar', 'en', 'fr'];

    protected array $jsonSchemas = [
        'why_aldiwan' => ['icon' => 'required|string|max:255', 'title' => 'translatable|string|max:255', 'description' => 'translatable|string'],
        'work_steps' => ['step' => 'required|string|max:255', 'icon' => 'required|string|max:255', 'title' => 'translatable|string|max:255', 'description' => 'translatable|string'],
        'about_us' => ['title' => 'translatable|string|max:255', 'description' => 'translatable|string'],
        'marquee' => ['icon' => 'required|string|max:255', 'title' => 'translatable|string|max:255', 'description' => 'translatable|string'],
        'social_links' => ['icon' => 'required|string|max:255', 'name' => 'translatable|string|max:255', 'url' => 'required|url'],
    ];

    public array $why_aldiwan = [];
    public array $work_steps = [];
    public array $about_us = [];
    public array $marquee = [];
    public array $social_links = [];
    public array $hero_slides = [];
    public array $hero_slide_uploads = [];

    // ===== خصائص الباك أب =====

    public bool $showBackupModal = false;       // نافذة اختيار storage
    public bool $includeStorageInBackup = false; // اختيار المستخدم
    public bool $isBackingUp = false;            // حالة التحميل
    public array $backupsList = [];              // قائمة الباك أبات

    public bool $showRestoreWarning = false;     // نافذة تحذير الاستعادة
    public ?string $pendingRestoreFile = null;   // اسم الملف بانتظار التأكيد (من السيرفر)
    public $uploadedRestoreFile = null;

    public function mount(): void
    {
        $this->site_name = Setup::get('site_name', '');
        $this->site_email = Setup::get('site_email', '');
        $this->site_address = Setup::get('site_address', '');
        $this->phone_number = Setup::get('phone_number', '');
        $this->current_logo_path = Setup::get('site_logo_path', null);
        $this->site_active = (bool) Setup::get('site_active', true);
        $this->maintenance_message = Setup::get('maintenance_message', 'الموقع تحت الصيانة حالياً، يرجى المحاولة لاحقاً.');

        $this->terms_and_conditions = array_merge(
            array_fill_keys($this->locales, ''),
            json_decode(Setup::get('terms_and_conditions', '{}'), true) ?: []
        );
        $this->privacy_policy = array_merge(
            array_fill_keys($this->locales, ''),
            json_decode(Setup::get('privacy_policy', '{}'), true) ?: []
        );
        $this->top_notice = Setup::get('top_notice', '');
        $this->working_hours = Setup::get('working_hours', '');
        $this->included_cdn = Setup::get('included_cdn', '');

        foreach (array_keys($this->jsonSchemas) as $collection) {
            $items = json_decode(Setup::get($collection, '[]'), true) ?: [];
            $this->{$collection} = array_map(fn ($item) => $this->normalizeJsonItem($collection, $item), $items);
        }

        $this->hero_slides = array_map(
            fn ($item) => $this->normalizeHeroSlide($item),
            json_decode(Setup::get('hero_slides', '[]'), true) ?: []
        );

        $this->refreshBackupsList();
        $this->refreshSitemapInfo();
    }

    protected function normalizeHeroSlide(array $item): array
    {
        return [
            'type' => in_array($item['type'] ?? 'image', ['image', 'video'], true) ? $item['type'] : 'image',
            'media_path' => $item['media_path'] ?? '',
            'title' => array_merge(array_fill_keys($this->locales, ''), is_array($item['title'] ?? null) ? $item['title'] : []),
            'description' => array_merge(array_fill_keys($this->locales, ''), is_array($item['description'] ?? null) ? $item['description'] : []),
            'button_text' => array_merge(array_fill_keys($this->locales, ''), is_array($item['button_text'] ?? null) ? $item['button_text'] : []),
            'button_url' => $item['button_url'] ?? '',
        ];
    }

    protected function normalizeJsonItem(string $collection, array $item): array
    {
        foreach ($this->jsonSchemas[$collection] as $field => $rule) {
            if (str_starts_with($rule, 'translatable|')) {
                $current = is_array($item[$field] ?? null) ? $item[$field] : [];
                $item[$field] = array_merge(array_fill_keys($this->locales, ''), $current);
            } else {
                $item[$field] = $item[$field] ?? '';
            }
        }

        return $item;
    }


    public function saveGeneralSettings(): void
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'nullable|email|max:255',
            'site_address' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:20',
            'site_logo' => 'nullable|image|max:2048',
        ]);

        Setup::set('site_name', $this->site_name);
        Setup::set('site_email', $this->site_email);
        Setup::set('site_address', $this->site_address);
        Setup::set('phone_number', $this->phone_number);

        if ($this->site_logo instanceof UploadedFile) {
            if ($this->current_logo_path && Storage::disk('public')->exists($this->current_logo_path)) {
                Storage::disk('public')->delete($this->current_logo_path);
            }

            $path = $this->site_logo->store('site', 'public');
            Setup::set('site_logo_path', $path);
            $this->current_logo_path = $path;
            $this->site_logo = null;
        }

        $this->statusMessage = 'تم حفظ الإعدادات بنجاح.';
    }

    public function toggleSiteStatus(): void
    {
        $this->site_active = !$this->site_active;
        Setup::set('site_active', $this->site_active ? '1' : '0');

        $this->statusMessage = $this->site_active
            ? 'تم تفعيل الموقع.'
            : 'تم إيقاف الموقع.';
    }

    public function saveMaintenanceMessage(): void
    {
        $this->validate([
            'maintenance_message' => 'nullable|string|max:500',
        ]);

        Setup::set('maintenance_message', $this->maintenance_message);
        $this->statusMessage = 'تم حفظ رسالة الصيانة.';
    }
    public function regenerateSitemap(): void
    {
        try {
            $result = app(SitemapService::class)->writePublicFile();

            $this->sitemapUrlCount = $result['url_count'];
            $this->sitemapLastGenerated = $result['generated_at']->format('Y-m-d H:i');
            $this->statusMessage = "تم توليد السايتماب بنجاح ({$this->sitemapUrlCount} رابط).";
        } catch (\Throwable $e) {
            $this->addError('sitemap', 'فشل توليد السايتماب: ' . $e->getMessage());
        }
    }

    public function refreshSitemapInfo(): void
    {
        $this->sitemapLastGenerated = app(SitemapService::class)->publicFileGeneratedAt();
    }

    public function removeLogo(): void
    {
        if ($this->current_logo_path && Storage::disk('public')->exists($this->current_logo_path)) {
            Storage::disk('public')->delete($this->current_logo_path);
        }

        Setup::set('site_logo_path', null);
        $this->current_logo_path = null;

        $this->statusMessage = 'تم حذف الصورة.';
    }

public function saveContentSettings(): void
    {
        $rules = [
            'top_notice' => 'nullable|string|max:255',
            'working_hours' => 'nullable|string|max:255',
            'included_cdn' => 'nullable|string',
        ];

        foreach ($this->locales as $locale) {
            $rules["terms_and_conditions.{$locale}"] = ($locale === 'ar' ? 'required|' : 'nullable|') . 'string';
            $rules["privacy_policy.{$locale}"] = ($locale === 'ar' ? 'required|' : 'nullable|') . 'string';
        }

        $this->validate($rules);

        foreach (['top_notice', 'working_hours', 'included_cdn'] as $field) {
            Setup::set($field, $this->$field);
        }

        Setup::set('terms_and_conditions', json_encode($this->terms_and_conditions, JSON_UNESCAPED_UNICODE));
        Setup::set('privacy_policy', json_encode($this->privacy_policy, JSON_UNESCAPED_UNICODE));

        $this->statusMessage = 'تم حفظ المحتوى بنجاح.';
    }

    public function addJsonItem(string $collection): void
    {
        $item = [];

        foreach ($this->jsonSchemas[$collection] as $field => $rule) {
            $item[$field] = str_starts_with($rule, 'translatable|') ? array_fill_keys($this->locales, '') : '';
        }

        $this->{$collection}[] = $item;
    }

    public function removeJsonItem(string $collection, int $index): void
    {
        $items = $this->{$collection};
        unset($items[$index]);
        $this->{$collection} = array_values($items);
    }

    public function moveJsonItem(string $collection, int $index, string $direction): void
    {
        $items = $this->{$collection};
        $target = $direction === 'up' ? $index - 1 : $index + 1;

        if (!isset($items[$index]) || !isset($items[$target])) {
            return;
        }

        [$items[$index], $items[$target]] = [$items[$target], $items[$index]];
        $this->{$collection} = $items;
    }

    public function saveJsonCollection(string $collection): void
    {
        $rules = [$collection => 'array'];

        foreach ($this->jsonSchemas[$collection] as $field => $rule) {
            if (str_starts_with($rule, 'translatable|')) {
                $baseRule = substr($rule, strlen('translatable|'));

                foreach ($this->locales as $locale) {
                    $rules["{$collection}.*.{$field}.{$locale}"] = ($locale === 'ar' ? 'required|' : 'nullable|') . $baseRule;
                }
            } else {
                $rules["{$collection}.*.{$field}"] = $rule;
            }
        }

        $this->validate($rules);
        Setup::set($collection, json_encode($this->{$collection}, JSON_UNESCAPED_UNICODE));
        $this->statusMessage = 'تم حفظ البيانات بنجاح.';
    }

    // ===== دوال الباك أب =====

    /**
     * فتح نافذة اختيار storage عند الضغط على "عمل باك أب"
     */
    public function addHeroSlide(): void
    {
        $this->hero_slides[] = $this->normalizeHeroSlide([]);
    }

    public function removeHeroSlide(int $index): void
    {
        unset($this->hero_slides[$index], $this->hero_slide_uploads[$index]);
        $this->hero_slides = array_values($this->hero_slides);
        $this->hero_slide_uploads = array_values($this->hero_slide_uploads);
    }

    public function moveHeroSlide(int $index, string $direction): void
    {
        $target = $direction === 'up' ? $index - 1 : $index + 1;

        if (!isset($this->hero_slides[$index]) || !isset($this->hero_slides[$target])) {
            return;
        }

        [$this->hero_slides[$index], $this->hero_slides[$target]] = [$this->hero_slides[$target], $this->hero_slides[$index]];
        [$this->hero_slide_uploads[$index], $this->hero_slide_uploads[$target]] = [$this->hero_slide_uploads[$target] ?? null, $this->hero_slide_uploads[$index] ?? null];
    }

    public function saveHeroSlides(): void
    {
        $rules = [
            'hero_slides' => 'array',
            'hero_slides.*.type' => 'required|in:image,video',
            'hero_slides.*.media_path' => 'nullable|string|max:500',
            'hero_slides.*.button_url' => 'nullable|string|max:500',
            'hero_slide_uploads.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,webm,ogg|max:51200',
        ];

        foreach ($this->locales as $locale) {
            $rules["hero_slides.*.title.{$locale}"] = 'nullable|string|max:255';
            $rules["hero_slides.*.description.{$locale}"] = 'nullable|string|max:1000';
            $rules["hero_slides.*.button_text.{$locale}"] = 'nullable|string|max:80';
        }

        $this->validate($rules);

        foreach ($this->hero_slide_uploads as $index => $upload) {
            if ($upload instanceof UploadedFile) {
                $this->hero_slides[$index]['media_path'] = $upload->store('hero-slides', 'public');
            }
        }

        $slides = collect($this->hero_slides)
            ->map(fn ($item) => $this->normalizeHeroSlide($item))
            ->filter(fn ($item) => filled($item['media_path']))
            ->values()
            ->all();

        Setup::set('hero_slides', json_encode($slides, JSON_UNESCAPED_UNICODE));

        $this->hero_slides = $slides;
        $this->hero_slide_uploads = [];
        $this->statusMessage = 'تم حفظ سلايدر الشاشة الرئيسية بنجاح.';
    }

    public function openBackupModal(): void
    {
        $this->includeStorageInBackup = false;
        $this->showBackupModal = true;
    }

    public function closeBackupModal(): void
    {
        $this->showBackupModal = false;
    }

    /**
     * تنفيذ عملية الباك أب الفعلية (متزامن)
     */
    public function runBackup(): void
    {
        $this->isBackingUp = true;

        try {
            $service = new BackupService();
            $fileName = $service->create($this->includeStorageInBackup);

            $this->statusMessage = "تم إنشاء الباك أب بنجاح: {$fileName}";
            $this->refreshBackupsList();

        } catch (\Throwable $e) {
            $this->statusMessage = null;
            $this->addError('backup', 'فشل إنشاء الباك أب: ' . $e->getMessage());
        } finally {
            $this->isBackingUp = false;
            $this->showBackupModal = false;
        }
    }

    /**
     * تحديث قائمة الباك أبات المعروضة
     */
    public function refreshBackupsList(): void
    {
        $service = new BackupService();
        $this->backupsList = $service->list();
    }

    /**
     * تحميل باك أب معيّن لجهاز المستخدم
     */
    public function downloadBackup(string $fileName)
    {
        $service = new BackupService();
        $fullPath = $service->getFullPath($fileName);

        if (!$fullPath) {
            $this->addError('backup', 'الملف غير موجود.');
            return;
        }

        return response()->download($fullPath);
    }

    /**
     * حذف باك أب من القائمة
     */
    public function deleteBackup(string $fileName): void
    {
        $service = new BackupService();
        $service->delete($fileName);

        $this->statusMessage = 'تم حذف الباك أب.';
        $this->refreshBackupsList();
    }

    // ===== دوال الاستعادة =====

    /**
     * الضغط على "استعادة" لباك أب من القائمة (السيرفر) → يفتح تحذير
     */
    public function confirmRestoreFromServer(string $fileName): void
    {
        $this->pendingRestoreFile = $fileName;
        $this->uploadedRestoreFile = null;
        $this->showRestoreWarning = true;
    }

    /**
     * الضغط على "استعادة" لملف مرفوع من الجهاز → يفتح تحذير
     */
    public function confirmRestoreFromUpload(): void
    {
        $this->validate([
            'uploadedRestoreFile' => 'required|file|mimes:zip|max:512000', // 500MB كحد أقصى
        ]);

        $this->pendingRestoreFile = null;
        $this->showRestoreWarning = true;
    }

    public function cancelRestore(): void
    {
        $this->showRestoreWarning = false;
        $this->pendingRestoreFile = null;
        $this->uploadedRestoreFile = null;
    }


    public function executeRestore(): void
    {
        try {
            $service = new BackupService();

            if ($this->uploadedRestoreFile) {
                // استعادة من ملف مرفوع
                $tempPath = $this->uploadedRestoreFile->getRealPath();
                $service->restore($tempPath);
            } elseif ($this->pendingRestoreFile) {
                // استعادة من ملف موجود بالسيرفر
                $fullPath = $service->getFullPath($this->pendingRestoreFile);

                if (!$fullPath) {
                    throw new \Exception('ملف الباك أب غير موجود.');
                }

                $service->restore($fullPath);
            } else {
                throw new \Exception('لم يتم تحديد ملف للاستعادة.');
            }

            $this->statusMessage = 'تمت استعادة الباك أب بنجاح. يفضل تسجيل الخروج والدخول مجدداً.';

        } catch (\Throwable $e) {
            $this->addError('restore', 'فشلت عملية الاستعادة: ' . $e->getMessage());
        } finally {
            $this->showRestoreWarning = false;
            $this->pendingRestoreFile = null;
            $this->uploadedRestoreFile = null;
            $this->mount(); // إعادة تحميل كل القيم بعد الاستعادة المحتملة
        }
    }
}
