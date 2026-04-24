<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->roots()->orderBy('sort_order')->with('children')->get();

        $products = Product::active()
            ->with('category')
            ->orderBy('sort_order')
            ->paginate(12);

        return view('products.index', compact('categories', 'products'));
    }

    public function show(string $slug)
    {
        $product = Product::active()
            ->with('category.children')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $categories = Category::active()->roots()->orderBy('sort_order')->with('children')->get();

        return view('products.show', compact('product', 'relatedProducts', 'categories'));
    }

    public function category(string $slug)
    {
        $category = Category::active()->where('slug', $slug)->firstOrFail();

        // Collect this category and all its children IDs
        $categoryIds = collect([$category->id])
            ->merge($category->children->pluck('id'));

        $products = Product::active()
            ->with('category')
            ->whereIn('category_id', $categoryIds)
            ->orderBy('sort_order')
            ->paginate(12);

        $categories = Category::active()->roots()->orderBy('sort_order')->with('children')->get();

        return view('products.index', ['currentCategory' => $category, 'products' => $products, 'categories' => $categories]);
    }
}
