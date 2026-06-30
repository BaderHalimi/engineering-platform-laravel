<?php

namespace App\Filament\User\Resources\AlbumVideos\Schemas;

use App\Models\AlbumVideo;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class AlbumVideoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // ====================== رأس الصفحة ======================
                TextEntry::make('header')
                    ->label('')
                    ->html()
                    ->state(function (AlbumVideo $record) {
                        $thumb = Storage::url($record->thumbnail) ;
                        $statusColor = $record->is_published ? '#16a34a' : '#9ca3af';
                        $statusBg = $record->is_published ? '#dcfce7' : '#f3f4f6';
                        $statusText = $record->is_published
                            ? __('album_videos.status.published')
                            : __('album_videos.status.draft');

                        return '
                        <div style="display:flex;gap:20px;align-items:center;background:linear-gradient(135deg,#111827,#1f2937);border-radius:16px;padding:20px;color:#fff;">
                            <img src="' . $thumb . '" style="width:160px;height:100px;object-fit:cover;border-radius:12px;flex-shrink:0;border:2px solid rgba(255,255,255,.1);" />
                            <div style="flex:1;min-width:0;">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
                                    <span style="background:' . $statusBg . ';color:' . $statusColor . ';font-size:12px;font-weight:600;padding:3px 10px;border-radius:999px;">' . $statusText . '</span>
                                    ' . ($record->is_featured ? '<span style="background:#fef9c3;color:#a16207;font-size:12px;font-weight:600;padding:3px 10px;border-radius:999px;">★ ' . __('album_videos.fields.is_featured') . '</span>' : '') . '
                                </div>
                                <h2 style="margin:0;font-size:20px;font-weight:700;color:#fff;">' . e($record->title) . '</h2>
                                <p style="margin:6px 0 0;font-size:13px;color:#9ca3af;">' . e($record->user?->name ?? '-') . ' &middot; ' . ($record->published_at?->translatedFormat('d M Y') ?? '-') . '</p>
                            </div>
                        </div>';
                    }),

                // ====================== كروت الإحصائيات ======================
                TextEntry::make('stats_cards')
                    ->label('')
                    ->html()
                    ->state(function (AlbumVideo $record) {
                        $items = [
                            ['label' => __('album_videos.fields.views'), 'value' => $record->views, 'color' => '#3b82f6', 'bg' => '#eff6ff'],
                            ['label' => __('album_videos.fields.likes'), 'value' => $record->likes, 'color' => '#16a34a', 'bg' => '#f0fdf4'],
                            ['label' => __('album_videos.fields.dislikes'), 'value' => $record->dislikes, 'color' => '#dc2626', 'bg' => '#fef2f2'],
                            ['label' => __('album_videos.fields.shares'), 'value' => $record->shares, 'color' => '#d97706', 'bg' => '#fffbeb'],
                            ['label' => __('album_videos.fields.comments_count'), 'value' => $record->comments_count, 'color' => '#7c3aed', 'bg' => '#f5f3ff'],
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

                // ====================== نسبة التفاعل ======================
                TextEntry::make('engagement_ratio')
                    ->label(__('album_videos.fields.engagement_ratio'))
                    ->html()
                    ->state(function (AlbumVideo $record) {
                        $total = $record->likes + $record->dislikes;
                        $likePercent = $total > 0 ? round(($record->likes / $total) * 100) : 0;

                        return '
                        <div>
                            <div style="width:100%;background:#fee2e2;border-radius:999px;height:12px;overflow:hidden;">
                                <div style="width:' . $likePercent . '%;background:#16a34a;height:100%;border-radius:999px 0 0 999px;"></div>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:12px;color:#6b7280;margin-top:6px;font-weight:600;">
                                <span style="color:#16a34a;">👍 ' . $likePercent . '%</span>
                                <span style="color:#dc2626;">👎 ' . (100 - $likePercent) . '%</span>
                            </div>
                        </div>';
                    }),

                // ====================== الفيديو والوصف ======================
                Section::make(__('album_videos.sections.video'))
                    ->compact()
                    ->schema([
                        TextEntry::make('embed')
                            ->label(__('album_videos.fields.embed'))
                            ->placeholder('-')
                            ->visible(fn (AlbumVideo $record) => filled($record->embed))
                            ->columnSpanFull(),

                        TextEntry::make('video_path')
                            ->label(__('album_videos.fields.video_path'))
                            ->placeholder('-')
                            ->visible(fn (AlbumVideo $record) => filled($record->video_path))
                            ->columnSpanFull(),

                        TextEntry::make('duration')
                            ->label(__('album_videos.fields.duration'))
                            ->placeholder('-')
                            ->formatStateUsing(fn (?int $state) => $state ? gmdate('i:s', $state) : '-'),

                        TextEntry::make('description')
                            ->label(__('album_videos.fields.description'))
                            ->html()
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                // ====================== الإعدادات (ثانوية) ======================
                Tabs::make('settings_tabs')
                    ->columnSpanFull()
                    ->tabs([

                        Tab::make(__('album_videos.tabs.general'))
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('user.name')
                                            ->label(__('album_videos.fields.user')),

                                        TextEntry::make('slug')
                                            ->label(__('album_videos.fields.slug')),

                                        TextEntry::make('language')
                                            ->label(__('album_videos.fields.language'))
                                            ->formatStateUsing(fn (?string $state) => __('album_videos.language.' . $state)),

                                        TextEntry::make('visibility')
                                            ->label(__('album_videos.fields.visibility'))
                                            ->formatStateUsing(fn (?string $state) => __('album_videos.visibility.' . $state)),

                                        TextEntry::make('published_at')
                                            ->label(__('album_videos.fields.published_at'))
                                            ->dateTime()
                                            ->placeholder('-'),

                                        TextEntry::make('canonical_url')
                                            ->label(__('album_videos.fields.canonical_url'))
                                            ->placeholder('-'),

                                        IconEntry::make('is_featured')
                                            ->label(__('album_videos.fields.is_featured'))
                                            ->boolean(),

                                        IconEntry::make('allow_comments')
                                            ->label(__('album_videos.fields.allow_comments'))
                                            ->boolean(),

                                        TextEntry::make('created_at')
                                            ->label(__('album_videos.fields.created_at'))
                                            ->dateTime(),
                                    ]),
                            ]),

                        Tab::make(__('album_videos.tabs.seo'))
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('seo_title')
                                            ->label(__('album_videos.fields.seo_title'))
                                            ->placeholder('-'),

                                        TextEntry::make('seo_keywords')
                                            ->label(__('album_videos.fields.seo_keywords'))
                                            ->placeholder('-'),

                                        TextEntry::make('seo_description')
                                            ->label(__('album_videos.fields.seo_description'))
                                            ->placeholder('-')
                                            ->columnSpanFull(),

                                        TextEntry::make('og_title')
                                            ->label(__('album_videos.fields.og_title'))
                                            ->placeholder('-'),

                                        TextEntry::make('og_description')
                                            ->label(__('album_videos.fields.og_description'))
                                            ->placeholder('-')
                                            ->columnSpanFull(),

                                        ImageEntry::make('og_image')
                                            ->label(__('album_videos.fields.og_image'))
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
