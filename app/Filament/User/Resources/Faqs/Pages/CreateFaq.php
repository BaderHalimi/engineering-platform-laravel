<?php

namespace App\Filament\User\Resources\Faqs\Pages;

use App\Filament\User\Resources\Faqs\FaqResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
class CreateFaq extends CreateRecord
{
    protected static string $resource = FaqResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
        {
            $data['user_id'] = Auth::id();

            return $data;
        }
}
