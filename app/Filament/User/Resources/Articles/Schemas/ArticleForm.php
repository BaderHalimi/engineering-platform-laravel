<?php

namespace App\Filament\User\Resources\Articles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema; // ملحوظة: تأكد إن كان الاسم الصحيح هو Forms\Form أو Schemas\Schema حسب إصدارك
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(4)
            ->components([


                Section::make('Content')
                    ->columnSpan(3)
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('slug', str($state)->slug())
                            )
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->required(),

                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),

                        FileUpload::make('thumbnail')
                            ->image()
                            ->disk('public')
                            ->directory('articles/thumbnails'),

                        RichEditor::make('content')
                            ->required()
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'bulletList', 'orderedList', 'blockquote',
                                'h2', 'h3', 'link', 'undo', 'redo',
                            ])
                            ->columnSpanFull(),

                        FileUpload::make('attachments')
                            ->multiple()
                            ->disk('public')
                            ->directory('articles/files')
                            ->columnSpanFull(),

                        TagsInput::make('tags')
                            ->columnSpanFull(),
                    ]),

                Group::make()
                    ->columnSpan(1)
                    ->schema([

                        Section::make('Publishing')
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'pending' => 'Pending',
                                        'archived' => 'Archived',
                                    ])
                                    ->default('draft')
                                    ->native(false)
                                    ->required(),

                                DateTimePicker::make('published_at')
                                    ->visible(fn ($get) => $get('status') === 'published'),

                                Toggle::make('is_featured'),
                                Toggle::make('is_trending'),
                            ]),

                        Section::make('SEO')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                TextInput::make('meta_title')
                                    ->maxLength(255),
                                Textarea::make('meta_description')
                                    ->rows(4),
                                TagsInput::make('meta_keywords'),
                                TextInput::make('canonical_url')
                                    ->url(),
                                FileUpload::make('og_image')
                                ->disk('public')
                                    ->image()
                                    ->directory('articles/seo'),
                            ]),
                    ]),
            ]);
    }
}
