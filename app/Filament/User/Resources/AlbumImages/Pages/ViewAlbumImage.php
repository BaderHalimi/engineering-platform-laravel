<?php

namespace App\Filament\User\Resources\AlbumImages\Pages;

use App\Filament\User\Resources\AlbumImages\AlbumImageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAlbumImage extends ViewRecord
{
    protected static string $resource = AlbumImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
