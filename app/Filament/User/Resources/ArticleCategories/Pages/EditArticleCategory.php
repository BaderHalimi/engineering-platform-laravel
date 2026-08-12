<?php

namespace App\Filament\User\Resources\ArticleCategories\Pages;

use App\Filament\User\Resources\ArticleCategories\ArticleCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditArticleCategory extends EditRecord
{
    protected static string $resource = ArticleCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
