<?php

namespace App\Filament\Resources\ServicesTypes\Pages;

use App\Filament\Resources\ServicesTypes\ServicesTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListServicesTypes extends ListRecords
{
    protected static string $resource = ServicesTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
