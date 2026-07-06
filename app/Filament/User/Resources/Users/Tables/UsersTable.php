<?php

namespace App\Filament\User\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder; // تأكد من استدعاء الـ Builder

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // 👇 هنا الفلترة: بنقول له هات كل المستخدمين ما عدا اللي الرول بتاعهم 'admin'
            ->modifyQueryUsing(fn (Builder $query) => $query->where('role', '!=', 'admin'))

            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('role')
                    ->badge(),
                ImageColumn::make('profile_image'),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
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
                //
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
