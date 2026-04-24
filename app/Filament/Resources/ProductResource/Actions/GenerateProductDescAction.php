<?php

namespace App\Filament\Resources\ProductResource\Actions;

use App\Models\Category;
use App\Services\GeminiService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class GenerateProductDescAction
{
    public static function make(string $name = 'generateProductDesc'): Action
    {
        return Action::make($name)
            ->label('Tạo mô tả AI')
            ->icon('heroicon-o-sparkles')
            ->color('warning')
            ->modalHeading('Tạo mô tả sản phẩm bằng Gemini AI')
            ->modalDescription('AI sẽ tạo mô tả ngắn + chi tiết cho sản phẩm cả tiếng Việt và tiếng Anh.')
            ->modalWidth('lg')
            ->modalIcon('heroicon-o-sparkles')
            ->form([
                TextInput::make('product_name')
                    ->label('Tên sản phẩm')
                    ->placeholder('VD: Keysight N9010B Signal Analyzer')
                    ->required()
                    ->maxLength(300),
                Select::make('product_category')
                    ->label('Danh mục')
                    ->options(
                        Category::all()->pluck('name', 'name')
                            ->map(fn ($name) => is_array($name) ? ($name['vi'] ?? $name['en'] ?? '') : $name)
                    )
                    ->placeholder('Chọn danh mục để AI mô tả chính xác hơn'),
            ])
            ->action(function (array $data, callable $set): void {
                try {
                    $gemini = app(GeminiService::class);
                    $categoryName = '';
                    if (!empty($data['product_category'])) {
                        $cat = $data['product_category'];
                        $categoryName = is_array($cat) ? ($cat['vi'] ?? $cat['en'] ?? '') : $cat;
                    }

                    $result = $gemini->generateProductDescription($data['product_name'], $categoryName);

                    $set('name.vi', $data['product_name']);
                    if (!empty($result['short_vi'])) $set('short_description.vi', $result['short_vi']);
                    if (!empty($result['desc_vi'])) $set('description.vi', $result['desc_vi']);
                    if (!empty($result['short_en'])) $set('short_description.en', $result['short_en']);
                    if (!empty($result['desc_en'])) $set('description.en', $result['desc_en']);

                    Notification::make()
                        ->title('Mô tả sản phẩm đã được tạo!')
                        ->body('Kiểm tra tab Tiếng Việt và English để xem nội dung.')
                        ->success()
                        ->duration(8000)
                        ->send();
                } catch (\Throwable $e) {
                    Notification::make()
                        ->title('Lỗi tạo mô tả AI')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->modalSubmitActionLabel('Tạo mô tả')
            ->modalCancelActionLabel('Hủy');
    }
}
