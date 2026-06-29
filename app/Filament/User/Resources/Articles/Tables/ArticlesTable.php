<?php

namespace App\Filament\User\Resources\Articles\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // عرض الفلاتر داخل Pop-up (Modal) بدلاً من أن تكون منسدلة أو كولابسد
            ->filtersLayout(FiltersLayout::Modal)

            // تخصيص عرض الجدول والأعمدة المهمة فقط
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('الصورة')
                    ->circular(),

                TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                // جلب اسم القسم من علاقة category المذكورة بالموديل
                TextColumn::make('category.name')
                    ->label('القسم')
                    ->searchable()
                    ->sortable(),

                // جلب اسم الكاتب من علاقة user المذكورة بالموديل
                TextColumn::make('user.name')
                    ->label('الكاتب')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'pending' => 'warning',
                        'published' => 'success',
                        'archived' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('views')
                    ->label('المشاهدات')
                    ->numeric()
                    ->sortable(),

                IconColumn::make('is_featured')
                    ->label('ميز')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_trending')
                    ->label('شائع')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('published_at')
                    ->label('تاريخ النشر')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])

            // الفلاتر المتقدمة (تظهر في البوب أب)
            ->filters([
                // 1. فلتر حسب القسم (Category)
                SelectFilter::make('category_id')
                    ->label('تصفية حسب القسم')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                // 2. فلتر حسب المستخدم (User / الكاتب)
                SelectFilter::make('user_id')
                    ->label('تصفية حسب الكاتب')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                // 3. فلتر متقدم حسب الوقت والتاريخ لزمن النشر
                Filter::make('published_at')
                    ->label('تاريخ النشر')
                    ->form([
                        DatePicker::make('published_from')->label('من تاريخ'),
                        DatePicker::make('published_until')->label('إلى تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    }),

                // 4. فلتر المحذوفات الافتراضي
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
