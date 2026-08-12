<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckSiteMaintenance;
use App\Models\AlbumImage;
use App\Models\AlbumVideo;
use App\Models\Article;
use App\Models\Project;
use App\Models\ServicesType;
use App\Models\Setup;
use App\Models\ServicesRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Http\Middleware\IsCustomer;

Route::middleware(CheckSiteMaintenance::class)->group(function () {

function site_item_by_slug(array $items, string $slug): ?array
{
    foreach ($items as $item) {
        if (($item['slug'] ?? null) === $slug) {
            return $item;
        }
    }

    return null;
}

Route::get('/', function ()
   {
        // ===== الخدمات =====
        $services = ServicesType::query()
            //->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // ===== المشاريع (جدول projects الجديد) =====
        $projects = Project::query()
            ->with('category')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(9)
            ->get();

        // ===== المقالات مجمّعة حسب التصنيف =====
        $articlesByCategory = Article::query()
            ->with('category')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->get()
            ->groupBy(fn ($article) => $article->category->name ?? __('home.articles.uncategorized'));

        // ===== الفيديوهات =====
        $videos = AlbumVideo::query()
            ->where('is_published', true)
            ->where('visibility', 'public')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        // ===== الصور =====
        $images = AlbumImage::query()
            ->where('visibility', 'public')
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->limit(9)
            ->get();

        // ===== الأسئلة الشائعة =====
        $faqs = Faq::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        return view('home', compact(
            'services',
            'projects',
            'articlesByCategory',
            'videos',
            'images',
            'faqs'
        ));
    }
)->name('home');
Route::get("privacy-policy", function () {
    $setup = Setup::first();
    return view('home_pages.privacy-policy', compact('setup'));
})->name('home_pages.privacy_policy');
Route::get("terms-of-service", function () {
    $setup = Setup::first();
    return view('home_pages.terms-of-service', compact('setup'));
})->name('home_pages.terms_of_service');
require __DIR__ . '/home.php';



Route::post('/feedback', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'email' => ['required', 'email'],
        'title' => ['required', 'string', 'max:255'],
        'content' => ['required', 'string'],
        'attachments.*' => ['nullable', 'file', 'max:10240'],
    ]);

    $paths = [];
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $paths[] = $file->store('feedback-attachments', 'public');
        }
    }

    \App\Models\Feedback::create([
        'email' => $data['email'],
        'title' => $data['title'],
        'content' => $data['content'],
        'attachments' => $paths,
    ]);

    return back()->with('success', __('home.feedback.submit') . ' ✔');
})->name('feedback.store');


Route::post('/service-request', function (Request $request) {

    $service = ServicesType::findOrFail($request->input('service_id'));

    $rules = [
        'customer_name'    => 'required|string|max:255',
        'customer_email'   => 'nullable|email|max:255',
        'customer_phone'   => 'required|string|max:20',
        'customer_address' => 'nullable|string|max:500',
        'service_id'       => 'required|exists:services_types,id',
        'title'            => 'required|string|max:255',
        'details'          => 'nullable|string|max:5000',
    ];

    // لو الخدمة موثّقة (documented) نضيف قواعد التحقق للملفات
    if ($service->documented) {
        $rules['documents']   = 'required|array|min:1|max:5';
        $rules['documents.*'] = 'file|mimes:pdf,jpg,jpeg,png|max:5120'; // 5MB لكل ملف
    }

    $data = $request->validate($rules, [
        'customer_name.required' => 'الاسم الكامل مطلوب',
        'customer_phone.required'=> 'رقم الجوال مطلوب',
        'service_id.required'    => 'نوع الخدمة مطلوب',
        'service_id.exists'      => 'الخدمة المختارة غير موجودة',
        'title.required'         => 'عنوان الطلب مطلوب',
        'customer_email.email'   => 'البريد الإلكتروني غير صحيح',
        'documents.required'     => 'هذه الخدمة تتطلب رفع مستندات',
        'documents.*.mimes'      => 'صيغة الملف غير مدعومة (PDF, JPG, PNG فقط)',
        'documents.*.max'        => 'حجم الملف يجب ألا يتجاوز 5 ميغابايت',
    ]);

    // رفع المستندات إن وجدت
    $documentPaths = [];

    if ($request->hasFile('documents')) {
        foreach ($request->file('documents') as $file) {
            $path = $file->store('service-requests/documents', 'public');
            $documentPaths[] = [
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'size' => $file->getSize(),
            ];
        }
    }

    ServicesRequest::create([
        'service_id'       => $data['service_id'],
        'title'            => $data['title'],
        'reference'        => 'SR-' . strtoupper(Str::random(8)),
        'details'          => $data['details'],
        'status'           => 'pending',
        'customer_name'    => $data['customer_name'],
        'customer_email'   => $data['customer_email'],
        'customer_phone'   => $data['customer_phone'],
        'customer_address' => $data['customer_address'],
        'documents'        => $documentPaths,
        'meta'             => [
            'source' => 'website',
            'ip'     => $request->ip(),
        ],
    ]);

    return back()->with('success', 'تم استلام طلبك بنجاح! سنتواصل معك خلال 24 ساعة.');

})->name('service-request.store');


Route::get('/lang/{locale}', function ($locale) {

    if (!in_array($locale, ['ar', 'en'])) {
        abort(404);
    }

    session(['locale' => $locale]);

    return back();
})->name('set-locale');



Route::middleware(['auth','verified.email', 'IsCustomer'])->group(function () { require __DIR__.'/customer.php'; }); //protected

require __DIR__ . '/auth.php';
});



