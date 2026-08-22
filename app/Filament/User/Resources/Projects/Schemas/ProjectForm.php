<?php

namespace App\Filament\User\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
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
use Filament\Forms\Components\RichEditor;
class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // created_by مخفي ويتحدد تلقائياً بالمستخدم الحالي
                Hidden::make('created_by')
                    ->default(fn () => auth()->id())
                    ->dehydrated(),

                Tabs::make('tabs')
                    ->columnSpanFull()
                    ->tabs([

                        // ====================== المحتوى ======================
                        Tab::make('المحتوى')
                            ->schema([
                                Grid::make(3)
                                    ->schema([

                                        // العمود الكبير - المحتوى الأساسي
                                        Section::make()
                                            ->columnSpan(2)
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label('العنوان')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                                                TextInput::make('slug')
                                                    ->label('الرابط المختصر')
                                                    ->required()
                                                    ->unique(ignoreRecord: true),

                                                RichEditor::make('description')
                                                    ->label('الوصف')
                                                    ->columnSpanFull()
                                                    ->extraAttributes([
                                                        'style' => 'max-height: 350px; overflow-y: auto;',
                                                        'class' => '[&_.trix-content]:max-h-[250px] [&_.trix-content]:overflow-y-auto [&_.fi-fo-rich-editor]:max-h-[350px]'
                                                    ]),

                                                FileUpload::make('attachments')
                                                    ->label('المرفقات')
                                                    ->disk('public')
                                                    ->directory('projects/attachments')
                                                    ->multiple()
                                                    ->reorderable()
                                                    ->downloadable()
                                                    ->columnSpanFull(),
                                            ]),

                                        // العمود الصغير - الإعدادات والوسائط
                                        Group::make()
                                            ->columnSpan(1)
                                            ->schema([
                                                Section::make('الصور')
                                                    ->schema([
                                                        FileUpload::make('image')
                                                            ->label('صورة الغلاف')
                                                            ->image()
                                                            ->disk('public')
                                                            ->imageEditor()
                                                            ->directory('projects/images'),

                                                        FileUpload::make('additional_images')
                                                            ->label('صور أخرى')
                                                            ->image()
                                                            ->disk('public')
                                                            ->imageEditor()
                                                            ->directory('projects/gallery')
                                                            ->multiple()
                                                            ->reorderable()
                                                            ->columnSpanFull(),

                                                        FileUpload::make('separator_image')
                                                            ->label('صورة الفاصل')
                                                            ->image()
                                                            ->disk('public')
                                                            ->imageEditor()
                                                            ->directory('projects/separators')
                                                            ->helperText('تظهر بين المشاريع داخل سلايدر الصفحة الرئيسية.'),
                                                    ]),

                                                Section::make('الإعدادات')
                                                    ->schema([
                                                        Select::make('category_id')
                                                            ->label('التصنيف')
                                                            ->relationship('category', 'name')
                                                            ->searchable()
                                                            ->preload()
                                                            ->required(),

                                                        Toggle::make('is_active')
                                                            ->label('مفعل')
                                                            ->default(true)
                                                            ->required(),

                                                        TextInput::make('sort_order')
                                                            ->label('ترتيب العرض')
                                                            ->numeric()
                                                            ->default(0)
                                                            ->required(),
                                                    ]),
                                            ]),
                                    ]),
                            ]),

                        // ====================== SEO ======================
                        Tab::make('SEO')
                            ->schema([
                                TextInput::make('canonical_url')
                                    ->label('الرابط الأساسي (Canonical URL)')
                                    ->url()
                                    ->default(null)
                                    ->columnSpanFull(),

                                TextInput::make('meta_title')
                                    ->label('عنوان الميتا')
                                    ->default(null),

                                TextInput::make('og_title')
                                    ->label('عنوان OG')
                                    ->default(null),

                                Textarea::make('meta_description')
                                    ->label('وصف الميتا')
                                    ->rows(2)
                                    ->default(null)
                                    ->columnSpanFull(),

                                Textarea::make('meta_keywords')
                                    ->label('كلمات مفتاحية')
                                    ->rows(2)
                                    ->default(null)
                                    ->columnSpanFull(),

                                Textarea::make('og_description')
                                    ->label('وصف OG')
                                    ->rows(2)
                                    ->default(null)
                                    ->columnSpanFull(),

                                FileUpload::make('og_image')
                                    ->label('صورة OG')
                                    ->image()
                                    ->disk('public')
                                    ->directory('projects/og')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
