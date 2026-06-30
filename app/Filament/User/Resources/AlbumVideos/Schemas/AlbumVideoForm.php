<?php

namespace App\Filament\User\Resources\AlbumVideos\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AlbumVideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('tabs')
                    ->columnSpanFull()
                    ->tabs([

                        // ====================== المحتوى ======================
                        Tab::make(__('album_videos.tabs.content'))
                            ->schema([
                                Grid::make(3)
                                    ->schema([

                                        // القائمة الكبيرة - يمين
                                        Section::make()
                                            ->columnSpan(2)
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label(__('album_videos.fields.title'))
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                                                TextInput::make('slug')
                                                    ->label(__('album_videos.fields.slug'))
                                                    ->required()
                                                    ->unique(ignoreRecord: true),

                                                RichEditor::make('description')
                                                    ->label(__('album_videos.fields.description'))
                                                    ->columnSpanFull(),

                                                Radio::make('video_type')
                                                    ->label(__('album_videos.fields.video_type'))
                                                    ->options([
                                                        'upload' => __('album_videos.video_type.upload'),
                                                        'embed'  => __('album_videos.video_type.embed'),
                                                    ])
                                                    ->inline()
                                                    ->live()
                                                    ->dehydrated(false)
                                                    ->default(fn ($record) => filled($record?->embed) ? 'embed' : 'upload')
                                                    ->required(),

                                                FileUpload::make('video_path')
                                                    ->label(__('album_videos.fields.video_path'))
                                                    ->directory('album-videos/videos')
                                                    ->disk('public')
                                                    ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                                                    ->visible(fn ($get) => $get('video_type') === 'upload')
                                                    ->required(fn ($get) => $get('video_type') === 'upload')
                                                    ->dehydrated(fn ($get) => $get('video_type') === 'upload')
                                                    ->columnSpanFull(),

                                                Textarea::make('embed')
                                                    ->label(__('album_videos.fields.embed'))
                                                    ->helperText(__('album_videos.helpers.embed'))
                                                    ->rows(3)
                                                    ->visible(fn ($get) => $get('video_type') === 'embed')
                                                    ->required(fn ($get) => $get('video_type') === 'embed')
                                                    ->dehydrated(fn ($get) => $get('video_type') === 'embed')
                                                    ->columnSpanFull(),
                                            ]),

                                        // القوائم الصغيرة - يسار (فوق بعض)
                                        Group::make()
                                            ->columnSpan(1)
                                            ->schema([
                                                Section::make(__('album_videos.sections.thumbnail'))
                                                    ->schema([
                                                        FileUpload::make('thumbnail')
                                                            ->label(__('album_videos.fields.thumbnail'))
                                                            ->image()
                                                            ->disk('public')
                                                            ->imageEditor()
                                                            ->required()
                                                            ->directory('album-videos/thumbnails'),

                                                        TextInput::make('duration')
                                                            ->label(__('album_videos.fields.duration'))
                                                            ->numeric()
                                                            ->suffix(__('album_videos.helpers.seconds'))
                                                            ->disabled()
                                                            ->dehydrated()
                                                            ->visible(fn ($get) => $get('video_type') === 'upload'),
                                                    ]),

                                                Section::make(__('album_videos.sections.settings'))
                                                    ->schema([
                                                        Toggle::make('is_published')
                                                            ->label(__('album_videos.fields.is_published'))
                                                            ->live()
                                                            ->default(false),

                                                        Toggle::make('is_featured')
                                                            ->label(__('album_videos.fields.is_featured'))
                                                            ->default(false),

                                                        Toggle::make('allow_comments')
                                                            ->label(__('album_videos.fields.allow_comments'))
                                                            ->default(true),

                                                        DateTimePicker::make('published_at')
                                                            ->label(__('album_videos.fields.published_at'))
                                                            ->native(false)
                                                            ->visible(fn ($get) => $get('is_published'))
                                                            ->default(now()),

                                                        Select::make('visibility')
                                                            ->label(__('album_videos.fields.visibility'))
                                                            ->options([
                                                                'public'   => __('album_videos.visibility.public'),
                                                                'private'  => __('album_videos.visibility.private'),
                                                                'unlisted' => __('album_videos.visibility.unlisted'),
                                                            ])
                                                            ->default('public')
                                                            ->required(),

                                                        Select::make('language')
                                                            ->label(__('album_videos.fields.language'))
                                                            ->options([
                                                                'ar' => __('album_videos.language.ar'),
                                                                'en' => __('album_videos.language.en'),
                                                                'fr' => __('album_videos.language.fr'),
                                                            ])
                                                            ->default('ar')
                                                            ->required(),
                                                    ]),
                                            ]),
                                    ]),
                            ]),

                        // ====================== SEO ======================
                        Tab::make(__('album_videos.tabs.seo'))
                            ->schema([
                                TextInput::make('canonical_url')
                                    ->label(__('album_videos.fields.canonical_url'))
                                    ->url()
                                    ->columnSpanFull(),

                                TextInput::make('seo_title')
                                    ->label(__('album_videos.fields.seo_title')),

                                Textarea::make('seo_description')
                                    ->label(__('album_videos.fields.seo_description'))
                                    ->rows(2)
                                    ->columnSpanFull(),

                                TextInput::make('seo_keywords')
                                    ->label(__('album_videos.fields.seo_keywords'))
                                    ->columnSpanFull(),

                                TextInput::make('og_title')
                                    ->label(__('album_videos.fields.og_title')),

                                Textarea::make('og_description')
                                    ->label(__('album_videos.fields.og_description'))
                                    ->rows(2)
                                    ->columnSpanFull(),

                                FileUpload::make('og_image')
                                    ->label(__('album_videos.fields.og_image'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('album-videos/og')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
