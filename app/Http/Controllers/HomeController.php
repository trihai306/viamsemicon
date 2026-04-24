<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Feature;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->get();
        $features = Feature::active()->get();

        $categories = Category::active()
            ->roots()
            ->orderBy('sort_order')
            ->with(['products' => function ($query) {
                $query->active()->orderBy('sort_order')->limit(8);
            }])
            ->get();

        $categoriesWithProducts = Category::active()
            ->roots()
            ->orderBy('sort_order')
            ->with(['products' => function ($query) {
                $query->active()->orderByDesc('created_at')->limit(6);
            }])
            ->get()
            ->filter(fn ($cat) => $cat->products->isNotEmpty());

        $partners = Partner::active()->get();

        $latestPosts = Post::published()
            ->news()
            ->orderByDesc('published_at')
            ->limit(4)
            ->get();

        return view('home', compact(
            'sliders',
            'features',
            'categories',
            'categoriesWithProducts',
            'partners',
            'latestPosts',
        ));
    }
}
