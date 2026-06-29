<?php

namespace App\Filament\Resources\ServicesRequests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use App\Models\ServicesRequest;
use App\Models\ServicesType;
use Filament\Forms\Components\Select;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
class ServicesRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)

            ->components([

                Section::make('Request Information')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->collapsible()
                    ->extraAttributes(['class' => 'sr-section sr-section-primary'])
                    ->schema([
                        TextEntry::make('title')
                            ->weight(FontWeight::Bold)
                            ->columnSpanFull(),

                        TextEntry::make('service.name')
                            ->label('Service')
                            ->icon('heroicon-o-briefcase')
                            ->badge()
                            ->color('gray'),

                        TextEntry::make('reference')
                            ->icon('heroicon-o-hashtag')
                            ->copyable()
                            ->copyMessage('Reference copied')
                            ->fontFamily('mono'),

                        TextEntry::make('status')
                            ->badge()
                            ->icon(fn (string $state): string => match ($state) {
                                'pending' => 'heroicon-o-clock',
                                'approved' => 'heroicon-o-check-circle',
                                'rejected' => 'heroicon-o-x-circle',
                                default => 'heroicon-o-question-mark-circle',
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('created_at')
                            ->label('Submitted At')
                            ->icon('heroicon-o-calendar')
                            ->dateTime()
                            ->since()
                            ->dateTimeTooltip(),

                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->icon('heroicon-o-arrow-path')
                            ->since()
                            ->dateTimeTooltip(),
                    ])
                    ->columns(3),

                Section::make('Customer')
                    ->icon('heroicon-o-user')
                    ->collapsible()
                    ->extraAttributes(['class' => 'sr-section sr-section-customer'])
                    ->schema([

                        TextEntry::make('account_type')
                            ->label('Account Type')
                            ->state(fn (ServicesRequest $record): string => $record->user_id ? 'Registered User' : 'Guest')
                            ->badge()
                            ->color(fn (ServicesRequest $record): string => $record->user_id ? 'success' : 'gray')
                            ->icon(fn (ServicesRequest $record): string => $record->user_id ? 'heroicon-o-shield-check' : 'heroicon-o-user-circle')
                            ->columnSpanFull(),

                        TextEntry::make('user.name')
                            ->label('Registered User')
                            ->icon('heroicon-o-identification')
                            ->visible(fn (ServicesRequest $record): bool => filled($record->user_id)),

                        TextEntry::make('user.email')
                            ->label('Account Email')
                            ->icon('heroicon-o-at-symbol')
                            ->copyable()
                            ->visible(fn (ServicesRequest $record): bool => filled($record->user_id) && filled($record->user?->email)),

                        TextEntry::make('customer_name')
                            ->label('Full Name')
                            ->icon('heroicon-o-identification')
                            ->visible(fn (ServicesRequest $record): bool => blank($record->user_id) && filled($record->customer_name)),

                        TextEntry::make('customer_email')
                            ->label('Email')
                            ->icon('heroicon-o-at-symbol')
                            ->copyable()
                            ->visible(fn (ServicesRequest $record): bool => filled($record->customer_email)),

                        TextEntry::make('customer_phone')
                            ->label('Phone')
                            ->icon('heroicon-o-phone')
                            ->copyable()
                            ->visible(fn (ServicesRequest $record): bool => filled($record->customer_phone)),

                        TextEntry::make('customer_address')
                            ->label('Address')
                            ->icon('heroicon-o-map-pin')
                            ->columnSpanFull()
                            ->visible(fn (ServicesRequest $record): bool => filled($record->customer_address)),
                    ])
                    ->columns(2),

                Section::make('Request Details')
                    ->icon('heroicon-o-document-text')
                    ->collapsible()
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'sr-section sr-section-details'])
                    ->schema([



                        TextEntry::make('details')
                            ->markdown()
                            ->placeholder('-')
                            ->prose()
                            ->columnSpanFull(),
                    ]),

                Section::make('Review')
                    ->icon('heroicon-o-check-badge')
                    ->collapsible()
                    ->columnSpanFull()
                    ->extraAttributes(fn (ServicesRequest $record) => [
                        'class' => 'sr-section sr-section-review ' . match ($record->status) {
                            'approved' => 'sr-review-approved',
                            'rejected' => 'sr-review-rejected',
                            default => 'sr-review-pending',
                        },
                    ])
                    ->schema([

                        TextEntry::make('assignedTo.name')
                            ->label('Assigned Employee')
                            ->icon('heroicon-o-user-circle')
                            ->iconPosition(IconPosition::Before)
                            ->badge()
                            ->color('info')
                            ->placeholder('Not Assigned'),

                        TextEntry::make('reason')
                            ->label('Rejection Reason')
                            ->icon('heroicon-o-exclamation-triangle')
                            ->color('danger')
                            ->visible(fn (ServicesRequest $record): bool => $record->status === 'rejected' && filled($record->reason)),

                        TextEntry::make('admin_notes')
                            ->label('Notes')
                            ->icon('heroicon-o-pencil-square')
                            ->placeholder('No notes')
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

                Section::make('Attachments')
                    ->icon('heroicon-o-paper-clip')
                    ->collapsed()
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'sr-section sr-section-attachments'])
                    ->schema([
                        TextEntry::make('documents')
                            ->label('')
                            ->placeholder('No documents')
                            ->badge()
                            ->separator(',')
                            ->icon('heroicon-o-document'),
                    ]),
            ]);
    }
}
