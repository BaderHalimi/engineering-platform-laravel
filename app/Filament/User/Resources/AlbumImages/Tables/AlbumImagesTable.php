<?php

namespace App\Filament\User\Resources\AlbumImages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Storage;
class AlbumImagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('image_path')
                    ->label(__('album_images.fields.image_path'))
                    ->square()
                        ->disk('public')

                    ->url(fn ($record) => $record->image_path ? Storage::url($record->image_path) : null),

                TextColumn::make('title')
                    ->label(__('album_images.fields.title'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40),

                TextColumn::make('user.name')
                    ->label(__('album_images.fields.user'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('link_url')
                    ->label(__('album_images.fields.link_url'))
                    ->limit(30)
                    ->url(fn ($record) => $record->link_url ?: null)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('views')
                    ->label(__('album_images.fields.views'))
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('likes')
                    ->label(__('album_images.fields.likes'))
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('downloads')
                    ->label(__('album_images.fields.downloads'))
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('warning'),

                TextColumn::make('shares')
                    ->label(__('album_images.fields.shares'))
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('secondary'),

                TextColumn::make('visibility')
                    ->label(__('album_images.fields.visibility'))
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'public' => 'success',
                        'private' => 'danger',
                        'draft' => 'warning',
                        default => 'gray',
                    }),

                IconColumn::make('featured')
                    ->label(__('album_images.fields.featured'))
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label(__('album_images.fields.created_at'))
                    ->dateTime('Y-m-d')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label(__('album_images.fields.updated_at'))
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([


                SelectFilter::make('visibility')
                    ->label(__('album_images.fields.visibility'))
                    ->options([
                        'public' => __('album_images.visibility.public'),
                        'private' => __('album_images.visibility.private'),
                        'draft' => __('album_images.visibility.draft'),
                    ]),

                TernaryFilter::make('featured')
                    ->label(__('album_images.fields.featured')),

                Filter::make('views')
                    ->label(__('album_images.fields.views'))
                    ->form([
                        TextInput::make('min')->numeric(),
                        TextInput::make('max')->numeric(),
                    ])
                    ->query(fn ($query, array $data) =>
                        $query
                            ->when($data['min'], fn ($q) => $q->where('views', '>=', $data['min']))
                            ->when($data['max'], fn ($q) => $q->where('views', '<=', $data['max']))
                    ),

                Filter::make('likes')
                    ->label(__('album_images.fields.likes'))
                    ->form([
                        TextInput::make('min')->numeric(),
                        TextInput::make('max')->numeric(),
                    ])
                    ->query(fn ($query, array $data) =>
                        $query
                            ->when($data['min'], fn ($q) => $q->where('likes', '>=', $data['min']))
                            ->when($data['max'], fn ($q) => $q->where('likes', '<=', $data['max']))
                    ),

                Filter::make('downloads')
                    ->label(__('album_images.fields.downloads'))
                    ->form([
                        TextInput::make('min')->numeric(),
                        TextInput::make('max')->numeric(),
                    ])
                    ->query(fn ($query, array $data) =>
                        $query
                            ->when($data['min'], fn ($q) => $q->where('downloads', '>=', $data['min']))
                            ->when($data['max'], fn ($q) => $q->where('downloads', '<=', $data['max']))
                    ),

                Filter::make('shares')
                    ->label(__('album_images.fields.shares'))
                    ->form([
                        TextInput::make('min')->numeric(),
                        TextInput::make('max')->numeric(),
                    ])
                    ->query(fn ($query, array $data) =>
                        $query
                            ->when($data['min'], fn ($q) => $q->where('shares', '>=', $data['min']))
                            ->when($data['max'], fn ($q) => $q->where('shares', '<=', $data['max']))
                    ),

                Filter::make('created_at')
                    ->label(__('album_images.fields.created_at'))
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(fn ($query, array $data) =>
                        $query
                            ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('created_at', '<=', $data['until']))
                    ),

                Filter::make('updated_at')
                    ->label(__('album_images.fields.updated_at'))
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(fn ($query, array $data) =>
                        $query
                            ->when($data['from'], fn ($q) => $q->whereDate('updated_at', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('updated_at', '<=', $data['until']))
                    ),
            ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(2)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
