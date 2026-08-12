<?php

namespace App\Filament\User\Resources\AlbumImages\Pages;

use App\Filament\User\Resources\AlbumImages\AlbumImageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlbumImages extends ListRecords
{
    protected static string $resource = AlbumImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
