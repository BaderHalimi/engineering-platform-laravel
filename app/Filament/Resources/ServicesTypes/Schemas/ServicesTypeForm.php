<?php

namespace App\Filament\Resources\ServicesTypes\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Schema;

class ServicesTypeForm
{
    public static function configure(Schema $schema): Schema
    {

return $schema
    ->components([

        Select::make('category_id')
            ->relationship('category', 'name')
            ->searchable()
            ->preload()
            ->required()
            ->label(__('services.category'))
            ->helperText(__('services.category_hint')),

        TextInput::make('slug')
            ->required()
            ->unique(ignoreRecord: true)
            ->label(__('services.slug'))
            ->helperText(__('services.slug_hint'))
            ->prefixIcon('heroicon-m-link'),

        TextInput::make('name')
            ->required()
            ->label(__('services.name'))
            ->helperText(__('services.name_hint'))
            ->prefixIcon('heroicon-m-briefcase'),

        Textarea::make('short_description')
            ->label(__('services.short_description'))
            ->rows(2)
            ->helperText(__('services.short_description_hint'))
            ->columnSpanFull(),

        RichEditor::make('description')
            ->label(__('services.description'))
            ->helperText(__('services.description_hint'))
            ->columnSpanFull(),

        FileUpload::make('thumbnail')
            ->label(__('services.thumbnail'))
            ->image()
            ->directory('services')
            ->helperText(__('services.thumbnail_hint')),

        FileUpload::make('icon')
            ->label(__('services.icon'))
            ->image()
            ->directory('services/icons')
            ->helperText(__('services.icon_hint')),

        TextInput::make('estimated_time')
            ->label(__('services.estimated_time'))
            ->helperText(__('services.estimated_time_hint'))
            ->prefixIcon('heroicon-m-clock'),

        TextInput::make('price')
            ->numeric()
            ->label(__('services.price'))
            ->helperText(__('services.price_hint'))
            ->prefix('SAR')
            ->prefixIcon('heroicon-m-currency-dollar'),

        Select::make('price_type')
            ->label(__('services.price_type'))
            ->options([
                'fixed' => __('services.price_fixed'),
                'starting_from' => __('services.price_starting'),
                'quote' => __('services.price_quote'),
            ])
            ->helperText(__('services.price_type_hint'))
            ->prefixIcon('heroicon-m-banknotes'),

        Toggle::make('documented')
            ->label(__('services.documented'))
            ->helperText(__('services.documented_hint')),

        Toggle::make('visit_required')
            ->label(__('services.visit_required'))
            ->helperText(__('services.visit_required_hint')),

        Select::make('status')
            ->label(__('services.status'))
            ->options([
                'active' => __('services.active'),
                'inactive' => __('services.inactive'),
                'draft' => __('services.draft'),
            ])
            ->default('active')
            ->required()
            ->prefixIcon('heroicon-m-check-circle'),

        TextInput::make('sort_order')
            ->numeric()
            ->default(0)
            ->label(__('services.sort_order'))
            ->helperText(__('services.sort_order_hint'))
            ->prefixIcon('heroicon-m-bars-3'),

        TagsInput::make('advantages')
            ->label(__('services.advantages'))
            ->helperText(__('services.advantages_hint'))
            ->columnSpanFull(),

        TagsInput::make('requirements')
            ->label(__('services.requirements'))
            ->helperText(__('services.requirements_hint'))
            ->columnSpanFull(),

        Repeater::make('steps')
            ->label(__('services.steps'))
            ->schema([
                TextInput::make('step')->label(__('services.step')),
            ])
            ->columnSpanFull()
            ->collapsible(),

        Repeater::make('faqs')
            ->label(__('services.faqs'))
            ->schema([
                TextInput::make('question')->label(__('services.question')),
                Textarea::make('answer')->label(__('services.answer')),
            ])
            ->columnSpanFull()
            ->collapsible(),

        FileUpload::make('gallery')
            ->label(__('services.gallery'))
            ->multiple()
            ->image()
            ->directory('services/gallery')
            ->columnSpanFull(),

        TextInput::make('meta_title')
            ->label(__('services.meta_title'))
            ->helperText(__('services.meta_title_hint'))
            ->prefixIcon('heroicon-m-magnifying-glass'),

        Textarea::make('meta_description')
            ->label(__('services.meta_description'))
            ->helperText(__('services.meta_description_hint'))
            ->columnSpanFull(),

        TextInput::make('meta_keywords')
            ->label(__('services.meta_keywords'))
            ->helperText(__('services.meta_keywords_hint'))
            ->prefixIcon('heroicon-m-hashtag'),

        Select::make('created_by')
            ->relationship('creator', 'name')
            ->label(__('services.created_by'))
            ->searchable()
            ->preload()
            ->prefixIcon('heroicon-m-user'),
    ]);
    }
}
