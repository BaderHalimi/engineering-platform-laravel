<?php

namespace App\Filament\User\Resources\ServicesRequests;

use App\Filament\User\Resources\ServicesRequests\Pages\CreateServicesRequest;
use App\Filament\User\Resources\ServicesRequests\Pages\EditServicesRequest;
use App\Filament\User\Resources\ServicesRequests\Pages\ListServicesRequests;
use App\Filament\User\Resources\ServicesRequests\Pages\ViewServicesRequest;
use App\Filament\User\Resources\ServicesRequests\Schemas\ServicesRequestForm;
use App\Filament\User\Resources\ServicesRequests\Schemas\ServicesRequestInfolist;
use App\Filament\User\Resources\ServicesRequests\Tables\ServicesRequestsTable;
use App\Models\ServicesRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServicesRequestResource extends Resource
{
    protected static ?string $model = ServicesRequest::class;

protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ServicesRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ServicesRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServicesRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
public static function getNavigationGroup(): ?string
{
    return __('navigation.services');
}

public static function getNavigationLabel(): string
{
    return __('navigation.service_requests');
}

public static function getModelLabel(): string
{
    return __('navigation.service_request');
}

public static function getPluralModelLabel(): string
{
    return __('navigation.service_requests');
}
    public static function getPages(): array
    {
        return [
            'index' => ListServicesRequests::route('/'),
            'create' => CreateServicesRequest::route('/create'),
            'view' => ViewServicesRequest::route('/{record}'),
            'edit' => EditServicesRequest::route('/{record}/edit'),
        ];
    }
}
