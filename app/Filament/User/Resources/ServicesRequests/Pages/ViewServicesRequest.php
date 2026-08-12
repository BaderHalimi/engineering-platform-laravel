<?php

namespace App\Filament\User\Resources\ServicesRequests\Pages;

use App\Filament\User\Resources\ServicesRequests\ServicesRequestResource;
use App\Models\ServicesRequest;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\IconPosition;
use Illuminate\Support\Facades\Auth;

class ViewServicesRequest extends ViewRecord
{
    protected static string $resource = ServicesRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [


            Action::make('approve')
                ->label('قبول الطلب')
                ->icon('heroicon-o-check-circle')
                ->iconPosition(IconPosition::Before)
                ->color('success')
                ->visible(fn (ServicesRequest $record): bool => $record->status === 'pending')
                ->requiresConfirmation()
                ->modalHeading('قبول الطلب')
                ->modalDescription('سيتم تعيين هذا الطلب لك، ويمكنك إضافة ملاحظاتك أدناه.')
                ->modalSubmitActionLabel('تأكيد القبول')
                ->schema([
                    Section::make()
                        ->schema([
                            Textarea::make('admin_notes')
                                ->label('الملاحظات')
                                ->placeholder('اكتب ملاحظاتك بخصوص قبول الطلب...')
                                ->rows(4)
                                ->required(),
                        ]),
                ])
                ->action(function (array $data, ServicesRequest $record): void {
                    $record->update([
                        'status' => 'completed',
                        'assigned_to' => Auth::id(),
                        'admin_notes' => $data['admin_notes'] ?? null,
                    ]);

                    Notification::make()
                        ->title('تم قبول الطلب بنجاح')
                        ->success()
                        ->send();
                }),

            Action::make('reject')
                ->label('رفض الطلب')
                ->icon('heroicon-o-x-circle')
                ->iconPosition(IconPosition::Before)
                ->color('danger')
                ->visible(fn (ServicesRequest $record): bool => $record->status === 'pending')
                ->requiresConfirmation()
                ->modalHeading('رفض الطلب')
                ->modalDescription('سيتم تعيين هذا الطلب لك، يرجى كتابة سبب الرفض والملاحظات.')
                ->modalSubmitActionLabel('تأكيد الرفض')
                ->schema([
                    Section::make()
                        ->schema([
                            Textarea::make('reason')
                                ->label('سبب الرفض')
                                ->placeholder('اكتب سبب رفض الطلب...')
                                ->rows(3)
                                ->required(),

                            Textarea::make('admin_notes')
                                ->label('الملاحظات')
                                ->placeholder('اكتب ملاحظات إضافية (اختياري)...')
                                ->rows(3),
                        ]),
                ])
                ->action(function (array $data, ServicesRequest $record): void {
                    $record->update([
                        'status' => 'rejected',
                        'assigned_to' => Auth::id(),
                        'reason' => $data['reason'],
                        'admin_notes' => $data['admin_notes'] ?? null,
                    ]);

                    Notification::make()
                        ->title('تم رفض الطلب')
                        ->danger()
                        ->send();
                }),

            Action::make('reopen')
                ->label('إعادة فتح الطلب')
                ->icon('heroicon-o-arrow-path')
                ->iconPosition(IconPosition::Before)
                ->color('gray')
                ->visible(fn (ServicesRequest $record): bool => in_array($record->status, ['completed', 'rejected']))
                ->requiresConfirmation()
                ->modalHeading('إعادة فتح الطلب')
                ->modalDescription('سيتم إرجاع الطلب إلى حالة الانتظار لمراجعته من جديد.')
                ->action(function (ServicesRequest $record): void {
                    $record->update([
                        'status' => 'pending',
                    ]);

                    Notification::make()
                        ->title('تمت إعادة فتح الطلب')
                        ->warning()
                        ->send();
                }),
        ];
    }
}
