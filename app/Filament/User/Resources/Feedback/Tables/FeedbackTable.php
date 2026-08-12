<?php

namespace App\Filament\User\Resources\Feedback\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class FeedbackTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('feedback.fields.title'))
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_read')
                    ->label(__('feedback.fields.is_read'))
                    ->boolean()
                    ->state(fn($record) => ! is_null($record->read_by)),

                TextColumn::make('reader.name')
                    ->label(__('feedback.fields.reader'))
                    ->placeholder('-')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label(__('feedback.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])

            ->filters([
                SelectFilter::make('read_by')
                    ->label(__('feedback.filters.read_by'))
                    ->relationship('reader', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('is_read')
                    ->label(__('feedback.filters.status'))
                    ->options([
                        '1' => __('feedback.status.read'),
                        '0' => __('feedback.status.unread'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value'] ?? null) {
                            '1' => $query->whereNotNull('read_by'),
                            '0' => $query->whereNull('read_by'),
                            default => $query,
                        };
                    }),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
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
            ])

            ->recordActions([
                ViewAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
