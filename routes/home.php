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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

Route::get('articles', function (\Illuminate\Http\Request $request) {
    $articles = Article::query()
        ->with('category')
        ->where('status', 'published')
        ->whereNotNull('published_at')
        ->when($request->filled('search'), function ($query) use ($request) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        })
        ->when($request->filled('category'), function ($query) use ($request) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        })
        ->orderByDesc('published_at')
        ->paginate(10)
        ->withQueryString();

    return view('home_pages.articles.index', compact('articles'));
})->name('home_pages.articles.index');

Route::get('articles/{slug}', function (string $slug, \Illuminate\Http\Request $request) {
    $article = Article::query()
        ->with('category')
        ->published()
        ->where('slug', $slug)
        ->firstOrFail();

    $cacheKey = "article_view_{$article->id}_{$request->ip()}";

    if (!\Illuminate\Support\Facades\Cache::has($cacheKey)) {
        $article->increment('views');
        \Illuminate\Support\Facades\Cache::put($cacheKey, true, now()->addDay());
    }

    return view('home_pages.articles.view', compact('article'));
})->name('home_pages.articles.view');


Route::get('projects', function (\Illuminate\Http\Request $request) {
    $projects = Project::query()
        ->with('category')
        ->where('is_active', true)
        ->when($request->filled('search'), function ($query) use ($request) {
            $query->where('title', 'like', "%{$request->input('search')}%");
        })
        ->when($request->filled('category'), function ($query) use ($request) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        })
        ->orderBy('sort_order')
        ->paginate(9)
        ->withQueryString();

    $categories = \App\Models\ServiceCategory::orderBy('name')->get();

    return view('home_pages.projects.index', compact('projects', 'categories'));
})->name('home_pages.projects.index');


Route::get('projects/{slug}', function (string $slug) {
    $project = Project::query()
        ->with('category')
        ->where('is_active', true)
        ->where('slug', $slug)
        ->firstOrFail();

    return view('home_pages.projects.view', compact('project'));
})->name('home_pages.projects.view');



Route::get('services', function () {
    $services = ServicesType::query()
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->paginate(10);

    return view('pages.services', compact('services'));
})->name('home_pages.services.index');

Route::get('services/{slug}', function (string $slug) {
    $service = ServicesType::query()
        ->where('is_active', true)
        ->where('slug', $slug)
        ->firstOrFail();

    return view('pages.service-show', compact('service'));
})->name('home_pages.services.view');


Route::get('videos', function (\Illuminate\Http\Request $request) {
    $videos = AlbumVideo::query()
        ->where('is_published', true)
        ->where('visibility', 'public')
        ->when($request->filled('search'), function ($query) use ($request) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        })
        ->orderByDesc('published_at')
        ->paginate(9)
        ->withQueryString();

    return view('home_pages.videos.index', compact('videos'));
})->name('home_pages.videos.index');


Route::get('videos/{slug}', function (string $slug, \Illuminate\Http\Request $request) {
    $video = AlbumVideo::query()
        ->where('is_published', true)
        ->where('visibility', 'public')
        ->where('slug', $slug)
        ->firstOrFail();

    $cacheKey = "video_view_{$video->id}_{$request->ip()}";

    if (!Cache::has($cacheKey)) {
        $video->increment('views');
        Cache::put($cacheKey, true, now()->addDay());
    }

    return view('home_pages.videos.view', compact('video'));
})->name('home_pages.videos.view');


// Like
Route::post('videos/{slug}/like', function (string $slug, \Illuminate\Http\Request $request) {
    $video = AlbumVideo::query()
        ->where('visibility', 'public')
        ->where('slug', $slug)
        ->firstOrFail();

    $likeCacheKey = "video_like_{$video->id}_{$request->ip()}";
    $dislikeCacheKey = "video_dislike_{$video->id}_{$request->ip()}";

    if (Cache::has($likeCacheKey)) {
        return response()->json([
            'success' => false,
            'message' => __('videos.already_liked'),
            'likes' => $video->likes,
            'dislikes' => $video->dislikes,
        ]);
    }

    // إذا كان مسجل dislike قبل، نلغيه ونحول لـ like
    if (Cache::has($dislikeCacheKey)) {
        $video->decrement('dislikes');
        Cache::forget($dislikeCacheKey);
    }

    $video->increment('likes');
    Cache::put($likeCacheKey, true, now()->addDay());

    return response()->json([
        'success' => true,
        'likes' => $video->fresh()->likes,
        'dislikes' => $video->fresh()->dislikes,
    ]);
})->name('home_pages.videos.like');


