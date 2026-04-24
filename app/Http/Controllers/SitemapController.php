<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Page;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency('daily'))
            ->add(Url::create('/gioi-thieu')->setPriority(0.8)->setChangeFrequency('monthly'))
            ->add(Url::create('/san-pham')->setPriority(0.9)->setChangeFrequency('daily'))
            ->add(Url::create('/tin-tuc')->setPriority(0.8)->setChangeFrequency('daily'))
            ->add(Url::create('/tuyen-dung')->setPriority(0.7)->setChangeFrequency('weekly'))
            ->add(Url::create('/lien-he')->setPriority(0.7)->setChangeFrequency('monthly'));

        Category::active()->each(function ($category) use ($sitemap) {
            $sitemap->add(
                Url::create("/danh-muc-san-pham/{$category->slug}")
                    ->setPriority(0.8)
                    ->setChangeFrequency('weekly')
                    ->setLastModificationDate($category->updated_at)
            );
        });

        Product::active()->each(function ($product) use ($sitemap) {
            $sitemap->add(
                Url::create("/san-pham/{$product->slug}")
                    ->setPriority(0.7)
                    ->setChangeFrequency('weekly')
                    ->setLastModificationDate($product->updated_at)
            );
        });

        Post::published()->each(function ($post) use ($sitemap) {
            $prefix = $post->category_type === 'tin-tuc' ? 'tin-tuc' : 'tuyen-dung';
            $sitemap->add(
                Url::create("/{$prefix}/{$post->slug}")
                    ->setPriority(0.6)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($post->updated_at)
            );
        });

        Page::where('is_active', true)->each(function ($page) use ($sitemap) {
            $sitemap->add(
                Url::create("/trang/{$page->slug}")
                    ->setPriority(0.5)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($page->updated_at)
            );
        });

        return $sitemap->toResponse(request());
    }
}
