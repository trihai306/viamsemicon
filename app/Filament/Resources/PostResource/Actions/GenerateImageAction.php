<?php

namespace App\Filament\Resources\PostResource\Actions;

use App\Services\GeminiService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateImageAction
{
    public static function make(string $name = 'generateImage'): Action
    {
        return Action::make($name)
            ->label('Tạo ảnh AI')
            ->icon('heroicon-o-paint-brush')
            ->color('danger')
            ->modalHeading('Tạo hình ảnh bằng Gemini AI')
            ->modalDescription('AI sẽ tạo hình ảnh chuyên nghiệp từ mô tả của bạn.')
            ->modalWidth('lg')
            ->modalIcon('heroicon-o-paint-brush')
            ->form([
                TextInput::make('image_description')
                    ->label('Mô tả hình ảnh')
                    ->placeholder('VD: Máy phân tích phổ Keysight trên bàn phòng thí nghiệm')
                    ->required()
                    ->maxLength(500)
                    ->helperText('Mô tả chi tiết sản phẩm/cảnh muốn tạo'),
                Select::make('image_style')
                    ->label('Kiểu ảnh')
                    ->options([
                        'product' => '📦 Ảnh sản phẩm (nền trắng, studio)',
                        'banner' => '🖼️ Banner website (rộng, hiện đại)',
                        'thumbnail' => '📰 Thumbnail bài viết',
                    ])
                    ->default('product')
                    ->required(),
            ])
            ->action(function (array $data, callable $set): void {
                try {
                    $gemini = app(GeminiService::class);
                    $imageB64 = $gemini->generateImage(
                        $data['image_description'],
                        $data['image_style']
                    );

                    $filename = 'posts/' . Str::uuid() . '-ai-generated.jpg';
                    Storage::disk('public')->put($filename, base64_decode($imageB64));

                    $set('ai_generated_image', $filename);

                    Notification::make()
                        ->title('Ảnh AI đã được tạo!')
                        ->body('Ảnh đã lưu tại: ' . $filename . '. Ảnh sẽ tự động gắn khi lưu bài viết.')
                        ->success()
                        ->duration(8000)
                        ->send();
                } catch (\Throwable $e) {
                    Notification::make()
                        ->title('Lỗi tạo ảnh AI')
                        ->body($e->getMessage())
                        ->danger()
                        ->duration(10000)
                        ->send();
                }
            })
            ->modalSubmitActionLabel('Tạo ảnh')
            ->modalCancelActionLabel('Hủy');
    }
}
