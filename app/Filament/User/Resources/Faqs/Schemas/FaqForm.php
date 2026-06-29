<?php

namespace App\Filament\User\Resources\Faqs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;


class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(4) // تقسيم الصفحة الكلية إلى 4 أعمدة لتوزيع مرن
            ->components([

                // 1. قسم المحتوى الأساسي (يأخذ 3 أعمدة على اليسار)
                Section::make('المحتوى الأساسي')
                    ->columnSpan(3)
                    ->schema([
                        Textarea::make('ask')
                            ->label('السؤال')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('answer')
                            ->label('الإجابة')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),
                    ]),

                // 2. الجانب الأيمن (يحتوي على النشر والـ SEO)
                Group::make()
                    ->columnSpan(1)
                    ->schema([

                        // قسم الحالة والنشر
                        Section::make('الإعدادات')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('نشط / تفعيل')
                                    ->default(true)
                                    ->required(),
                            ]),

                        // قسم تحسين محركات البحث (SEO)
                        Section::make('SEO')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('عنوان الميتا')
                                    ->default(null),

                                Textarea::make('meta_description')
                                    ->label('وصف الميتا')
                                    ->rows(3)
                                    ->default(null),

                                TextInput::make('meta_keywords')
                                    ->label('الكلمات المفتاحية')
                                    ->default(null),

                                TextInput::make('canonical_url')
                                    ->label('الرابط الكانيلوني (Canonical)')
                                    ->url()
                                    ->default(null),
                            ]),
                    ]),
            ]);
    }
}
