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
);

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


    $data = $request->validate([

        'customer_name'    => 'required|string|max:255',

        'customer_email'   => 'nullable|email|max:255',

        'customer_phone'   => 'required|string|max:20',

        'customer_address' => 'nullable|string|max:500',

        'service_id'       => 'required|exists:services_types,id',

        'title'            => 'required|string|max:255',

        'details'          => 'nullable|string|max:5000',

    ], [

        'customer_name.required' => 'الاسم الكامل مطلوب',

        'customer_phone.required'=> 'رقم الجوال مطلوب',

        'service_id.required'    => 'نوع الخدمة مطلوب',

        'service_id.exists'      => 'الخدمة المختارة غير موجودة',

        'title.required'         => 'عنوان الطلب مطلوب',

        'customer_email.email'   => 'البريد الإلكتروني غير صحيح',

    ]);


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

        'meta'             => [

            'source' => 'website',

            'ip'     => $request->ip(),

        ],

    ]);


    return back()->with('success', 'تم استلام طلبك بنجاح! سنتواصل معك خلال 24 ساعة.');


})->name('service-request.store');

Route::get('/en', fn () => view('welcome'));
Route::get('/about', fn () => view('pages.about'));
Route::get('/services', fn () => view('pages.services'));
Route::get('/services/{slug}', function (string $slug) {
    $service = site_item_by_slug(config('site.services'), $slug);
    abort_if(! $service, 404);

    return view('pages.service-show', compact('service'));
});
Route::get('/projects', fn () => view('pages.projects'));
Route::get('/knowledge', fn () => view('pages.knowledge'));
Route::get('/knowledge/{slug}', function (string $slug) {
    $article = site_item_by_slug(config('site.articles'), $slug);
    abort_if(! $article, 404);

    return view('pages.article-show', compact('article'));
});
Route::get('/faq', fn () => view('pages.faq'));
Route::get('/request-service', fn () => view('pages.request-service'));
Route::get('/contact', fn () => view('pages.contact'));
Route::get('/privacy', fn () => view('pages.privacy'));
Route::get('/terms', fn () => view('pages.terms'));

Route::get('/lang/{locale}', function ($locale) {

    if (!in_array($locale, ['ar', 'en'])) {
        abort(404);
    }

    session(['locale' => $locale]);

    return back();
})->name('set-locale');




Route::middleware(['auth','verified.email',])->group(function () { require __DIR__.'/customer.php'; }); //protected

require __DIR__ . '/auth.php';
});



