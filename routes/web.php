<?php

use Illuminate\Support\Facades\Route;

function site_item_by_slug(array $items, string $slug): ?array
{
    foreach ($items as $item) {
        if (($item['slug'] ?? null) === $slug) {
            return $item;
        }
    }

    return null;
}

Route::get('/', fn () => view('welcome'));
Route::get('/en', fn () => view('pages.en'));
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