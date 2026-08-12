<?php

namespace App\Filament\User\Resources\ServiceCategories\Pages;

use App\Filament\User\Resources\ServiceCategories\ServiceCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateServiceCategory extends CreateRecord
{
    protected static string $resource = ServiceCategoryResource::class;
}
