<?php

namespace App\Filament\User\Resources\ServiceCategories;

use App\Filament\User\Resources\ServiceCategories\Pages\CreateServiceCategory;
use App\Filament\User\Resources\ServiceCategories\Pages\EditServiceCategory;
use App\Filament\User\Resources\ServiceCategories\Pages\ListServiceCategories;
use App\Filament\User\Resources\ServiceCategories\Schemas\ServiceCategoryForm;
use App\Filament\User\Resources\ServiceCategories\Tables\ServiceCategoriesTable;
use App\Models\ServiceCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServiceCategoryResource extends Resource
{
    protected static ?string $model = ServiceCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ServiceCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServiceCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.service_categories');
    }
    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-tag';
    }
        public static function getNavigationGroup(): ?string
    {
        return __('navigation.services');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServiceCategories::route('/'),
            'create' => CreateServiceCategory::route('/create'),
            'edit' => EditServiceCategory::route('/{record}/edit'),
        ];
    }
}
