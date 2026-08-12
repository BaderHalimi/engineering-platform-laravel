<?php

namespace App\Filament\User\Resources\Articles\Pages;

use App\Filament\User\Resources\Articles\ArticleResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['user_id'] = Auth::id();

    $data['reading_time'] = max(
        1,
        (int) ceil(str_word_count(strip_tags($data['content'])) / 200)
    );

    if (
        $data['status'] === 'published'
        && empty($data['published_at'])
    ) {
        $data['published_at'] = now();
    }

    if ($data['status'] !== 'published') {
        $data['published_at'] = null;
    }

    $data['views'] ??= 0;

    return $data;
}
}
