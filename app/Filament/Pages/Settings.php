<?php
// app/Filament/Pages/Settings.php

namespace App\Filament\Pages;

use App\Models\Setup;
use App\Services\BackupService;
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
        $this->current_logo_path = Setup::get('site_logo_path', null);
        $this->site_active = (bool) Setup::get('site_active', true);
        $this->maintenance_message = Setup::get('maintenance_message', 'الموقع تحت الصيانة حالياً، يرجى المحاولة لاحقاً.');

        $this->refreshBackupsList();
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
    public function removeLogo(): void
    {
        if ($this->current_logo_path && Storage::disk('public')->exists($this->current_logo_path)) {
            Storage::disk('public')->delete($this->current_logo_path);
        }

        Setup::set('site_logo_path', null);
        $this->current_logo_path = null;

        $this->statusMessage = 'تم حذف الصورة.';
    }

    // ===== دوال الباك أب =====

    /**
     * فتح نافذة اختيار storage عند الضغط على "عمل باك أب"
     */
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

    /**
     * التنفيذ الفعلي للاستعادة بعد تأكيد التحذير
     * (سيُربط بـ OTP بالخطوة الجاية)
     */
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
