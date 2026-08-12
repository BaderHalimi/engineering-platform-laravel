<?php
// app/Services/BackupService.php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ZipArchive;

class BackupService
{
    protected string $disk = 'local'; // storage/app
    protected string $backupDir = 'backups';

    public function __construct()
    {
        if (!Storage::disk($this->disk)->exists($this->backupDir)) {
            Storage::disk($this->disk)->makeDirectory($this->backupDir);
        }
    }

    /**
     * إنشاء باك أب كامل (SQL + اختياري Storage) في ملف ZIP واحد
     *
     * @param bool $withStorage تضمين مجلد storage/app/public أو لا
     * @return string اسم الملف الناتج (بدون مسار)
     */
    public function create(bool $withStorage = false): string
    {
        $timestamp = now()->format('Y_m_d_His');
        $zipFileName = "backup_{$timestamp}.zip";
        $tmpDir = storage_path('app/tmp_backup_' . Str::random(8));

        File::makeDirectory($tmpDir, 0755, true);

        try {
            // 1) توليد ملف SQL
            $sqlPath = $tmpDir . '/database.sql';
            $this->dumpDatabase($sqlPath);

            // 2) التأكد من وجود مجلد backups وصلاحياته
            $backupFullDir = storage_path('app/' . $this->backupDir);
            if (!is_dir($backupFullDir)) {
                mkdir($backupFullDir, 0755, true);
            }
            if (!is_writable($backupFullDir)) {
                throw new \Exception("مجلد الباك أب غير قابل للكتابة: {$backupFullDir}");
            }

            // 3) إنشاء ZIP مع التحقق من النتيجة
            $zipFullPath = $backupFullDir . '/' . $zipFileName;
            $zip = new ZipArchive();
            $result = $zip->open($zipFullPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            if ($result !== true) {
                $errors = [
                    ZipArchive::ER_EXISTS => 'الملف موجود مسبقاً',
                    ZipArchive::ER_INCONS => 'الملف غير متسق',
                    ZipArchive::ER_INVAL  => 'وسيطة غير صالحة',
                    ZipArchive::ER_MEMORY => 'خطأ في الذاكرة',
                    ZipArchive::ER_NOENT  => 'المسار غير موجود',
                    ZipArchive::ER_NOZIP  => 'ليس ملف ZIP',
                    ZipArchive::ER_OPEN   => 'تعذّر فتح الملف — تحقق من الصلاحيات',
                    ZipArchive::ER_READ   => 'خطأ في القراءة',
                    ZipArchive::ER_SEEK   => 'خطأ في التنقل',
                ];
                $reason = $errors[$result] ?? "كود الخطأ: {$result}";
                throw new \Exception("فشل إنشاء ملف ZIP: {$reason}");
            }

            // إضافة SQL
            $zip->addFile($sqlPath, 'database.sql');

            // إضافة meta.json
            $meta = [
                'created_at'      => now()->toDateTimeString(),
                'with_storage'    => $withStorage,
                'laravel_version' => app()->version(),
                'app_name'        => config('app.name'),
            ];
            $zip->addFromString('meta.json', json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // إضافة storage لو مطلوب
            if ($withStorage) {
                $this->addFolderToZip($zip, storage_path('app/public'), 'storage');
            }

            $zip->close();

            return $zipFileName;
        } finally {
            File::deleteDirectory($tmpDir);
        }
    }

    /**
     * تفريغ قاعدة البيانات إلى ملف SQL
     * يحاول mysqldump أولاً، وإذا فشل يستخدم fallback بـ PHP
     */
    protected function dumpDatabase(string $outputPath): void
    {
        if ($this->tryMysqldump($outputPath)) {
            return;
        }

        // Fallback: توليد SQL يدوياً عبر PHP
        $this->dumpDatabaseWithPhp($outputPath);
    }

    /**
     * محاولة استخدام mysqldump (لو متوفر بالسيرفر)
     */
    protected function tryMysqldump(string $outputPath): bool
    {
        $connection = config('database.default');
        $config = config("database.connections.{$connection}");

        if (($config['driver'] ?? null) !== 'mysql') {
            return false; // mysqldump فقط لقواعد MySQL
        }

        $host = $config['host'] ?? '127.0.0.1';
        $port = $config['port'] ?? 3306;
        $database = $config['database'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';

        // تأكد إن mysqldump موجود فعلاً بالنظام
        $checkCommand = stripos(PHP_OS, 'WIN') === 0 ? 'where mysqldump' : 'command -v mysqldump';
        exec($checkCommand, $output, $exitCode);

        if ($exitCode !== 0) {
            return false; // mysqldump غير متوفر
        }

        $passwordPart = $password !== '' ? '-p' . escapeshellarg($password) : '';

        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s %s %s > %s 2>&1',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            $passwordPart,
            escapeshellarg($database),
            escapeshellarg($outputPath)
        );

        exec($command, $execOutput, $exitCode);

        // تأكد إن الملف تولد فعلاً وفيه محتوى منطقي
        if ($exitCode === 0 && file_exists($outputPath) && filesize($outputPath) > 50) {
            return true;
        }

        // فشل، احذف أي ملف ناقص
        if (file_exists($outputPath)) {
            @unlink($outputPath);
        }

        return false;
    }

    /**
     * توليد SQL بديل بـ PHP لو ما توفر mysqldump
     * (يدعم MySQL — يولد CREATE TABLE + INSERT لكل جدول)
     */
    protected function dumpDatabaseWithPhp(string $outputPath): void
    {
        $tables = DB::select('SHOW TABLES');
        $databaseName = config('database.connections.' . config('database.default') . '.database');
        $tableKey = "Tables_in_{$databaseName}";

        $sql = "-- Generated PHP Fallback SQL Dump\n";
        $sql .= "-- Date: " . now()->toDateTimeString() . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        $handle = fopen($outputPath, 'w');
        fwrite($handle, $sql);

        foreach ($tables as $tableRow) {
            $tableName = $tableRow->{$tableKey} ?? array_values((array) $tableRow)[0];

            // بنية الجدول
            $createStatement = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $createSql = $createStatement[0]->{'Create Table'} ?? null;

            if ($createSql) {
                fwrite($handle, "DROP TABLE IF EXISTS `{$tableName}`;\n");
                fwrite($handle, $createSql . ";\n\n");
            }

            // البيانات (على دفعات لتفادي استهلاك الذاكرة)
            DB::table($tableName)->orderBy(DB::raw('1'))->chunk(500, function ($rows) use ($handle, $tableName) {
                foreach ($rows as $row) {
                    $rowArray = (array) $row;
                    $columns = array_map(fn($col) => "`{$col}`", array_keys($rowArray));
                    $values = array_map(function ($value) {
                        if (is_null($value)) {
                            return 'NULL';
                        }
                        return DB::connection()->getPdo()->quote((string) $value);
                    }, array_values($rowArray));

                    $insertSql = "INSERT INTO `{$tableName}` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");\n";
                    fwrite($handle, $insertSql);
                }
            });

            fwrite($handle, "\n");
        }

        fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
        fclose($handle);
    }

    /**
     * إضافة مجلد كامل لملف ZIP بشكل متكرر (recursive)
     */
    protected function addFolderToZip(ZipArchive $zip, string $folderPath, string $zipFolderName): void
    {
        if (!File::isDirectory($folderPath)) {
            return;
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folderPath, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = $zipFolderName . '/' . substr($filePath, strlen($folderPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    /**
     * جلب قائمة كل الباك أبات الموجودة مرتبة من الأحدث للأقدم
     */
    public function list(): array
    {
        $files = Storage::disk($this->disk)->files($this->backupDir);

        $backups = [];
        foreach ($files as $file) {
            if (Str::endsWith($file, '.zip')) {
                $backups[] = [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => $this->formatBytes(Storage::disk($this->disk)->size($file)),
                    'date' => \Carbon\Carbon::createFromTimestamp(
                        Storage::disk($this->disk)->lastModified($file)
                    )->format('Y-m-d H:i'),
                    'timestamp' => Storage::disk($this->disk)->lastModified($file),
                ];
            }
        }

        // ترتيب من الأحدث للأقدم
        usort($backups, fn($a, $b) => $b['timestamp'] - $a['timestamp']);

        return $backups;
    }

    /**
     * حذف باك أب معيّن
     */
    public function delete(string $fileName): bool
    {
        $path = $this->backupDir . '/' . basename($fileName);

        if (Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }

        return false;
    }

    /**
     * الحصول على المسار الكامل لملف باك أب (للتحميل)
     */
    public function getFullPath(string $fileName): ?string
    {
        $path = $this->backupDir . '/' . basename($fileName);

        if (Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->path($path);
        }

        return null;
    }

    /**
     * استعادة باك أب من ملف ZIP (مرفوع أو موجود بالسيرفر)
     *
     * @param string $zipFullPath المسار الكامل لملف ZIP
     */
    public function restore(string $zipFullPath): void
    {
        $tmpDir = storage_path('app/tmp_restore_' . Str::random(8));
        File::makeDirectory($tmpDir, 0755, true);

        try {
            $zip = new ZipArchive();
            if ($zip->open($zipFullPath) !== true) {
                throw new \Exception('فشل في فتح ملف الباك أب، الملف تالف أو غير صالح.');
            }

            $zip->extractTo($tmpDir);
            $zip->close();

            $sqlFile = $tmpDir . '/database.sql';

            if (!file_exists($sqlFile)) {
                throw new \Exception('ملف database.sql غير موجود داخل الباك أب.');
            }

            // 1) استعادة قاعدة البيانات
            $this->restoreDatabase($sqlFile);

            // 2) استعادة storage لو موجودة بالباك أب
            $storageBackupPath = $tmpDir . '/storage';
            if (File::isDirectory($storageBackupPath)) {
                $this->restoreStorage($storageBackupPath);
            }
        } finally {
            File::deleteDirectory($tmpDir);
        }
    }

    /**
     * تنفيذ ملف SQL على القاعدة الحالية
     */
    protected function restoreDatabase(string $sqlFilePath): void
    {
        $sql = file_get_contents($sqlFilePath);

        // فصل الأوامر عبر ";" مع تجاهل الفاصلة جوا القيم النصية بشكل مبسط
        DB::unprepared($sql);
    }

    /**
     * استبدال محتوى storage/app/public بمحتوى الباك أب
     */
    protected function restoreStorage(string $sourcePath): void
    {
        $targetPath = storage_path('app/public');

        // حذف المحتوى الحالي
        if (File::isDirectory($targetPath)) {
            File::deleteDirectory($targetPath);
        }

        File::makeDirectory($targetPath, 0755, true);

        File::copyDirectory($sourcePath, $targetPath);
    }

    protected function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
