<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

$routes = function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/gioi-thieu', [PageController::class, 'about'])->name('about');
    Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
    Route::get('/danh-muc-san-pham/{slug}', [ProductController::class, 'category'])->name('products.category');
    Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/tin-tuc', [PostController::class, 'index'])->name('posts.index');
    Route::get('/tin-tuc/{slug}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/tuyen-dung', [PostController::class, 'recruitment'])->name('recruitment');
    Route::get('/lien-he', [ContactController::class, 'index'])->name('contact');
    Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/trang/{slug}', [PageController::class, 'show'])->name('pages.show');
};

// Default routes (no locale prefix)
Route::middleware('set.locale')->group($routes);

// Locale-prefixed routes
Route::prefix('{locale}')
    ->where(['locale' => 'vi|en'])
    ->middleware('set.locale')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index']);
        Route::get('/gioi-thieu', [PageController::class, 'about']);
        Route::get('/san-pham', [ProductController::class, 'index']);
        Route::get('/danh-muc-san-pham/{slug}', [ProductController::class, 'category']);
        Route::get('/san-pham/{slug}', [ProductController::class, 'show']);
        Route::get('/tin-tuc', [PostController::class, 'index']);
        Route::get('/tin-tuc/{slug}', [PostController::class, 'show']);
        Route::get('/tuyen-dung', [PostController::class, 'recruitment']);
        Route::get('/lien-he', [ContactController::class, 'index']);
        Route::post('/lien-he', [ContactController::class, 'store']);
        Route::get('/trang/{slug}', [PageController::class, 'show']);
    });
