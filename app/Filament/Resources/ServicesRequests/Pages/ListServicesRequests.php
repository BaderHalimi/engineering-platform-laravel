<?php

namespace App\Filament\Resources\ServicesRequests\Pages;

use App\Filament\Resources\ServicesRequests\ServicesRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListServicesRequests extends ListRecords
{
    protected static string $resource = ServicesRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //CreateAction::make(),
        ];
    }
}
