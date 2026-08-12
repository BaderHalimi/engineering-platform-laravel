<?php

namespace App\Filament\User\Resources\ArticleCategories\Pages;

use App\Filament\User\Resources\ArticleCategories\ArticleCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticleCategory extends CreateRecord
{
    protected static string $resource = ArticleCategoryResource::class;
}
