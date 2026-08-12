<?php

namespace App\Filament\User\Resources\ArticleCategories\Pages;

use App\Filament\User\Resources\ArticleCategories\ArticleCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArticleCategories extends ListRecords
{
    protected static string $resource = ArticleCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
