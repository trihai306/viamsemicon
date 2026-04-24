<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use App\Models\Post;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();

        $totalPosts = Post::count();
        $publishedPosts = Post::where('is_published', true)->count();

        $totalContacts = Contact::count();
        $unreadContacts = Contact::where('is_read', false)->count();

        return [
            Stat::make('Sản phẩm', $totalProducts)
                ->description("{$activeProducts} đang hiển thị")
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary')
                ->icon('heroicon-o-cube'),

            Stat::make('Bài viết', $totalPosts)
                ->description("{$publishedPosts} đã xuất bản")
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info')
                ->icon('heroicon-o-document-text'),

            Stat::make('Liên hệ chưa đọc', $unreadContacts)
                ->description("{$totalContacts} tổng liên hệ")
                ->descriptionIcon('heroicon-m-envelope')
                ->color($unreadContacts > 0 ? 'danger' : 'success')
                ->icon('heroicon-o-envelope'),
        ];
    }
}
