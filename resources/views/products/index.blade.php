@extends('layouts.app')

@section('seo')
    @php
        $seoTitle = isset($currentCategory)
            ? ($currentCategory->seo_title ?: $currentCategory->name)
            : 'Sản phẩm';
        $seoDesc = isset($currentCategory)
            ? strip_tags($currentCategory->seo_description ?: $currentCategory->description ?: 'Sản phẩm ' . $currentCategory->name . ' chính hãng tại Viam Semicon.')
            : 'Danh sách thiết bị đo lường, robot vận chuyển, RF cable và linh kiện điện tử chính hãng tại Viam Semicon.';
        $ogImg = isset($currentCategory) && $currentCategory->image ? Storage::url($currentCategory->image) : null;

        $breadcrumbs = [['name' => 'Trang chủ', 'url' => url('/')], ['name' => 'Sản phẩm', 'url' => route('products.index')]];
        if (isset($currentCategory)) {
            $breadcrumbs[] = ['name' => $currentCategory->name, 'url' => url()->current()];
        }
        $seoJsonld = \App\Helpers\SeoHelper::schema('breadcrumb', ['items' => $breadcrumbs]);
    @endphp
    <x-seo
        :title="$seoTitle"
        :description="$seoDesc"
        :og-image="$ogImg"
        :jsonld="$seoJsonld"
    />
@endsection

@push('styles')
<style>
    /* Sidebar category link */
    .sidebar-cat-link {
        position: relative;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 16px;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0;
        color: #374151;
        text-decoration: none;
    }
    .sidebar-cat-link::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #f59e0b, #d97706);
        border-radius: 0 2px 2px 0;
        transform: scaleY(0);
        transition: transform 0.2s;
    }
    .sidebar-cat-link:hover::before,
    .sidebar-cat-link.active::before { transform: scaleY(1); }
    .sidebar-cat-link.active {
        background: rgba(245,158,11,0.08);
        color: #d97706;
        font-weight: 700;
    }
    .sidebar-cat-link:hover {
        background: #fffbeb;
        color: #d97706;
    }

    /* Sort select */
    .sort-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.25em;
        padding-right: 2.5rem;
    }

    /* Product grid enhanced */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    @media (min-width: 640px) {
        .products-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (min-width: 1024px) {
        .products-grid { grid-template-columns: repeat(4, 1fr); }
    }
</style>
@endpush

@section('content')

@php
    $breadcrumbs = [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Sản phẩm', 'url' => route('products.index')],
    ];
    if(isset($currentCategory)) {
        $breadcrumbs[] = ['label' => $currentCategory->name, 'url' => route('products.category', $currentCategory->slug)];
    }
@endphp

@include('partials.breadcrumbs')

{{-- Category Hero Banner --}}
@if(isset($currentCategory))
<div class="relative overflow-hidden py-10" style="background: linear-gradient(135deg, #0f2444, #1a56db);">
    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.04) 1px, transparent 0); background-size: 32px 32px;"></div>
    <div class="absolute right-0 top-0 w-64 h-full opacity-10">
        <svg viewBox="0 0 200 200" class="w-full h-full"><circle cx="150" cy="100" r="120" fill="white"/></svg>
    </div>
    {{-- Orange accent line --}}
    <div class="absolute left-0 top-0 bottom-0 w-1" style="background: linear-gradient(180deg, #f59e0b, #d97706);"></div>
    <div class="relative max-w-7xl mx-auto px-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(245,158,11,0.25);">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/></svg>
            </div>
            <span class="text-amber-300 text-xs font-semibold uppercase tracking-widest">Danh mục sản phẩm</span>
        </div>
        <h1 class="text-2xl md:text-3xl font-black text-white mb-2">{{ $currentCategory->name }}</h1>
        @if($currentCategory->description)
        <p class="text-blue-200 text-sm max-w-xl">{{ strip_tags($currentCategory->description) }}</p>
        @endif
    </div>
