<?php

namespace App\Filament\Resources\ProductResource\Actions;

use App\Services\GeminiService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class GenerateProductSeoAction
{
    public static function make(string $name = 'generateProductSeo'): Action
    {
        return Action::make($name)
            ->label('Tạo SEO AI')
            ->icon('heroicon-o-magnifying-glass')
            ->color('info')
            ->requiresConfirmation()
            ->modalHeading('Tạo SEO sản phẩm bằng Gemini AI')
            ->modalDescription('AI sẽ đọc tên và mô tả sản phẩm để tạo SEO title + description tối ưu.')
            ->action(function (callable $get, callable $set): void {
                $name = $get('name.vi') ?? '';
                $shortDesc = $get('short_description.vi') ?? '';

                if (empty($name)) {
                    Notification::make()
                        ->title('Chưa có tên sản phẩm')
                        ->body('Vui lòng nhập tên sản phẩm trước.')
                        ->warning()
                        ->send();
                    return;
                }

                try {
                    $gemini = app(GeminiService::class);
                    $seo = $gemini->generateProductSeo($name, $shortDesc);

                    if (!empty($seo['vi']['title'])) $set('seo_title.vi', $seo['vi']['title']);
                    if (!empty($seo['vi']['description'])) $set('seo_description.vi', $seo['vi']['description']);
                    if (!empty($seo['en']['title'])) $set('seo_title.en', $seo['en']['title']);
                    if (!empty($seo['en']['description'])) $set('seo_description.en', $seo['en']['description']);

                    Notification::make()
                        ->title('SEO sản phẩm đã được tạo!')
                        ->body('Chuyển sang tab SEO để xem kết quả.')
                        ->success()
                        ->send();
                } catch (\Throwable $e) {
                    Notification::make()
                        ->title('Lỗi tạo SEO')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->modalSubmitActionLabel('Tạo SEO')
            ->modalCancelActionLabel('Hủy');
    }
}
