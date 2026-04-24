<?php

namespace App\Filament\Resources\PostResource\Actions;

use App\Services\GeminiService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class GenerateArticleAction
{
    public static function make(string $name = 'generateArticle'): Action
    {
        return Action::make($name)
            ->label('Tạo bài viết bằng AI')
            ->icon('heroicon-o-sparkles')
            ->color('warning')
            ->modalHeading('Tạo bài viết bằng Gemini AI')
            ->modalDescription('Nhập chủ đề bài viết, AI sẽ tạo nội dung đầy đủ cả tiếng Việt và tiếng Anh.')
            ->modalWidth('lg')
            ->modalIcon('heroicon-o-sparkles')
            ->form([
                TextInput::make('topic')
                    ->label('Chủ đề bài viết')
                    ->placeholder('VD: So sánh máy phân tích phổ Keysight và Rohde & Schwarz')
                    ->required()
                    ->maxLength(300)
                    ->helperText('Mô tả càng chi tiết, bài viết càng chất lượng'),
                Select::make('category_type_ai')
                    ->label('Loại bài viết')
                    ->options([
                        'tin-tuc' => 'Tin tức / Kiến thức',
                        'tuyen-dung' => 'Tuyển dụng',
                    ])
                    ->default('tin-tuc')
                    ->required(),
            ])
            ->action(function (array $data, callable $set): void {
                try {
                    $gemini = app(GeminiService::class);
                    $result = $gemini->generateArticle($data['topic'], $data['category_type_ai']);

                    $set('title.vi', $data['topic']);
                    $set('category_type', $data['category_type_ai']);

                    if (!empty($result['vi'])) {
                        $set('content.vi', $result['vi']);
                    }
                    if (!empty($result['en'])) {
                        $set('content.en', $result['en']);
                    }
                    if (!empty($result['excerpt_vi'])) {
                        $set('excerpt.vi', $result['excerpt_vi']);
                    }
                    if (!empty($result['excerpt_en'])) {
                        $set('excerpt.en', $result['excerpt_en']);
                    }

                    Notification::make()
                        ->title('AI đã tạo bài viết thành công!')
                        ->body('Nội dung đã được điền vào cả tiếng Việt và English. Hãy kiểm tra và chỉnh sửa trước khi xuất bản.')
                        ->success()
                        ->duration(8000)
                        ->send();
                } catch (\Throwable $e) {
                    Notification::make()
                        ->title('Lỗi tạo bài viết AI')
                        ->body($e->getMessage())
                        ->danger()
                        ->duration(10000)
                        ->send();
                }
            })
            ->modalSubmitActionLabel('Tạo bài viết')
            ->modalCancelActionLabel('Hủy');
    }
}
