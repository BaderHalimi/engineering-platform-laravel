<?php

namespace App\Filament\User\Resources\ServicesTypes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTypesTable
{

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label(__('services.name'))
                    ->searchable()
                    ->weight('bold')
                    ->limit(25),

                TextColumn::make('category.name')
                    ->label(__('services.category'))
                    ->badge()
                    ->color('primary'),

                TextColumn::make('slug')
                    ->label(__('services.slug'))
                    ->searchable()
                    ->limit(20)
                    ->toggleable(),

                ImageColumn::make('thumbnail')
                    ->label(__('services.thumbnail'))
                    ->circular(),

                ImageColumn::make('icon')
                    ->label(__('services.icon'))
                    ->circular(),

                TextColumn::make('estimated_time')
                    ->label(__('services.estimated_time'))
                    ->badge()
                    ->color('gray'),

                TextColumn::make('price')
                    ->label(__('services.price'))
                    ->money('SAR')
                    ->sortable(),

                TextColumn::make('price_type')
                    ->label(__('services.price_type'))
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'fixed' => __('services.price_fixed'),
                        'starting_from' => __('services.price_starting'),
                        'quote' => __('services.price_quote'),
                        default => $state,
                    }),

                IconColumn::make('documented')
                    ->label(__('services.documented'))
                    ->boolean(),

                IconColumn::make('visit_required')
                    ->label(__('services.visit_required'))
                    ->boolean(),

                TextColumn::make('status')
                    ->label(__('services.status'))
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        'draft' => 'warning',
                    }),

                TextColumn::make('sort_order')
                    ->label(__('services.sort_order'))
                    ->sortable(),

                TextColumn::make('creator.name')
                    ->label(__('services.created_by'))
                    ->toggleable()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => __('services.active'),
                        'inactive' => __('services.inactive'),
                        'draft' => __('services.draft'),
                    ]),
                SelectFilter::make('created_by')
                    ->label(__('services.created_by'))
                    ->relationship(
                        'creator',
                        'name',
                        fn ($query) => $query->whereIn('role', ['admin', 'user'])
                    )
                    ->searchable()
                    ->preload(),
                SelectFilter::make('category_id')
                    ->relationship('category', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
