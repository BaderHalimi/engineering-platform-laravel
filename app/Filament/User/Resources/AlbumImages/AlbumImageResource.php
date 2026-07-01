<?php

namespace App\Filament\User\Resources\AlbumImages;

use App\Filament\User\Resources\AlbumImages\Pages\CreateAlbumImage;
use App\Filament\User\Resources\AlbumImages\Pages\EditAlbumImage;
use App\Filament\User\Resources\AlbumImages\Pages\ListAlbumImages;
use App\Filament\User\Resources\AlbumImages\Pages\ViewAlbumImage;
use App\Filament\User\Resources\AlbumImages\Schemas\AlbumImageForm;
use App\Filament\User\Resources\AlbumImages\Schemas\AlbumImageInfolist;
use App\Filament\User\Resources\AlbumImages\Tables\AlbumImagesTable;
use App\Models\AlbumImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AlbumImageResource extends Resource
{
    protected static ?string $model = AlbumImage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return AlbumImageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AlbumImageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlbumImagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getNavigationGroup(): ?string
    {
        return __('navigation.content');
    }
    public static function getNavigationLabel(): string
    {
        return __('navigation.album_images');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.album_image');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.album_images');
    }
    public static function getPages(): array
    {
        return [
            'index' => ListAlbumImages::route('/'),
            'create' => CreateAlbumImage::route('/create'),
            'view' => ViewAlbumImage::route('/{record}'),
            'edit' => EditAlbumImage::route('/{record}/edit'),
        ];
    }
}
