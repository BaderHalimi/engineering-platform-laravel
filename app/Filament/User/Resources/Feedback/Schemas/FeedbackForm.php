<?php

namespace App\Filament\User\Resources\Feedback\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FeedbackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('attachments')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('meta')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('read_at'),
                TextInput::make('read_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
