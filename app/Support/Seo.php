<?php

namespace App\Support;

use App\Models\Setup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Seo
{
    public static function clean(mixed $value, string $fallback = ''): string
    {
        if (is_array($value)) {
            $value = $value[app()->getLocale()] ?? $value['ar'] ?? reset($value) ?: '';
        }

        $text = trim(html_entity_decode(strip_tags((string) $value), ENT_QUOTES, 'UTF-8'));
        $text = preg_replace('/\s+/u', ' ', $text) ?: $fallback;

        return trim((string) $text);
    }

    public static function description(mixed $value = null): string
    {
        $fallback = app()->getLocale() === 'ar'
            ? 'منصة الديوان للاستشارات الهندسية تقدم خدمات التصميم والرخص والإشراف والسلامة والمشاريع والمحتوى الهندسي في السعودية.'
            : 'Al Diwan Engineering Consulting platform for design, permits, supervision, safety, projects, and engineering knowledge in Saudi Arabia.';

        return Str::limit(self::clean($value, $fallback), 165, '');
    }

    public static function imageUrl(?string $path = null): string
    {
        if (! $path) {
            return asset('logo.png');
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    public static function title(?string $title = null): string
    {
        $siteName = Setup::get('site_name', config('app.name', 'الديوان للاستشارات الهندسية'));
        $cleanTitle = self::clean($title);

        if ($cleanTitle === '') {
            return $siteName;
        }

        return Str::contains($cleanTitle, $siteName) ? $cleanTitle : "{$cleanTitle} | {$siteName}";
    }

    public static function organization(): array
    {
        $siteName = Setup::get('site_name', config('app.name', 'الديوان للاستشارات الهندسية'));
        $phone = Setup::get('phone_number', '');
        $email = Setup::get('site_email', '');
        $address = Setup::get('site_address', '');

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            '@id' => url('/#organization'),
            'name' => $siteName,
            'url' => url('/'),
            'logo' => asset('logo.png'),
            'image' => asset('logo.png'),
            'telephone' => $phone ?: null,
            'email' => $email ?: null,
            'address' => $address ? [
                '@type' => 'PostalAddress',
                'streetAddress' => $address,
                'addressCountry' => 'SA',
            ] : null,
            'areaServed' => [
                ['@type' => 'Country', 'name' => 'Saudi Arabia'],
            ],
        ]);
    }

    public static function website(string $title, string $description): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/#website'),
            'name' => $title,
            'url' => url('/'),
            'description' => $description,
            'inLanguage' => app()->getLocale(),
            'publisher' => ['@id' => url('/#organization')],
        ];
    }

    public static function breadcrumb(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn ($item, $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ])->all(),
        ];
    }

    public static function article(Model $article): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article->meta_title ?: $article->title,
            'description' => self::description($article->meta_description ?: ($article->excerpt ?? $article->content ?? '')),
            'image' => self::imageUrl($article->og_image ?: $article->thumbnail),
            'datePublished' => optional($article->published_at)->toIso8601String(),
            'dateModified' => optional($article->updated_at)->toIso8601String(),
            'author' => $article->user ? ['@type' => 'Person', 'name' => $article->user->name] : null,
            'publisher' => ['@id' => url('/#organization')],
            'mainEntityOfPage' => $article->canonical_url ?: url()->current(),
            'inLanguage' => app()->getLocale(),
        ]);
    }

    public static function service(Model $service): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service->meta_title ?: $service->name,
            'description' => self::description($service->meta_description ?: ($service->short_description ?: $service->description)),
            'image' => self::imageUrl($service->thumbnail),
            'provider' => ['@id' => url('/#organization')],
            'areaServed' => ['@type' => 'Country', 'name' => 'Saudi Arabia'],
            'url' => url()->current(),
        ]);
    }

    public static function project(Model $project): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'CreativeWork',
            'name' => $project->og_title ?: $project->meta_title ?: $project->title,
            'description' => self::description($project->og_description ?: $project->meta_description ?: $project->description),
            'image' => self::imageUrl($project->og_image ?: $project->image),
            'url' => $project->canonical_url ?: url()->current(),
            'publisher' => ['@id' => url('/#organization')],
        ]);
    }

    public static function image(Model $image): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'ImageObject',
            'name' => $image->og_title ?: $image->seo_title ?: $image->title,
            'description' => self::description($image->og_description ?: $image->seo_description ?: $image->description),
            'contentUrl' => self::imageUrl($image->image_path),
            'thumbnailUrl' => self::imageUrl($image->thumbnail_path ?: $image->image_path),
            'url' => $image->canonical_url ?: url()->current(),
        ]);
    }

    public static function video(Model $video): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'VideoObject',
            'name' => $video->og_title ?: $video->seo_title ?: $video->title,
            'description' => self::description($video->og_description ?: $video->seo_description ?: $video->description),
            'thumbnailUrl' => self::imageUrl($video->og_image ?: $video->thumbnail),
            'uploadDate' => optional($video->published_at)->toIso8601String(),
            'duration' => $video->duration ? 'PT' . (int) $video->duration . 'S' : null,
            'contentUrl' => $video->video_path ? self::imageUrl($video->video_path) : null,
            'embedUrl' => $video->embed ? url()->current() : null,
            'url' => $video->canonical_url ?: url()->current(),
        ]);
    }

    public static function faq($faqs): ?array
    {
        $items = collect($faqs)->filter(fn ($faq) => filled($faq->ask) && filled($faq->answer))->values();

        if ($items->isEmpty()) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $items->map(fn ($faq) => [
                '@type' => 'Question',
                'name' => self::clean($faq->ask),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => self::clean($faq->answer),
                ],
            ])->all(),
        ];
    }
}
