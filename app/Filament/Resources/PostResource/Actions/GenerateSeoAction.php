<?php

namespace App\Filament\Resources\PostResource\Actions;

use App\Services\GeminiService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class GenerateSeoAction
{
    public static function make(string $name = 'generateSeo'): Action
    {
        return Action::make($name)
            ->label('Tạo SEO bằng AI')
            ->icon('heroicon-o-magnifying-glass')
            ->color('info')
            ->requiresConfirmation()
            ->modalHeading('Tạo SEO tự động bằng Gemini AI')
            ->modalDescription('AI sẽ đọc nội dung bài viết và tạo SEO Title + Description tối ưu cho cả 2 ngôn ngữ.')
            ->modalIcon('heroicon-o-magnifying-glass')
            ->action(function (callable $get, callable $set): void {
                $contentVi = $get('content.vi') ?? '';
                $titleVi = $get('title.vi') ?? '';

                if (empty(strip_tags($contentVi))) {
                    Notification::make()
                        ->title('Chưa có nội dung')
                        ->body('Vui lòng nhập hoặc tạo nội dung bài viết trước khi tạo SEO.')
                        ->warning()
                        ->send();
                    return;
                }

                try {
                    $gemini = app(GeminiService::class);
                    $seo = $gemini->generateSeo($contentVi, $titleVi);

                    if (!empty($seo['vi']['title'])) {
                        $set('seo_title.vi', $seo['vi']['title']);
                    }
                    if (!empty($seo['vi']['description'])) {
                        $set('seo_description.vi', $seo['vi']['description']);
                    }
                    if (!empty($seo['en']['title'])) {
                        $set('seo_title.en', $seo['en']['title']);
                    }
                    if (!empty($seo['en']['description'])) {
                        $set('seo_description.en', $seo['en']['description']);
                    }

                    Notification::make()
                        ->title('SEO đã được tạo thành công!')
                        ->body('Chuyển sang tab SEO để xem và chỉnh sửa kết quả.')
                        ->success()
                        ->duration(6000)
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
