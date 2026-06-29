<?php

namespace App\Filament\User\Resources\ServicesTypes\Pages;

use App\Filament\User\Resources\ServicesTypes\ServicesTypeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
class CreateServicesType extends CreateRecord
{
    protected static string $resource = ServicesTypeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();

        return $data;
    }
}
