<?php

namespace App\Filament\User\Resources\AlbumImages\Pages;

use App\Filament\User\Resources\AlbumImages\AlbumImageResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
class CreateAlbumImage extends CreateRecord
{
    protected static string $resource = AlbumImageResource::class;
        protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
}
