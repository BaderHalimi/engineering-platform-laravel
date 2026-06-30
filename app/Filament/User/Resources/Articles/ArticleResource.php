<?php

namespace App\Filament\User\Resources\Articles;

use App\Filament\User\Resources\Articles\Pages\CreateArticle;
use App\Filament\User\Resources\Articles\Pages\EditArticle;
use App\Filament\User\Resources\Articles\Pages\ListArticles;
use App\Filament\User\Resources\Articles\Schemas\ArticleForm;
use App\Filament\User\Resources\Articles\Tables\ArticlesTable;
use App\Models\Article;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ArticleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArticlesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getNavigationGroup(): ?string
    {
        return __('navigation.content');
    }
    public static function getNavigationLabel(): string
    {
        return __('navigation.articles');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.article');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.articles');
    }
    public static function getPages(): array
    {
        return [
            'index' => ListArticles::route('/'),
            'create' => CreateArticle::route('/create'),
            'edit' => EditArticle::route('/{record}/edit'),
        ];
    }


    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
