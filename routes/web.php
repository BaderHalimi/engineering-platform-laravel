<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Middleware\CheckSiteMaintenance;
use App\Http\Middleware\IsCustomer;
use App\Models\ServicesType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(CheckSiteMaintenance::class)->group(function () {
    Route::get('/', HomeController::class)->name('home');

    require __DIR__.'/home.php';

    Route::get('/sitemap.xml', function () {
        return app(\App\Services\SitemapService::class)->response();
    })->name('sitemap');

    Route::redirect('/terms-of-service', '/terms-conditions')
        ->name('home_pages.terms_of_service');

    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/request-service', function (Request $request) {
        $services = ServicesType::query()
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        $selectedServiceId = null;

        if ($request->filled('service_id')) {
            $selectedServiceId = $request->input('service_id');
        } elseif ($request->filled('service')) {
            $selectedServiceId = $services
                ->firstWhere('slug', $request->input('service'))
                ?->id;
        }

        return view('home_pages.request-service', compact('services', 'selectedServiceId'));
    })->name('service-request.create');

    Route::post('/service-request', [ServiceRequestController::class, 'store'])
        ->name('service-request.store');

    Route::get('/lang/{locale}', function (string $locale) {
        abort_unless(in_array($locale, ['ar', 'en'], true), 404);

        session(['locale' => $locale]);

        return back();
    })->name('set-locale');

    Route::middleware(['auth', 'verified.email', IsCustomer::class])->group(function () {
        require __DIR__.'/customer.php';
    });
    require __DIR__.'/auth.php';
});
Route::get('user',function(){
    return redirect(url('/user/login'));
});
