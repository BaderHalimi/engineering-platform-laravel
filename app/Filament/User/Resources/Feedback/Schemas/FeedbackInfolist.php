<?php

namespace App\Filament\User\Resources\Feedback\Schemas;

use Filament\Schemas\Components\Section;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
class FeedbackInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make(__('feedback.sections.message_info'))
                    ->icon('heroicon-o-envelope')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('email')
                                ->label(__('feedback.fields.email')),

                            TextEntry::make('title')
                                ->label(__('feedback.fields.title')),
                        ]),

                        TextEntry::make('content')
                            ->label(__('feedback.fields.content'))
                            ->columnSpanFull()
                            ->markdown(),
                    ]),

                // === المرفقات ===
                Section::make(__('feedback.sections.attachments'))
                    ->icon('heroicon-o-paper-clip')
                    ->collapsible()
                    ->schema([
                        RepeatableEntry::make('attachments')  // نفترض أن attachments هي array/json
                            ->label('')
                            ->schema(function ($state) {
                                // $state هنا هو مسار الملف الواحد
                                $extension = strtolower(pathinfo($state, PATHINFO_EXTENSION));

                                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                    return [
                                        ImageEntry::make('attachments')
                                            ->label(__('feedback.attachments.image'))
                                            ->size(400)
                                            ->extraAttributes(['class' => 'rounded-lg shadow-md']),
                                    ];
                                } elseif (in_array($extension, ['mp4', 'webm', 'ogg'])) {
                                    return [
                                        TextEntry::make('attachments')
                                            ->label(__('feedback.attachments.video'))
                                            ->html()
                                            ->state(fn() => '
                                                <video width="100%" height="300" controls class="rounded-lg shadow-md">
                                                    <source src="' . Storage::url($state) . '" type="video/' . $extension . '">
                                                    ' . __('feedback.attachments.video_not_supported') . '
                                                </video>
                                            '),
                                    ];
                                } elseif ($extension === 'pdf') {
                                    return [
                                        TextEntry::make('attachments')
                                            ->label(__('feedback.attachments.pdf'))
                                            ->html()
                                            ->state(function () use ($state) {
                                                $url = Storage::url($state);
                                                return '
                                                    <div class="space-y-3">
                                                        <iframe src="' . $url . '" width="100%" height="500" class="rounded-lg border shadow"></iframe>
                                                        <a href="' . $url . '"
                                                           target="_blank"
                                                           class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v-4m0 0l4 4m-4-4l4-4m12 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8" />
                                                            </svg>
                                                            ' . __('feedback.attachments.download_pdf') . '
                                                        </a>
                                                    </div>
                                                ';
                                            }),
                                    ];
                                } else {
                                    // ملفات أخرى (تحميل مباشر)
                                    return [
                                        TextEntry::make('attachments')
                                            ->label(__('feedback.attachments.file'))
                                            ->html()
                                            ->state(function () use ($state) {
                                                $url = Storage::url($state);
                                                $filename = basename($state);
                                                return '
                                                    <a href="' . $url . '"
                                                       target="_blank"
                                                       class="inline-flex items-center gap-2 text-blue-600 hover:underline">
                                                        📎 ' . $filename . '
                                                    </a>
                                                ';
                                            }),
                                    ];
                                }
                            })
                            ->columns(1)
                            ->contained(false),
                    ]),

                Section::make(__('feedback.sections.read_status'))
                    ->icon('heroicon-o-eye')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('read_at')
                                ->label(__('feedback.fields.read_at'))
                                ->dateTime('d/m/Y H:i')
                                ->placeholder(__('feedback.placeholders.not_read')),

                            TextEntry::make('reader.name')
                                ->label(__('feedback.fields.reader'))
                                ->placeholder(__('feedback.placeholders.no_reader'))
                                ->badge()
                                ->color('success'),
                        ]),
                    ]),

                // === التواريخ ===
                Section::make(__('feedback.sections.dates'))
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('feedback.fields.created_at'))
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('updated_at')
                            ->label(__('feedback.fields.updated_at'))
                            ->dateTime('d/m/Y H:i'),
                    ]),
            ]);
    }
}
