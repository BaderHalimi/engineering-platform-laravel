<?php

namespace App\Http\Controllers;

use App\Models\AlbumImage;
use App\Models\AlbumVideo;
use App\Models\Article;
use App\Models\Faq;
use App\Models\Project;
use App\Models\ServicesType;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $services = ServicesType::query()->orderBy('sort_order')->get();
        $projects = Project::query()->with('category')->where('is_active', true)
            ->orderBy('sort_order')->limit(9)->get();
        $articlesByCategory = Article::query()->with('category')
            ->where('status', 'published')->whereNotNull('published_at')
            ->orderByDesc('published_at')->get()
            ->groupBy(fn (Article $article) => $article->category->name ?? __('home.articles.uncategorized'));
        $videos = AlbumVideo::query()->where('is_published', true)->where('visibility', 'public')
            ->orderByDesc('published_at')->limit(6)->get();
        $images = AlbumImage::query()->where('visibility', 'public')->orderByDesc('featured')
            ->orderBy('sort_order')->limit(9)->get();
        $faqs = Faq::query()->where('is_active', true)->orderBy('id')->get();

        return view('home', compact('services', 'projects', 'articlesByCategory', 'videos', 'images', 'faqs'));
    }
}
