<?php

namespace App\Filament\Resources\ProductResource\Actions;

use App\Models\Category;
use App\Services\GeminiService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class GenerateProductSpecsAction
{
    public static function make(string $name = 'generateProductSpecs'): Action
    {
        return Action::make($name)
            ->label('Tạo thông số AI')
            ->icon('heroicon-o-cpu-chip')
            ->color('success')
            ->modalHeading('Tạo thông số kỹ thuật bằng Gemini AI')
            ->modalDescription('AI sẽ tạo bảng thông số kỹ thuật phù hợp cho sản phẩm.')
            ->modalWidth('lg')
            ->modalIcon('heroicon-o-cpu-chip')
            ->form([
                TextInput::make('spec_product_name')
                    ->label('Tên sản phẩm')
                    ->placeholder('VD: Keysight E4990A Impedance Analyzer')
                    ->required()
                    ->maxLength(300),
                Select::make('spec_category')
                    ->label('Danh mục')
                    ->options(
                        Category::all()->pluck('name', 'name')
                            ->map(fn ($name) => is_array($name) ? ($name['vi'] ?? $name['en'] ?? '') : $name)
                    )
                    ->placeholder('Chọn danh mục'),
            ])
            ->action(function (array $data, callable $set): void {
                try {
                    $gemini = app(GeminiService::class);
                    $categoryName = '';
                    if (!empty($data['spec_category'])) {
                        $cat = $data['spec_category'];
                        $categoryName = is_array($cat) ? ($cat['vi'] ?? $cat['en'] ?? '') : $cat;
                    }

                    $specs = $gemini->generateProductSpecs($data['spec_product_name'], $categoryName);

                    if (!empty($specs)) {
                        $set('specifications', $specs);
                    }

                    Notification::make()
                        ->title('Thông số kỹ thuật đã được tạo!')
                        ->body('Chuyển sang tab "Thông số kỹ thuật" để xem và chỉnh sửa.')
                        ->success()
                        ->duration(6000)
                        ->send();
                } catch (\Throwable $e) {
                    Notification::make()
                        ->title('Lỗi tạo thông số')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->modalSubmitActionLabel('Tạo thông số')
            ->modalCancelActionLabel('Hủy');
    }
}
