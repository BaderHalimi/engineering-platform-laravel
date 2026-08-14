<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Middleware\CheckSiteMaintenance;
use App\Http\Middleware\IsCustomer;
use Illuminate\Support\Facades\Route;

Route::middleware(CheckSiteMaintenance::class)->group(function () {
    Route::get('/', HomeController::class)->name('home');

    require __DIR__.'/home.php';

    Route::get('/sitemap.xml', function () {
        $urls = collect([
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.services.index'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.projects.index'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.articles.index'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.images.index'), 'priority' => '0.6', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.videos.index'), 'priority' => '0.6', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.aboutus'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()],
            ['loc' => route('privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly', 'lastmod' => now()],
            ['loc' => route('terms-conditions'), 'priority' => '0.3', 'changefreq' => 'yearly', 'lastmod' => now()],
        ]);

        $urls = $urls
            ->merge(\App\Models\ServicesType::query()
                ->where('status', 'active')
                ->get()
                ->map(fn ($service) => [
                    'loc' => route('home_pages.services.view', $service->slug),
                    'priority' => '0.9',
                    'changefreq' => 'monthly',
                    'lastmod' => $service->updated_at,
                ]))
            ->merge(\App\Models\Project::query()
                ->where('is_active', true)
                ->get()
                ->map(fn ($project) => [
                    'loc' => $project->canonical_url ?: route('home_pages.projects.view', $project->slug),
                    'priority' => '0.7',
                    'changefreq' => 'monthly',
                    'lastmod' => $project->updated_at,
                ]))
            ->merge(\App\Models\Article::query()
                ->published()
                ->get()
                ->map(fn ($article) => [
                    'loc' => $article->canonical_url ?: route('home_pages.articles.view', $article->slug),
                    'priority' => '0.8',
                    'changefreq' => 'monthly',
                    'lastmod' => $article->updated_at ?: $article->published_at,
                ]))
            ->merge(\App\Models\AlbumImage::query()
                ->where('visibility', 'public')
                ->where('indexable', true)
                ->get()
                ->map(fn ($image) => [
                    'loc' => $image->canonical_url ?: route('pages.image-show', $image->slug),
                    'priority' => '0.5',
                    'changefreq' => 'monthly',
                    'lastmod' => $image->updated_at,
                ]))
            ->merge(\App\Models\AlbumVideo::query()
                ->where('is_published', true)
                ->where('visibility', 'public')
                ->whereNotNull('published_at')
                ->get()
                ->map(fn ($video) => [
                    'loc' => $video->canonical_url ?: route('home_pages.videos.view', $video->slug),
                    'priority' => '0.6',
                    'changefreq' => 'monthly',
                    'lastmod' => $video->updated_at ?: $video->published_at,
                ]))
            ->unique('loc')
            ->values();

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    })->name('sitemap');

    Route::redirect('/terms-of-service', '/terms-conditions')
        ->name('home_pages.terms_of_service');

    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
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
