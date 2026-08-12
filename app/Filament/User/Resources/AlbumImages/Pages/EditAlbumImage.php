<?php

namespace App\Filament\User\Resources\AlbumImages\Pages;

use App\Filament\User\Resources\AlbumImages\AlbumImageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAlbumImage extends EditRecord
{
    protected static string $resource = AlbumImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
