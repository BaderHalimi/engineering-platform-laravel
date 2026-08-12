<?php

namespace App\Filament\User\Resources\AlbumVideos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
class AlbumVideosTable
{
    public static function configure(Table $table): Table
    {
        return $table
->columns([
    ImageColumn::make('thumbnail')
        ->label(__('album_videos.thumbnail'))
        ->square()
            ->disk('public')

        ->defaultImageUrl(asset('images/video-placeholder.png')),

    TextColumn::make('title')
        ->label(__('album_videos.title'))
        ->searchable()
        ->sortable()
        ->weight('bold')
        ->limit(40),

    TextColumn::make('user.name')
        ->label(__('album_videos.publisher'))
        ->searchable()
        ->sortable()
        ->badge()
        ->color('primary'),



    TextColumn::make('views')
        ->label(__('album_videos.views'))
        ->numeric()
        ->sortable()
        ->badge()
        ->color('info'),

    TextColumn::make('likes')
        ->label(__('album_videos.likes'))
        ->numeric()
        ->sortable()
        ->badge()
        ->color('success'),

    TextColumn::make('comments_count')
        ->label(__('album_videos.comments'))
        ->numeric()
        ->sortable()
        ->badge()
        ->color('warning'),

    TextColumn::make('language')
        ->label(__('album_videos.fields.language'))
        ->badge(),

    TextColumn::make('visibility')
        ->label(__('album_videos.fields.visibility'))
        ->badge()
        ->color(fn (string $state) => match ($state) {
            'public' => 'success',
            'private' => 'danger',
            'unlisted' => 'warning',
            default => 'gray',
        }),

    IconColumn::make('is_published')
        ->label(__('album_videos.published'))
        ->boolean(),

    IconColumn::make('is_featured')
        ->label(__('album_videos.featured'))
        ->boolean(),

    TextColumn::make('published_at')
        ->label(__('album_videos.published_at'))
        ->since()
        ->sortable(),

    TextColumn::make('created_at')
        ->label(__('album_videos.created'))
        ->dateTime('Y-m-d')
        ->sortable()
        ->toggleable(isToggledHiddenByDefault: true),
])
->filters([
    TrashedFilter::make(),

    SelectFilter::make('user_id')
        ->label(__('album_videos.publisher'))
        ->relationship('user', 'name')
        ->searchable()
        ->preload(),

    SelectFilter::make('language')
        ->label(__('album_videos.fields.language'))
        ->options([
            'ar' => 'العربية',
            'en' => 'English',
            'fr' => 'Français',
        ]),

    SelectFilter::make('visibility')
        ->label(__('album_videos.fields.visibility'))
        ->options([
            'public' => __('album_videos.public'),
            'private' => __('album_videos.private'),
            'unlisted' => __('album_videos.unlisted'),
        ]),

    TernaryFilter::make('is_published')
        ->label(__('album_videos.published')),

    TernaryFilter::make('is_featured')
        ->label(__('album_videos.featured')),

    TernaryFilter::make('allow_comments')
        ->label(__('album_videos.allow_comments')),

    Filter::make('views')
        ->label(__('album_videos.views'))
        ->form([
            TextInput::make('min')
                ->label(__('general.min'))
                ->numeric(),

            TextInput::make('max')
                ->label(__('general.max'))
                ->numeric(),
        ])
        ->query(function ($query, array $data) {
            return $query
                ->when($data['min'], fn ($q) => $q->where('views', '>=', $data['min']))
                ->when($data['max'], fn ($q) => $q->where('views', '<=', $data['max']));
        }),

    Filter::make('likes')
        ->label(__('album_videos.likes'))
        ->form([
            TextInput::make('min')->numeric(),
            TextInput::make('max')->numeric(),
        ])
        ->query(function ($query, array $data) {
            return $query
                ->when($data['min'], fn ($q) => $q->where('likes', '>=', $data['min']))
                ->when($data['max'], fn ($q) => $q->where('likes', '<=', $data['max']));
        }),

    Filter::make('comments')
        ->label(__('album_videos.comments'))
        ->form([
            TextInput::make('min')->numeric(),
            TextInput::make('max')->numeric(),
        ])
        ->query(function ($query, array $data) {
            return $query
                ->when($data['min'], fn ($q) => $q->where('comments_count', '>=', $data['min']))
                ->when($data['max'], fn ($q) => $q->where('comments_count', '<=', $data['max']));
        }),

    Filter::make('duration')
        ->label(__('album_videos.duration'))
        ->form([
            TextInput::make('min')
                ->label(__('general.min_seconds'))
                ->numeric(),

            TextInput::make('max')
                ->label(__('general.max_seconds'))
                ->numeric(),
        ])
        ->query(function ($query, array $data) {
            return $query
                ->when($data['min'], fn ($q) => $q->where('duration', '>=', $data['min']))
                ->when($data['max'], fn ($q) => $q->where('duration', '<=', $data['max']));
        }),

    Filter::make('published_at')
        ->label(__('album_videos.published_at'))
        ->form([
            DatePicker::make('from'),
            DatePicker::make('until'),
        ])
        ->query(function ($query, array $data) {
            return $query
                ->when($data['from'], fn ($q) => $q->whereDate('published_at', '>=', $data['from']))
                ->when($data['until'], fn ($q) => $q->whereDate('published_at', '<=', $data['until']));
        }),

    Filter::make('created_at')
        ->label(__('album_videos.created_at'))
        ->form([
            DatePicker::make('from'),
            DatePicker::make('until'),
        ])
        ->query(function ($query, array $data) {
            return $query
                ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                ->when($data['until'], fn ($q) => $q->whereDate('created_at', '<=', $data['until']));
        }),

    TernaryFilter::make('thumbnail')
        ->label(__('album_videos.has_thumbnail'))
        ->queries(
            true: fn ($query) => $query->whereNotNull('thumbnail'),
            false: fn ($query) => $query->whereNull('thumbnail'),
            blank: fn ($query) => $query,
        ),

    TernaryFilter::make('seo_title')
        ->label(__('album_videos.has_seo'))
        ->queries(
            true: fn ($query) => $query->whereNotNull('seo_title'),
            false: fn ($query) => $query->whereNull('seo_title'),
            blank: fn ($query) => $query,
        ),
], layout: FiltersLayout::Modal)
->filtersFormColumns(3)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
