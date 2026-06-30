<?php

namespace App\Filament\User\Resources\AlbumVideos;

use App\Filament\User\Resources\AlbumVideos\Pages\CreateAlbumVideo;
use App\Filament\User\Resources\AlbumVideos\Pages\EditAlbumVideo;
use App\Filament\User\Resources\AlbumVideos\Pages\ListAlbumVideos;
use App\Filament\User\Resources\AlbumVideos\Pages\ViewAlbumVideo;
use App\Filament\User\Resources\AlbumVideos\Schemas\AlbumVideoForm;
use App\Filament\User\Resources\AlbumVideos\Schemas\AlbumVideoInfolist;
use App\Filament\User\Resources\AlbumVideos\Tables\AlbumVideosTable;
use App\Models\AlbumVideo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlbumVideoResource extends Resource
{
    protected static ?string $model = AlbumVideo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return AlbumVideoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AlbumVideoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlbumVideosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAlbumVideos::route('/'),
            'create' => CreateAlbumVideo::route('/create'),
            'view' => ViewAlbumVideo::route('/{record}'),
            'edit' => EditAlbumVideo::route('/{record}/edit'),
        ];
    }
    public static function getNavigationLabel(): string
    {
        return __('album_videos.album_videos');
    }
    public static function getNavigationGroup(): ?string
    {
        return __('navigation.content');
    }
    public static function getModelLabel(): string
    {
        return __('album_videos.album_video');
    }

    public static function getPluralModelLabel(): string
    {
        return __('album_videos.album_videos');
    }
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
