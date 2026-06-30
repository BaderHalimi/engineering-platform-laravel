<?php

namespace App\Filament\User\Resources\AlbumVideos\Pages;

use App\Filament\User\Resources\AlbumVideos\AlbumVideoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAlbumVideo extends EditRecord
{
    protected static string $resource = AlbumVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['video_type'] ?? null) === 'embed') {
            $data['video_path'] = null;
        } else {
            $data['embed'] = null;
        }

        unset($data['video_type']);

        return $data;
    }
}