</div>
@endif

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-6">

        {{-- ======================== SIDEBAR ======================== --}}
        <aside class="lg:w-60 flex-shrink-0 space-y-4">

            {{-- Category Filter --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden"
                 x-data="{ expanded: true }">
                <div class="flex items-center justify-between px-4 py-3 cursor-pointer select-none"
                     style="background: linear-gradient(135deg, #1a365d, #1d4ed8);"
                     @click="expanded = !expanded">
                    <div class="flex items-center gap-2 font-bold text-sm text-white uppercase tracking-wide">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        Danh mục
                    </div>
                    <svg class="w-4 h-4 text-white/70 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                </div>

                <nav x-show="expanded" x-transition class="py-1.5">
                    <a href="{{ route('products.index') }}"
                       class="sidebar-cat-link {{ !isset($currentCategory) && !request('category') ? 'active' : '' }}">
                        <span class="flex items-center gap-2.5">
                            <div class="w-5 h-5 rounded-md flex items-center justify-center flex-shrink-0"
                                 style="{{ !isset($currentCategory) ? 'background:#f59e0b;' : 'background:#f3f4f6;' }}">
                                <svg class="w-3 h-3" style="{{ !isset($currentCategory) ? 'color:white;' : 'color:#9ca3af;' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            </div>
                            Tất cả sản phẩm
                        </span>
                    </a>

                    @if(isset($categories) && $categories->count())
                        @foreach($categories as $cat)
                        <div x-data="{ open: {{ isset($currentCategory) && $currentCategory->slug === $cat->slug ? 'true' : 'false' }} }">
                            <div class="flex items-center">
                                <a href="{{ route('products.category', $cat->slug) }}"
                                   class="sidebar-cat-link flex-1 {{ isset($currentCategory) && $currentCategory->slug === $cat->slug ? 'active' : '' }}">
                                    <span class="flex items-center gap-2.5 truncate">
                                        @if($cat->image)
                                            <img src="{{ Storage::url($cat->image) }}" alt="{{ $cat->name }}" class="w-5 h-5 object-cover rounded-md flex-shrink-0">
                                        @else
                                            <div class="w-5 h-5 rounded-md flex items-center justify-center flex-shrink-0"
                                                 style="{{ isset($currentCategory) && $currentCategory->slug === $cat->slug ? 'background:#f59e0b;' : 'background:#f3f4f6;' }}">
                                                <span class="w-1.5 h-1.5 rounded-full"
                                                      style="{{ isset($currentCategory) && $currentCategory->slug === $cat->slug ? 'background:white;' : 'background:#f59e0b;' }}"></span>
                                            </div>
                                        @endif
                                        <span class="truncate">{{ $cat->name }}</span>
                                    </span>
                                    @php $count = $cat->products_count ?? null; @endphp
                                    @if($count)
                                    <span class="text-xs px-1.5 py-0.5 rounded-full flex-shrink-0 ml-1"
                                          style="{{ isset($currentCategory) && $currentCategory->slug === $cat->slug ? 'background:#f59e0b;color:white;' : 'background:#f3f4f6;color:#9ca3af;' }}">
                                        {{ $count }}
                                    </span>
                                    @endif
                                </a>
                                @if($cat->children && $cat->children->count())
                                <button @click="open = !open" class="px-2 py-2 text-gray-400 hover:text-amber-500 transition-colors">
                                    <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                </button>
                                @endif
                            </div>

                            @if($cat->children && $cat->children->count())
                            <div x-show="open" x-transition class="ml-5 border-l-2 pl-2 py-1" style="border-color: rgba(245,158,11,0.3);">
                                @foreach($cat->children as $child)
                                <a href="{{ route('products.category', $child->slug) }}"
                                   class="flex items-center gap-2 px-3 py-2 text-xs font-medium rounded-lg transition-colors {{ isset($currentCategory) && $currentCategory->slug === $child->slug ? 'text-amber-600 font-semibold' : 'text-gray-500 hover:text-amber-600' }}"
                                   style="{{ isset($currentCategory) && $currentCategory->slug === $child->slug ? 'background:rgba(245,158,11,0.08);' : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background: {{ isset($currentCategory) && $currentCategory->slug === $child->slug ? '#f59e0b' : '#d1d5db' }};"></span>
                                    {{ $child->name }}
                                </a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    @endif
                </nav>
            </div>

            {{-- Contact CTA Sidebar --}}
            <div class="rounded-xl p-5 text-white relative overflow-hidden"
                 style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 60%, #b45309 100%);">
                <div class="absolute top-0 right-0 w-24 h-24 opacity-15">
                    <svg viewBox="0 0 100 100"><circle cx="80" cy="20" r="60" fill="white"/></svg>
                </div>
                <div class="relative">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-3" style="background: rgba(255,255,255,0.2);">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    </div>
                    <p class="font-black text-sm mb-1 text-white">Cần báo giá?</p>
                    <p class="text-amber-100 text-xs mb-4 leading-relaxed">Liên hệ ngay để nhận giá tốt nhất và tư vấn kỹ thuật miễn phí.</p>
                    <a href="tel:0986020896"
                       class="block text-center py-2.5 rounded-lg text-sm font-black hover:opacity-90 transition-opacity mb-2"
                       style="background: #1a365d; color: white;">
                        0986 020 896
                    </a>
                    <a href="{{ route('contact') }}"
                       class="block text-center py-2.5 rounded-lg text-xs font-semibold border border-white/30 text-white hover:bg-white/15 transition-colors">
                        Gửi yêu cầu báo giá
                    </a>
                </div>
            </div>

            {{-- Quick info --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 space-y-3">
                @foreach([
                    ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'text' => 'Hàng chính hãng 100%', 'color' => '#10b981'],
                    ['icon' => 'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18', 'text' => 'Xuất hóa đơn VAT', 'color' => '#3b82f6'],
                    ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'text' => 'Giao hàng nhanh toàn quốc', 'color' => '#f59e0b'],
                ] as $info)
                <div class="flex items-center gap-2.5 text-xs text-gray-600 font-medium">
                    <div class="w-6 h-6 rounded-md flex items-center justify-center flex-shrink-0"
                         style="background: {{ $info['color'] }}20;">
                        <svg class="w-3.5 h-3.5" style="color: {{ $info['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $info['icon'] }}"/></svg>
                    </div>
                    {{ $info['text'] }}
                </div>
                @endforeach
            </div>
        </aside>

        {{-- ======================== MAIN CONTENT ======================== --}}
        <div class="flex-1 min-w-0">

            {{-- Filter/Sort Bar --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h1 class="text-lg sm:text-xl font-black" style="color: #1a365d;">
                        {{ isset($currentCategory) ? $currentCategory->name : 'Tất cả sản phẩm' }}
                    </h1>
                    @if(isset($products) && $products->total() > 0)
                    <p class="text-xs text-gray-400 mt-0.5">
                        Hiển thị <strong class="text-gray-600">{{ $products->firstItem() }}–{{ $products->lastItem() }}</strong>
                        trong <strong style="color: #f59e0b;">{{ $products->total() }}</strong> sản phẩm
                    </p>
                    @endif
                </div>

                <div class="flex items-center gap-3 flex-shrink-0">
                    <form method="GET" class="flex items-center gap-2">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <select name="sort" onchange="this.form.submit()"
                            class="sort-select text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none text-gray-600 bg-white font-medium pr-8"
                            style="border-color: #e5e7eb;">
                            <option value="" {{ !request('sort') ? 'selected' : '' }}>Mặc định</option>
                            <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Tên A → Z</option>
                            <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Tên Z → A</option>
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        </select>
                    </form>
                </div>
            </div>

            {{-- Search result notice --}}
            @if(request('search'))
            <div class="mb-4 px-4 py-3 rounded-xl text-sm flex items-center gap-3"
                 style="background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.25); color: #92400e;">
                <svg class="w-4 h-4 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Kết quả cho: <strong>"{{ request('search') }}"</strong> — {{ isset($products) ? $products->total() : 0 }} sản phẩm</span>
                <a href="{{ isset($currentCategory) ? route('products.category', $currentCategory->slug) : route('products.index') }}"
                   class="ml-auto text-xs font-semibold bg-white px-3 py-1 rounded-full border border-amber-200 text-amber-700 hover:border-red-300 hover:text-red-600 transition-colors flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Xóa
                </a>
            </div>
            @endif

            {{-- Products Grid --}}
            @if(isset($products) && $products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-20 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="w-20 h-20 rounded-full flex items-center justify-center mb-5"
                     style="background: rgba(245,158,11,0.1); border: 2px solid rgba(245,158,11,0.2);">
                    <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                </div>
                <p class="font-bold text-lg mb-2" style="color: #1a365d;">Không tìm thấy sản phẩm</p>
                <p class="text-gray-400 text-sm mb-7 max-w-xs">Thử tìm kiếm với từ khóa khác hoặc duyệt tất cả danh mục sản phẩm.</p>
                <a href="{{ route('products.index') }}"
                   class="px-7 py-3 text-white font-bold rounded-xl text-sm shadow-lg hover:opacity-90 transition-opacity"
                   style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    Xem tất cả sản phẩm
                </a>
            </div>
            @endif

            {{-- ======================== PAGINATION ======================== --}}
            @if(isset($products) && $products->hasPages())
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center gap-1.5" aria-label="Pagination">
                    {{-- Previous --}}
                    @if($products->onFirstPage())
                        <span class="w-10 h-10 flex items-center justify-center text-gray-300 border border-gray-100 rounded-lg text-sm cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}"
                           class="w-10 h-10 flex items-center justify-center border border-gray-200 text-gray-600 rounded-lg hover:border-amber-400 hover:text-amber-600 transition-all text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                    @endif

                    {{-- Page numbers --}}
                    @foreach($products->getUrlRange(max(1, $products->currentPage() - 2), min($products->lastPage(), $products->currentPage() + 2)) as $page => $url)
                        @if($page === $products->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center text-white rounded-lg text-sm font-black shadow-md"
                                  style="background: linear-gradient(135deg, #f59e0b, #d97706);">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                               class="w-10 h-10 flex items-center justify-center border border-gray-200 text-gray-600 rounded-lg hover:border-amber-400 hover:text-amber-600 transition-all text-sm font-medium">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}"
                           class="w-10 h-10 flex items-center justify-center border border-gray-200 text-gray-600 rounded-lg hover:border-amber-400 hover:text-amber-600 transition-all text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <span class="w-10 h-10 flex items-center justify-center text-gray-300 border border-gray-100 rounded-lg text-sm cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    @endif
                </nav>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
