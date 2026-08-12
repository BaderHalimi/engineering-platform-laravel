<?php

namespace App\Filament\Resources\ServicesTypes\Pages;

use App\Filament\Resources\ServicesTypes\ServicesTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditServicesType extends EditRecord
{
    protected static string $resource = ServicesTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
