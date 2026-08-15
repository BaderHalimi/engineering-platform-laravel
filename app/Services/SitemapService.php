<?php

namespace App\Services;

use App\Models\AlbumImage;
use App\Models\AlbumVideo;
use App\Models\Article;
use App\Models\Project;
use App\Models\ServicesType;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class SitemapService
{
    public function urls(): Collection
    {
        $urls = collect([
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.services.index'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.projects.index'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.articles.index'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.media.index'), 'priority' => '0.7', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.images.index'), 'priority' => '0.6', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.videos.index'), 'priority' => '0.6', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('home_pages.aboutus'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()],
            ['loc' => route('privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly', 'lastmod' => now()],
            ['loc' => route('terms-conditions'), 'priority' => '0.3', 'changefreq' => 'yearly', 'lastmod' => now()],
        ]);

        return $urls
            ->merge(ServicesType::query()
                ->where('status', 'active')
                ->get()
                ->map(fn ($service) => [
                    'loc' => route('home_pages.services.view', $service->slug),
                    'priority' => '0.9',
                    'changefreq' => 'monthly',
                    'lastmod' => $service->updated_at,
                ]))
            ->merge(Project::query()
                ->where('is_active', true)
                ->get()
                ->map(fn ($project) => [
                    'loc' => $project->canonical_url ?: route('home_pages.projects.view', $project->slug),
                    'priority' => '0.7',
                    'changefreq' => 'monthly',
                    'lastmod' => $project->updated_at,
                ]))
            ->merge(Article::query()
                ->published()
                ->get()
                ->map(fn ($article) => [
                    'loc' => $article->canonical_url ?: route('home_pages.articles.view', $article->slug),
                    'priority' => '0.8',
                    'changefreq' => 'monthly',
                    'lastmod' => $article->updated_at ?: $article->published_at,
                ]))
            ->merge(AlbumImage::query()
                ->where('visibility', 'public')
                ->where('indexable', true)
                ->get()
                ->map(fn ($image) => [
                    'loc' => $image->canonical_url ?: route('pages.image-show', $image->slug),
                    'priority' => '0.5',
                    'changefreq' => 'monthly',
                    'lastmod' => $image->updated_at,
                ]))
            ->merge(AlbumVideo::query()
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
    }

    public function xml(): string
    {
        return view('sitemap', ['urls' => $this->urls()])->render();
    }

    public function writePublicFile(): array
    {
        $urls = $this->urls();
        $xml = view('sitemap', compact('urls'))->render();
        $path = public_path('sitemap.xml');

        File::put($path, $xml);

        return [
            'path' => $path,
            'url_count' => $urls->count(),
            'generated_at' => now(),
        ];
    }

    public function publicFilePath(): string
    {
        return public_path('sitemap.xml');
    }

    public function publicFileExists(): bool
    {
        return File::exists($this->publicFilePath());
    }

    public function publicFileGeneratedAt(): ?string
    {
        if (! $this->publicFileExists()) {
            return null;
        }

        return date('Y-m-d H:i', File::lastModified($this->publicFilePath()));
    }

    public function response(): Response
    {
        if ($this->publicFileExists()) {
            return response(File::get($this->publicFilePath()), 200)
                ->header('Content-Type', 'application/xml');
        }

        return response($this->xml(), 200)
            ->header('Content-Type', 'application/xml');
    }
}
