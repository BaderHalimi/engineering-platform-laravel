<?php

namespace App\Filament\User\Resources\ServicesTypes\Pages;

use App\Filament\User\Resources\ServicesTypes\ServicesTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
class EditServicesType extends EditRecord
{
    protected static string $resource = ServicesTypeResource::class;
    /////////////////// error
    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     $data['created_by'] = Auth::id();
    //
    //     return $data;
    // }
    /////////////////
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
