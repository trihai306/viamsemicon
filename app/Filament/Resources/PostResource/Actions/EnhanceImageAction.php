<?php

namespace App\Filament\Resources\PostResource\Actions;

use App\Services\GeminiService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EnhanceImageAction
{
    public static function make(string $name = 'enhanceImage'): Action
    {
        return Action::make($name)
            ->label('Tăng cường ảnh AI')
            ->icon('heroicon-o-photo')
            ->color('success')
            ->modalHeading('Tăng cường hình ảnh bằng Gemini AI')
            ->modalDescription('AI sẽ cải thiện chất lượng hình ảnh: tăng độ nét, cân bằng màu sắc, làm sạch nền.')
            ->modalWidth('md')
            ->modalIcon('heroicon-o-photo')
            ->form([
                Select::make('enhancement_type')
                    ->label('Kiểu tăng cường')
                    ->options([
                        'professional' => '✨ Chuyên nghiệp (độ nét + màu sắc)',
                        'bright' => '☀️ Làm sáng hình ảnh',
                        'background' => '🖼️ Làm sạch/trắng nền',
                    ])
                    ->default('professional')
                    ->required(),
            ])
            ->action(function (array $data, callable $get, callable $set): void {
                $imagePath = $get('image');

                if (empty($imagePath)) {
                    Notification::make()
                        ->title('Chưa có hình ảnh')
                        ->body('Vui lòng upload hình ảnh trước khi sử dụng tính năng tăng cường.')
                        ->warning()
                        ->send();
                    return;
                }

                $absolutePath = Storage::disk('public')->path($imagePath);

                if (!file_exists($absolutePath)) {
                    Notification::make()
                        ->title('Không tìm thấy file')
                        ->body("File ảnh không tồn tại: {$imagePath}")
                        ->danger()
                        ->send();
                    return;
                }

                try {
                    $gemini = app(GeminiService::class);
                    $enhancedB64 = $gemini->enhanceImage($absolutePath, $data['enhancement_type']);

                    $newFilename = 'posts/' . Str::uuid() . '-enhanced.jpg';
                    Storage::disk('public')->put($newFilename, base64_decode($enhancedB64));

                    $set('ai_generated_image', $newFilename);

                    Notification::make()
                        ->title('Hình ảnh đã được tăng cường!')
                        ->body('Ảnh enhanced đã lưu: ' . $newFilename . '. Sẽ tự động gắn khi lưu bài.')
                        ->success()
                        ->duration(6000)
                        ->send();
                } catch (\Throwable $e) {
                    Notification::make()
                        ->title('Lỗi tăng cường ảnh')
                        ->body($e->getMessage())
                        ->danger()
                        ->duration(10000)
                        ->send();
                }
            })
            ->modalSubmitActionLabel('Tăng cường ngay')
            ->modalCancelActionLabel('Hủy');
    }
}