// Dislike
Route::post('videos/{slug}/dislike', function (string $slug, \Illuminate\Http\Request $request) {
    $video = AlbumVideo::query()
        ->where('visibility', 'public')
        ->where('slug', $slug)
        ->firstOrFail();

    $likeCacheKey = "video_like_{$video->id}_{$request->ip()}";
    $dislikeCacheKey = "video_dislike_{$video->id}_{$request->ip()}";

    if (Cache::has($dislikeCacheKey)) {
        return response()->json([
            'success' => false,
            'message' => __('videos.already_disliked'),
            'likes' => $video->likes,
            'dislikes' => $video->dislikes,
        ]);
    }

    if (Cache::has($likeCacheKey)) {
        $video->decrement('likes');
        Cache::forget($likeCacheKey);
    }

    $video->increment('dislikes');
    Cache::put($dislikeCacheKey, true, now()->addDay());

    return response()->json([
        'success' => true,
        'likes' => $video->fresh()->likes,
        'dislikes' => $video->fresh()->dislikes,
    ]);
})->name('home_pages.videos.dislike');


// Share
Route::post('videos/{slug}/share', function (string $slug) {
    $video = AlbumVideo::query()
        ->where('visibility', 'public')
        ->where('slug', $slug)
        ->firstOrFail();

    $video->increment('shares');

    return response()->json([
        'success' => true,
        'shares' => $video->fresh()->shares,
    ]);
})->name('home_pages.videos.share');

Route::get('images', function (\Illuminate\Http\Request $request) {
    $images = AlbumImage::query()
        ->where('visibility', 'public')
        ->when($request->filled('search'), function ($query) use ($request) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        })
        ->orderByDesc('featured')
        ->orderBy('sort_order')
        ->paginate(9)
        ->withQueryString();

    return view('home_pages.images.index', compact('images'));
})->name('home_pages.images.index');


Route::get('images/{slug}', function (string $slug, \Illuminate\Http\Request $request) {
    $image = AlbumImage::query()
        ->where('visibility', 'public')
        ->where('slug', $slug)
        ->firstOrFail();

    $cacheKey = "image_view_{$image->id}_{$request->ip()}";

    if (!\Illuminate\Support\Facades\Cache::has($cacheKey)) {
        $image->increment('views');
        \Illuminate\Support\Facades\Cache::put($cacheKey, true, now()->addDay());
    }

    return view('home_pages.images.view', compact('image'));
})->name('pages.image-show');

Route::post('images/{slug}/like', function (string $slug, \Illuminate\Http\Request $request) {
    $image = AlbumImage::query()
        ->where('visibility', 'public')
        ->where('slug', $slug)
        ->firstOrFail();

    $cacheKey = "image_like_{$image->id}_{$request->ip()}";

    if (Cache::has($cacheKey)) {
        return response()->json([
            'success' => false,
            'message' => 'لقد قمت بالإعجاب مسبقًا',
            'likes' => $image->likes,
        ]);
    }

    $image->increment('likes');
    Cache::put($cacheKey, true, now()->addDay());

    return response()->json([
        'success' => true,
        'likes' => $image->fresh()->likes,
    ]);
})->name('home_pages.images.like');


Route::post('images/{slug}/share', function (string $slug) {
    $image = AlbumImage::query()
        ->where('visibility', 'public')
        ->where('slug', $slug)
        ->firstOrFail();

    $image->increment('shares');

    return response()->json([
        'success' => true,
        'shares' => $image->fresh()->shares,
    ]);
})->name('home_pages.images.share');


Route::get('images/{slug}/download', function (string $slug) {
    $image = AlbumImage::query()
        ->where('visibility', 'public')
        ->where('slug', $slug)
        ->firstOrFail();

    $image->increment('downloads');

    // افترض إن image_path محفوظ فديسك public
    if (!Storage::disk('public')->exists($image->image_path)) {
        abort(404, 'الملف غير موجود');
    }

    return Storage::disk('public')->download(
        $image->image_path,
        $image->slug . '.' . pathinfo($image->image_path, PATHINFO_EXTENSION)
    );
})->name('home_pages.images.download');

Route::get('/privacy-policy', function () {
    $data = json_decode(Setup::get('privacy_policy', '{}'), true) ?: [];
    $content = $data[app()->getLocale()] ?? $data['ar'] ?? '';

    return view('home_pages.privacy-policy', [
        'title' => 'سياسة الخصوصية',
        'content' => $content,
    ]);
})->name('privacy-policy');

Route::get('/terms-conditions', function () {
    $data = json_decode(Setup::get('terms_and_conditions', '{}'), true) ?: [];
    $content = $data[app()->getLocale()] ?? $data['ar'] ?? '';

    return view('home_pages.terms-of-service', [
        'title' => 'الشروط والأحكام',
        'content' => $content,
    ]);
})->name('terms-conditions');
