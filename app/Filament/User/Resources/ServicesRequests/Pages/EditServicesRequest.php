<?php

namespace App\Filament\User\Resources\ServicesRequests\Pages;

use App\Filament\User\Resources\ServicesRequests\ServicesRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditServicesRequest extends EditRecord
{
    protected static string $resource = ServicesRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
