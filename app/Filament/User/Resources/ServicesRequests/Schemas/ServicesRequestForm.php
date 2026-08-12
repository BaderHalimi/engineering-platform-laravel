<?php

namespace App\Filament\User\Resources\ServicesRequests\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ServicesRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('service_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('assigned_to')
                    ->numeric()
                    ->default(null),
                TextInput::make('title')
                    ->required(),
                TextInput::make('reference')
                    ->required(),
                Textarea::make('reason')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('details')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('admin_notes')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->required(),
                TextInput::make('customer_name')
                    ->default(null),
                TextInput::make('customer_email')
                    ->email()
                    ->default(null),
                TextInput::make('customer_phone')
                    ->tel()
                    ->default(null),
                TextInput::make('customer_address')
                    ->default(null),
                Textarea::make('documents')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('meta')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}

