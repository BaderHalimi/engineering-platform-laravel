<?php

namespace App\Filament\User\Resources\Faqs\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class FaqsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. اسم المستخدم
                TextColumn::make('user.name')
                    ->label('المستخدم')
                    ->searchable()
                    ->sortable(),

                // 2. اختصار من السؤال (يعرض أول 50 حرف فقط لعدم تشويه الجدول)
                TextColumn::make('ask')
                    ->label('السؤال')
                    ->limit(50)
                    ->searchable(),

                // 3. اختصار من الجواب
                TextColumn::make('answer')
                    ->label('الجواب')
                    ->limit(50)
                    ->searchable(),

                // 4. حالة السؤال (نشط أو غير نشط)
                IconColumn::make('is_active')
                    ->label('الحالة')
                    ->boolean()
                    ->sortable(),

                // 5. وقت الإنشاء والتاريخ
                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                // 1. فلتر تصفية المستخدمين حسب الرتبة (Admin / User) عبر العلاقة
                SelectFilter::make('user_id')
                    ->label('تصفية حسب الكاتب')
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'name',
                        // هنا نقوم بفلترة الأسماء التي تظهر في القائمة المنسدلة للفلتر
                        modifyQueryUsing: fn (Builder $query) => $query->whereIn('role', ['admin', 'user'])
                    )
                    ->searchable()
                    ->preload(),

                Filter::make('created_at')
                    ->label('وقت الإضافة')
                    ->form([
                        DatePicker::make('created_from')->label('من تاريخ'),
                        DatePicker::make('created_until')->label('إلى تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
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
