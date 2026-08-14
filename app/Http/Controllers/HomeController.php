<?php

namespace App\Http\Controllers;

use App\Models\AlbumImage;
use App\Models\AlbumVideo;
use App\Models\Article;
use App\Models\Faq;
use App\Models\Project;
use App\Models\ServicesType;
use App\Models\Setup;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Throwable;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $safe = fn (callable $query): Collection => $this->safeCollection($query);

        $services = $safe(fn () => ServicesType::query()->where('status', 'active')->orderBy('sort_order')->get());
        $projects = $safe(fn () => Project::query()->with('category')->where('is_active', true)
            ->orderBy('sort_order')->limit(9)->get());
        $articlesByCategory = $safe(fn () => Article::query()->with('category')
            ->where('status', 'published')->whereNotNull('published_at')
            ->orderByDesc('published_at')->get())
            ->groupBy(fn (Article $article) => $article->category->name ?? __('home.articles.uncategorized'));
        $videos = $safe(fn () => AlbumVideo::query()->where('is_published', true)->where('visibility', 'public')
            ->orderByDesc('published_at')->limit(6)->get());
        $images = $safe(fn () => AlbumImage::query()->where('visibility', 'public')->orderByDesc('featured')
            ->orderBy('sort_order')->limit(9)->get());
        $faqs = $safe(fn () => Faq::query()->where('is_active', true)->orderBy('id')->get());
        $heroSlides = json_decode(Setup::get('hero_slides', '[]'), true) ?: [];

        return view('home', compact('services', 'projects', 'articlesByCategory', 'videos', 'images', 'faqs', 'heroSlides'));
    }

    private function safeCollection(callable $query): Collection
    {
        try {
            return $query();
        } catch (Throwable) {
            return collect();
        }
    }
}
