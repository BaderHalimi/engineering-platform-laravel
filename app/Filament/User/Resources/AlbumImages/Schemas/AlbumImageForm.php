<?php

namespace App\Filament\User\Resources\AlbumImages\Schemas;

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
 use Filament\Forms\Components\Placeholder;

class AlbumImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('tabs')
                    ->columnSpanFull()
                    ->tabs([

                        // ====================== المحتوى ======================
                        Tab::make(__('album_images.tabs.content'))
                            ->schema([
                                Grid::make(3)
                                    ->schema([

                                        // القائمة الكبيرة - يمين
                                        Section::make()
                                            ->columnSpan(2)
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label(__('album_images.fields.title'))
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                                                TextInput::make('slug')
                                                    ->label(__('album_images.fields.slug'))
                                                    ->required()
                                                    ->unique(ignoreRecord: true),

                                                RichEditor::make('description')
                                                    ->label(__('album_images.fields.description'))
                                                    ->columnSpanFull(),

                                                FileUpload::make('image_path')
                                                    ->label(__('album_images.fields.image_path'))
                                                    ->image()
                                                    ->disk('public')
                                                    ->required()
                                                    ->directory('album-images/photos')
                                                    ->columnSpanFull(),

                                                TextInput::make('alt_text')
                                                    ->label(__('album_images.fields.alt_text'))
                                                    ->default(null),
                                            ]),

                                        // القوائم الصغيرة - يسار
                                        Group::make()
                                            ->columnSpan(1)
                                            ->schema([
                                                Section::make(__('album_images.sections.settings'))
                                                    ->schema([
                                                        Toggle::make('featured')
                                                            ->label(__('album_images.fields.featured'))
                                                            ->default(false),

                                                        Select::make('visibility')
                                                            ->label(__('album_images.fields.visibility'))
                                                            ->options([
                                                                'public'  => __('album_images.visibility.public'),
                                                                'private' => __('album_images.visibility.private'),
                                                                'draft'   => __('album_images.visibility.draft'),
                                                            ])
                                                            ->default('public')
                                                            ->required(),

                                                        TextInput::make('sort_order')
                                                            ->label(__('album_images.fields.sort_order'))
                                                            ->numeric()
                                                            ->default(0),


                                                                Placeholder::make('views')
                                                                    ->label(__('album_images.fields.views'))
                                                                    ->content(fn ($record) => $record?->views ?? 0),

                                                                Placeholder::make('likes')
                                                                    ->label(__('album_images.fields.likes'))
                                                                    ->content(fn ($record) => $record?->likes ?? 0),

                                                                Placeholder::make('downloads')
                                                                    ->label(__('album_images.fields.downloads'))
                                                                    ->content(fn ($record) => $record?->downloads ?? 0),

                                                                Placeholder::make('shares')
                                                                    ->label(__('album_images.fields.shares'))
                                                                    ->content(fn ($record) => $record?->shares ?? 0),

                                                    ]),
                                            ]),
                                    ]),
                            ]),

                        // ====================== SEO ======================
                        Tab::make(__('album_images.tabs.seo'))
                            ->schema([
                                TextInput::make('canonical_url')
                                    ->label(__('album_images.fields.canonical_url'))
                                    ->url()
                                    ->columnSpanFull(),

                                TextInput::make('seo_title')
                                    ->label(__('album_images.fields.seo_title')),

                                Textarea::make('seo_description')
                                    ->label(__('album_images.fields.seo_description'))
                                    ->rows(2)
                                    ->columnSpanFull(),

                                TextInput::make('seo_keywords')
                                    ->label(__('album_images.fields.seo_keywords'))
                                    ->columnSpanFull(),

                                Toggle::make('indexable')
                                    ->label(__('album_images.fields.indexable'))
                                    ->default(true),

                                TextInput::make('og_title')
                                    ->label(__('album_images.fields.og_title')),

                                Textarea::make('og_description')
                                    ->label(__('album_images.fields.og_description'))
                                    ->rows(2)
                                    ->columnSpanFull(),

                                FileUpload::make('og_image')
                                    ->label(__('album_images.fields.og_image'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('album-images/og')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
