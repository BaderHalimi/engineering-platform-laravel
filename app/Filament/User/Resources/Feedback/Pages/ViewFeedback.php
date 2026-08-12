<?php

namespace App\Filament\User\Resources\Feedback\Pages;

use App\Filament\User\Resources\Feedback\FeedbackResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewFeedback extends ViewRecord
{
    protected static string $resource = FeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('markAsRead')
                ->label('تمت القراءة')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->hidden(fn () => filled($this->record->read_by))
                ->action(function () {
                    $this->record->update([
                        'read_by' => Auth::id(),
                        'read_at' => now(),
                    ]);

                    $this->refreshFormData([
                        'read_by',
                        'read_at',
                    ]);

                    \Filament\Notifications\Notification::make()
                        ->title('تم تعليم الرسالة كمقروءة')
                        ->success()
                        ->send();
                }),
        ];
    }
}
