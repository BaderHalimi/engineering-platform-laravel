<?php

namespace App\Support;

use App\Models\AlbumImage;
use App\Models\AlbumVideo;
use App\Models\Article;
use App\Models\Faq;
use App\Models\Project;
use App\Models\ServicesType;
use App\Models\Setup;
use Illuminate\Support\Collection;
use Throwable;

class HomeContent
{
    public static function availability(): array
    {
        return [
            'services' => self::exists(fn () => ServicesType::query()->where('status', 'active')->exists()),
            'projects' => self::exists(fn () => Project::query()->where('is_active', true)->exists()),
            'about' => count(json_decode(Setup::get('about_us', '[]'), true) ?: []) > 0,
            'articles' => self::exists(fn () => Article::query()->published()->exists()),
            'media' => self::exists(fn () => AlbumVideo::query()->where('is_published', true)->where('visibility', 'public')->exists())
                || self::exists(fn () => AlbumImage::query()->where('visibility', 'public')->exists()),
            'faqs' => self::exists(fn () => Faq::query()->where('is_active', true)->exists()),
            'contact' => true,
        ];
    }

    public static function fromHomeData(
        Collection $services,
        Collection $projects,
        array $aboutUs,
        Collection $articlesByCategory,
        Collection $videos,
        Collection $images,
        Collection $faqs
    ): array {
        return [
            'services' => $services->isNotEmpty(),
            'projects' => $projects->isNotEmpty(),
            'about' => count($aboutUs) > 0,
            'articles' => $articlesByCategory->contains(fn ($items) => collect($items)->isNotEmpty()),
            'media' => $videos->isNotEmpty() || $images->isNotEmpty(),
            'faqs' => $faqs->isNotEmpty(),
            'contact' => true,
        ];
    }

    public static function setup(): array
    {
        return [
            'siteName' => Setup::get('site_name', config('app.name')),
            'siteEmail' => Setup::get('site_email', ''),
            'siteAddress' => Setup::get('site_address', ''),
            'sitePhone' => Setup::get('phone_number', ''),
            'siteLogo' => Setup::get('site_logo_path'),
            'workingHours' => Setup::get('working_hours', ''),
            'topNotice' => Setup::get('top_notice', ''),
            'socialLinks' => json_decode(Setup::get('social_links', '[]'), true) ?: [],
        ];
    }

    private static function exists(callable $query): bool
    {
        try {
            return (bool) $query();
        } catch (Throwable) {
            return false;
        }
    }
}
