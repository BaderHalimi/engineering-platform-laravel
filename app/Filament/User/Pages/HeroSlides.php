<?php

namespace App\Filament\User\Pages;

use App\Models\Setup;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class HeroSlides extends Page
{
    use WithFileUploads;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'سلايدر الرئيسية';

    protected static ?string $title = 'سلايدر الشاشة الرئيسية';

    protected static ?int $navigationSort = 0;

    protected string $view = 'filament.user.pages.hero-slides';

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.content');
    }

    public array $locales = ['ar', 'en', 'fr'];

    public array $hero_slides = [];

    #[Validate(['hero_slide_uploads.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,webm,ogg|max:51200'])]
    public array $hero_slide_uploads = [];

    public ?string $statusMessage = null;

    public function mount(): void
    {
        $this->hero_slides = array_map(
            fn ($item) => $this->normalizeHeroSlide($item),
            json_decode(Setup::get('hero_slides', '[]'), true) ?: []
        );
    }

    protected function normalizeHeroSlide(array $item): array
    {
        return [
            'type' => in_array($item['type'] ?? 'image', ['image', 'video'], true) ? $item['type'] : 'image',
            'media_path' => $item['media_path'] ?? '',
            'title' => array_merge(array_fill_keys($this->locales, ''), is_array($item['title'] ?? null) ? $item['title'] : []),
            'description' => array_merge(array_fill_keys($this->locales, ''), is_array($item['description'] ?? null) ? $item['description'] : []),
            'button_text' => array_merge(array_fill_keys($this->locales, ''), is_array($item['button_text'] ?? null) ? $item['button_text'] : []),
            'button_url' => $item['button_url'] ?? '',
        ];
    }

    public function addHeroSlide(): void
    {
        $this->hero_slides[] = $this->normalizeHeroSlide([]);
    }

    public function removeHeroSlide(int $index): void
    {
        unset($this->hero_slides[$index], $this->hero_slide_uploads[$index]);
        $this->hero_slides = array_values($this->hero_slides);
        $this->hero_slide_uploads = array_values($this->hero_slide_uploads);
    }

    public function moveHeroSlide(int $index, string $direction): void
    {
        $target = $direction === 'up' ? $index - 1 : $index + 1;

        if (!isset($this->hero_slides[$index]) || !isset($this->hero_slides[$target])) {
            return;
        }

        [$this->hero_slides[$index], $this->hero_slides[$target]] = [$this->hero_slides[$target], $this->hero_slides[$index]];
        [$this->hero_slide_uploads[$index], $this->hero_slide_uploads[$target]] = [$this->hero_slide_uploads[$target] ?? null, $this->hero_slide_uploads[$index] ?? null];
    }

    public function saveHeroSlides(): void
    {
        $rules = [
            'hero_slides' => 'array',
            'hero_slides.*.type' => 'required|in:image,video',
            'hero_slides.*.media_path' => 'nullable|string|max:500',
            'hero_slides.*.button_url' => 'nullable|string|max:500',
            'hero_slide_uploads.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,webm,ogg|max:51200',
        ];

        foreach ($this->locales as $locale) {
            $rules["hero_slides.*.title.{$locale}"] = 'nullable|string|max:255';
            $rules["hero_slides.*.description.{$locale}"] = 'nullable|string|max:1000';
            $rules["hero_slides.*.button_text.{$locale}"] = 'nullable|string|max:80';
        }

        $this->validate($rules);

        foreach ($this->hero_slide_uploads as $index => $upload) {
            if ($upload instanceof UploadedFile) {
                $this->hero_slides[$index]['media_path'] = $upload->store('hero-slides', 'public');
            }
        }

        $slides = collect($this->hero_slides)
            ->map(fn ($item) => $this->normalizeHeroSlide($item))
            ->filter(fn ($item) => filled($item['media_path']))
            ->values()
            ->all();

        Setup::set('hero_slides', json_encode($slides, JSON_UNESCAPED_UNICODE));

        $this->hero_slides = $slides;
        $this->hero_slide_uploads = [];
        $this->statusMessage = 'تم حفظ سلايدر الشاشة الرئيسية بنجاح.';
    }
}
