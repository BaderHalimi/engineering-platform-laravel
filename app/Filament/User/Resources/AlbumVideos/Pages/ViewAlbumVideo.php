<?php

namespace App\Filament\User\Resources\AlbumVideos\Pages;

use App\Filament\User\Resources\AlbumVideos\AlbumVideoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAlbumVideo extends ViewRecord
{
    protected static string $resource = AlbumVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
