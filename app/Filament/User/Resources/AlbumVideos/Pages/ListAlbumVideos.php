<?php

namespace App\Filament\User\Resources\AlbumVideos\Pages;

use App\Filament\User\Resources\AlbumVideos\AlbumVideoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlbumVideos extends ListRecords
{
    protected static string $resource = AlbumVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
