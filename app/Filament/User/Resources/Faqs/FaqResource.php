<?php

namespace App\Filament\User\Resources\Faqs;

use App\Filament\User\Resources\Faqs\Pages\CreateFaq;
use App\Filament\User\Resources\Faqs\Pages\EditFaq;
use App\Filament\User\Resources\Faqs\Pages\ListFaqs;
use App\Filament\User\Resources\Faqs\Schemas\FaqForm;
use App\Filament\User\Resources\Faqs\Tables\FaqsTable;
use App\Models\Faq;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?string $recordTitleAttribute = 'ask';

    public static function form(Schema $schema): Schema
    {
        return FaqForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FaqsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getNavigationGroup(): ?string
    {
        return __('navigation.help_support');
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.faqs');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.faq');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.faqs');
    }
    public static function getPages(): array
    {
        return [
            'index' => ListFaqs::route('/'),
            'create' => CreateFaq::route('/create'),
            'edit' => EditFaq::route('/{record}/edit'),
        ];
    }
}
