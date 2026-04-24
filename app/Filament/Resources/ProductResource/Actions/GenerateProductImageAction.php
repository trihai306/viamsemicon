<?php

namespace App\Filament\Resources\ProductResource\Actions;

use App\Services\GeminiService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateProductImageAction
{
    public static function make(string $name = 'generateProductImage'): Action
    {
        return Action::make($name)
            ->label('Tạo ảnh AI')
            ->icon('heroicon-o-paint-brush')
            ->color('danger')
            ->modalHeading('Tạo ảnh sản phẩm bằng Gemini AI')
            ->modalDescription('AI sẽ tạo ảnh sản phẩm chuyên nghiệp từ mô tả.')
            ->modalWidth('lg')
            ->modalIcon('heroicon-o-paint-brush')
            ->form([
                TextInput::make('image_description')
                    ->label('Mô tả sản phẩm cần tạo ảnh')
                    ->placeholder('VD: Máy phân tích phổ Keysight, nền trắng, góc nghiêng 45 độ')
                    ->required()
                    ->maxLength(500),
                Select::make('image_style')
                    ->label('Kiểu ảnh')
                    ->options([
                        'product' => '📦 Ảnh sản phẩm (nền trắng, studio)',
                        'banner' => '🖼️ Banner giới thiệu sản phẩm',
                        'thumbnail' => '📰 Thumbnail danh mục',
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

                    $filename = 'products/' . Str::uuid() . '-ai-generated.jpg';
                    Storage::disk('public')->put($filename, base64_decode($imageB64));

                    $set('ai_generated_image', $filename);

                    Notification::make()
                        ->title('Ảnh sản phẩm AI đã được tạo!')
                        ->body('Ảnh sẽ tự động gắn khi lưu sản phẩm.')
                        ->success()
                        ->duration(8000)
                        ->send();
                } catch (\Throwable $e) {
                    Notification::make()
                        ->title('Lỗi tạo ảnh AI')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->modalSubmitActionLabel('Tạo ảnh')
            ->modalCancelActionLabel('Hủy');
    }
}
