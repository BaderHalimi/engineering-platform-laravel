<?php

namespace App\Filament\User\Resources\ServicesRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\Width;
use Filament\Tables\Enums\FiltersLayout;
use App\Models\ServiceCategory;

class ServicesRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service.name')
                    ->label('Service')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('reference')
                    ->searchable(),

                TextColumn::make('assignedto.name')
                    ->label("Assigned to")
                    ->numeric()
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
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        'rejected' => 'Rejected',
                    ]),

                SelectFilter::make('service_id')
                    ->label('By Service')
                    ->relationship('service', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('category')
                    ->label('By Category')
                    ->options(ServiceCategory::query()->pluck('name', 'id'))
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] ?? null,
                            fn(Builder $query, $categoryId) => $query->whereHas(
                                'service',
                                fn(Builder $query) => $query->where('category_id', $categoryId)
                            ),
                        );
                    }),

                SelectFilter::make('user_id')
                    ->label('By Customer')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('assigned_to')
                    ->label('By Assigned To')
                    ->relationship('assignedTo', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('created_at')
                    ->label('Created Date')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('To'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn(Builder $query, $date) => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn(Builder $query, $date) => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

                Filter::make('unassigned')
                    ->label('Unassigned')
                    ->query(fn(Builder $query) => $query->whereNull('assigned_to')),

                Filter::make('overdue')
                    ->label('Overdue')
                    ->query(fn(Builder $query) => $query
                        ->where('status', 'pending')
                        ->where('created_at', '<', now()->subDays(7))),
            ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(3)
            ->filtersFormWidth(Width::FiveExtraLarge)
            ->filtersFormColumns(3)
            ->filtersFormWidth(Width::FiveExtraLarge)
            ->recordActions([
                ViewAction::make(),
                //EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
