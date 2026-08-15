<?php

namespace App\Filament\User\Resources\AlbumImages\Schemas;

use App\Models\AlbumImage;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class AlbumImageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // ====================== رأس الصفحة ======================
                TextEntry::make('header')
                    ->label('')
                    ->html()
                    ->state(function (AlbumImage $record) {
                        $thumb = Storage::url($record->image_path);
                        $statusColor = $record->visibility === 'public' ? '#16a34a' : '#9ca3af';
                        $statusBg = $record->visibility === 'public' ? '#dcfce7' : '#f3f4f6';
                        $statusText = __('album_images.visibility.' . $record->visibility);

                        return '
                        <div style="display:flex;gap:20px;align-items:center;background:linear-gradient(135deg,#111827,#1f2937);border-radius:16px;padding:20px;color:#fff;">
                            <img src="' . $thumb . '" style="width:160px;height:100px;object-fit:cover;border-radius:12px;flex-shrink:0;border:2px solid rgba(255,255,255,.1);" />
                            <div style="flex:1;min-width:0;">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
                                    <span style="background:' . $statusBg . ';color:' . $statusColor . ';font-size:12px;font-weight:600;padding:3px 10px;border-radius:999px;">' . $statusText . '</span>
                                    ' . ($record->featured ? '<span style="background:#fef9c3;color:#a16207;font-size:12px;font-weight:600;padding:3px 10px;border-radius:999px;">★ ' . __('album_images.fields.featured') . '</span>' : '') . '
                                </div>
                                <h2 style="margin:0;font-size:20px;font-weight:700;color:#fff;">' . e($record->title) . '</h2>
                                <p style="margin:6px 0 0;font-size:13px;color:#9ca3af;">' . ($record->user?->name ?? '-') . ' &middot; ' . ($record->created_at?->translatedFormat('d M Y') ?? '-') . '</p>
                            </div>
                        </div>';
                    }),

                // ====================== كروت الإحصائيات ======================
                TextEntry::make('stats_cards')
                    ->label('')
                    ->html()
                    ->state(function (AlbumImage $record) {
                        $items = [
                            ['label' => __('album_images.fields.views'), 'value' => $record->views, 'color' => '#3b82f6', 'bg' => '#eff6ff'],
                            ['label' => __('album_images.fields.likes'), 'value' => $record->likes, 'color' => '#16a34a', 'bg' => '#f0fdf4'],
                            ['label' => __('album_images.fields.downloads'), 'value' => $record->downloads, 'color' => '#d97706', 'bg' => '#fffbeb'],
                            ['label' => __('album_images.fields.shares'), 'value' => $record->shares, 'color' => '#7c3aed', 'bg' => '#f5f3ff'],
                        ];

                        $cards = '';
                        foreach ($items as $item) {
                            $cards .= '
                            <div style="background:' . $item['bg'] . ';border-radius:14px;padding:16px;text-align:center;flex:1;min-width:110px;">
                                <div style="font-size:24px;font-weight:800;color:' . $item['color'] . ';line-height:1.2;">' . number_format($item['value']) . '</div>
                                <div style="font-size:12px;color:#6b7280;margin-top:4px;font-weight:600;">' . $item['label'] . '</div>
                            </div>';
                        }

                        return '<div style="display:flex;gap:12px;flex-wrap:wrap;">' . $cards . '</div>';
                    }),

                // ====================== تفاصيل الصورة ======================
                Section::make(__('album_images.sections.image'))
                    ->compact()
                    ->schema([
                        ImageEntry::make('image_path')
                            ->label(__('album_images.fields.image_path'))
                            ->placeholder('-')
                            ->columnSpanFull(),

                        TextEntry::make('alt_text')
                            ->label(__('album_images.fields.alt_text'))
                            ->placeholder('-'),

                        TextEntry::make('link_url')
                            ->label(__('album_images.fields.link_url'))
                            ->url(fn (?string $state) => $state)
                            ->openUrlInNewTab()
                            ->placeholder('-'),

                        TextEntry::make('description')
                            ->label(__('album_images.fields.description'))
                            ->html()
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                // ====================== الإعدادات و SEO ======================
                Tabs::make('settings_tabs')
                    ->columnSpanFull()
                    ->tabs([

                        Tab::make(__('album_images.tabs.general'))
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('slug')
                                            ->label(__('album_images.fields.slug')),

                                        TextEntry::make('visibility')
                                            ->label(__('album_images.fields.visibility'))
                                            ->formatStateUsing(fn (?string $state) => __('album_images.visibility.' . $state)),

                                        TextEntry::make('sort_order')
                                            ->label(__('album_images.fields.sort_order'))
                                            ->numeric(),

                                        IconEntry::make('featured')
                                            ->label(__('album_images.fields.featured'))
                                            ->boolean(),

                                        TextEntry::make('user.name')
                                            ->label(__('album_images.fields.user')),

                                        TextEntry::make('created_at')
                                            ->label(__('album_images.fields.created_at'))
                                            ->dateTime(),

                                        TextEntry::make('updated_at')
                                            ->label(__('album_images.fields.updated_at'))
                                            ->dateTime(),
                                    ]),
                            ]),

                        Tab::make(__('album_images.tabs.seo'))
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('seo_title')
                                            ->label(__('album_images.fields.seo_title'))
                                            ->placeholder('-'),

                                        TextEntry::make('seo_keywords')
                                            ->label(__('album_images.fields.seo_keywords'))
                                            ->placeholder('-'),

                                        TextEntry::make('seo_description')
                                            ->label(__('album_images.fields.seo_description'))
                                            ->placeholder('-')
                                            ->columnSpanFull(),

                                        TextEntry::make('canonical_url')
                                            ->label(__('album_images.fields.canonical_url'))
                                            ->placeholder('-'),

                                        IconEntry::make('indexable')
                                            ->label(__('album_images.fields.indexable'))
                                            ->boolean(),

                                        TextEntry::make('og_title')
                                            ->label(__('album_images.fields.og_title'))
                                            ->placeholder('-'),

                                        TextEntry::make('og_description')
                                            ->label(__('album_images.fields.og_description'))
                                            ->placeholder('-')
                                            ->columnSpanFull(),

                                        ImageEntry::make('og_image')
                                            ->label(__('album_images.fields.og_image'))
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
