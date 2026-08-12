<?php

namespace App\Filament\Resources\ServicesTypes;

use App\Filament\Resources\ServicesTypes\Pages\CreateServicesType;
use App\Filament\Resources\ServicesTypes\Pages\EditServicesType;
use App\Filament\Resources\ServicesTypes\Pages\ListServicesTypes;
use App\Filament\Resources\ServicesTypes\Schemas\ServicesTypeForm;
use App\Filament\Resources\ServicesTypes\Tables\ServicesTypesTable;
use App\Models\ServicesType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServicesTypeResource extends Resource
{
    protected static ?string $model = ServicesType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ServicesTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServicesTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getNavigationLabel(): string
    {
        return __('navigation.services');
    }
    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-briefcase';
    }
    public static function getPages(): array
    {
        return [
            'index' => ListServicesTypes::route('/'),
            'create' => CreateServicesType::route('/create'),
            'edit' => EditServicesType::route('/{record}/edit'),
        ];
    }
}
