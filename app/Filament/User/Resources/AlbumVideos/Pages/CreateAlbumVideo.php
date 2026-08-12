<?php

namespace App\Filament\User\Resources\AlbumVideos\Pages;

use App\Filament\User\Resources\AlbumVideos\AlbumVideoResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAlbumVideo extends CreateRecord
{
    protected static string $resource = AlbumVideoResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['user_id'] = Auth::id();

    return $data;
}
}
