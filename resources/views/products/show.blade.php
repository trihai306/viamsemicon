@extends('layouts.app')

@section('seo')
    @php
        $seoTitle = $product->seo_title ?: $product->name;
        $seoDesc = $product->seo_description ?: strip_tags(Str::limit($product->short_description ?: $product->description, 160));
        $ogImg = $product->image ? Storage::url($product->image) : null;

        $seoJsonld = \App\Helpers\SeoHelper::schema('product', [
                'name' => $product->name,
                'description' => $seoDesc,
                'image' => $ogImg ?? '',
                'price' => $product->price ?: null,
            ])
            . \App\Helpers\SeoHelper::schema('breadcrumb', ['items' => [
                ['name' => 'Trang chủ', 'url' => url('/')],
                ['name' => 'Sản phẩm', 'url' => route('products.index')],
                ['name' => $product->name, 'url' => url()->current()],
            ]]);
    @endphp
    <x-seo
        :title="$seoTitle"
        :description="$seoDesc"
        og-type="product"
        :og-image="$ogImg"
        :jsonld="$seoJsonld"
    />
@endsection

@push('styles')
<style>
    /* ===== PRODUCT SHOW PAGE STYLES ===== */

    /* Prose styles for product description */
    .prose h1, .prose h2, .prose h3 { color: #0f2444; font-weight: 700; margin-top: 1.5em; margin-bottom: 0.75em; }
    .prose h2 { font-size: 1.3rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.4em; }
    .prose h3 { font-size: 1.1rem; }
    .prose p { margin-bottom: 1em; line-height: 1.8; color: #374151; }
    .prose ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1em; }
    .prose ol { list-style-type: decimal; padding-left: 1.5em; margin-bottom: 1em; }
    .prose li { margin-bottom: 0.4em; color: #374151; }
    .prose table { width: 100%; border-collapse: collapse; margin-bottom: 1em; }
    .prose th { background: #eff6ff; padding: 0.6em 1em; border: 1px solid #bfdbfe; font-weight: 600; color: #1e40af; }
    .prose td { padding: 0.6em 1em; border: 1px solid #e5e7eb; }
    .prose img { max-width: 100%; border-radius: 0.75rem; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .prose strong { color: #0f2444; }
    .prose a { color: #1a56db; text-decoration: underline; }

    /* Gallery Swiper */
    .product-gallery-swiper {
        border-radius: 16px;
        overflow: hidden;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }
    .product-gallery-swiper .swiper-slide {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        height: 420px;
    }
    .product-gallery-swiper .swiper-slide img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        padding: 16px;
    }
    .product-thumb-swiper {
        padding: 8px 0 !important;
    }
    .product-thumb-swiper .swiper-slide {
        width: 70px !important;
        height: 70px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        cursor: pointer;
        background: #f8fafc;
        transition: border-color 0.2s;
        opacity: 0.65;
        transition: opacity 0.2s, border-color 0.2s;
    }
    .product-thumb-swiper .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 4px;
    }
    .product-thumb-swiper .swiper-slide-thumb-active {
        border-color: #1a56db;
        opacity: 1;
        box-shadow: 0 0 0 2px #1a56db30;
    }
    .gallery-nav-btn {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.2s;
        color: #374151;
    }
    .gallery-nav-btn:hover {
        background: #1a56db;
        color: white;
        box-shadow: 0 6px 16px rgba(26,86,219,0.3);
    }
    .gallery-nav-btn::after { display: none; }
    .swiper-button-prev.gallery-nav-btn, .swiper-button-next.gallery-nav-btn { margin-top: 0; }

    /* Sticky info panel */
    .sticky-info-panel {
        position: sticky;
        top: 90px;
        max-height: calc(100vh - 110px);
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #bfdbfe transparent;
    }
    .sticky-info-panel::-webkit-scrollbar { width: 4px; }
    .sticky-info-panel::-webkit-scrollbar-track { background: transparent; }
    .sticky-info-panel::-webkit-scrollbar-thumb { background: #bfdbfe; border-radius: 4px; }

    /* Tabs */
    .product-tab-btn {
        padding: 14px 24px;
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
        border-bottom: 3px solid transparent;
        transition: all 0.2s;
        white-space: nowrap;
        cursor: pointer;
        background: none;
        border-top: none;
        border-left: none;
        border-right: none;
    }
    .product-tab-btn:hover { color: #1a56db; }
    .product-tab-btn.active {
        color: #1a56db;
        border-bottom-color: #1a56db;
        background: linear-gradient(to bottom, transparent, #eff6ff20);
    }

    /* Price display */
    .price-tag {
        background: linear-gradient(135deg, #fff1f2, #fee2e2);
        border: 1px solid #fecaca;
        border-radius: 12px;
        padding: 16px 20px;
    }

    /* Gradient CTA card */
    .cta-gradient-card {
        background: linear-gradient(135deg, #0f2444 0%, #1a3a6e 50%, #1a56db 100%);
        border-radius: 16px;
        padding: 24px;
        position: relative;
        overflow: hidden;
    }
    .cta-gradient-card::before {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .cta-gradient-card::after {
        content: '';
        position: absolute;
        bottom: -20px;
        left: -20px;
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }

    /* Trust badge */
    .trust-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: #f0fdf4;
        border-radius: 8px;
        border: 1px solid #bbf7d0;
        font-size: 0.75rem;
        color: #166534;
        font-weight: 600;
    }

    /* Related products Swiper */
    .related-products-swiper {
        padding-bottom: 32px !important;
    }
    .related-products-swiper .swiper-pagination-bullet {
        background: #1a56db;
    }

    /* Spec table */
    .spec-table tr:hover td {
        background: #eff6ff;
    }
    .spec-table .spec-key {
        background: #f8fafc;
        font-weight: 600;
        color: #374151;
        width: 35%;
    }
    .spec-table .spec-val {
        color: #1e293b;
        font-weight: 500;
    }

    /* Zoom overlay button */
    .img-zoom-overlay {
        position: absolute;
        bottom: 12px;
        right: 12px;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(8px);
        border-radius: 8px;
        padding: 6px 10px;
        font-size: 0.7rem;
        color: #374151;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        transition: all 0.2s;
        z-index: 5;
        border: 1px solid #e2e8f0;
    }
    .img-zoom-overlay:hover {
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Lightbox overlay */
    .lightbox-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.92);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .lightbox-overlay img {
        max-width: 90vw;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 12px;
    }
</style>
@endpush

@section('content')

@php
    $gallery = $product->gallery ?: [];
    $allImages = array_values(array_filter(array_merge(
        $product->image ? [$product->image] : [],
        is_array($gallery) ? $gallery : []
    )));

    $breadcrumbs = [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Sản phẩm', 'url' => route('products.index')],
    ];
    if($product->category) {
        $breadcrumbs[] = ['label' => $product->category->name, 'url' => route('products.category', $product->category->slug)];
    }
    $breadcrumbs[] = ['label' => $product->name];
@endphp

@include('partials.breadcrumbs')

<div class="max-w-7xl mx-auto px-4 py-8 lg:py-12">

    {{-- ======================== PRODUCT DETAIL ======================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-10 mb-10 lg:mb-14" x-data="{ lightboxOpen: false, lightboxSrc: '' }">

        {{-- IMAGE GALLERY: 3 cols on desktop --}}
        <div class="lg:col-span-3">

            @if(count($allImages) > 0)
                {{-- Main Swiper gallery --}}
                <div class="swiper product-gallery-swiper mb-3" id="productMainSwiper">
                    <div class="swiper-wrapper">
                        @foreach($allImages as $img)
                        <div class="swiper-slide">
                            <img src="{{ Storage::url($img) }}"
                                 alt="{{ $product->name }}"
                                 loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                 class="cursor-zoom-in"
                                 @click="lightboxOpen = true; lightboxSrc = '{{ Storage::url($img) }}'">
                        </div>
                        @endforeach
                    </div>

                    {{-- Navigation --}}
                    @if(count($allImages) > 1)
                    <div class="swiper-button-prev gallery-nav-btn" id="galleryPrev">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </div>
                    <div class="swiper-button-next gallery-nav-btn" id="galleryNext">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                    @endif

                    {{-- Zoom hint --}}
                    <div class="img-zoom-overlay">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        Nhấn để phóng to
                    </div>
                </div>

                {{-- Thumbnails --}}
                @if(count($allImages) > 1)
                <div class="swiper product-thumb-swiper" id="productThumbSwiper">
                    <div class="swiper-wrapper">
                        @foreach($allImages as $img)
                        <div class="swiper-slide">
                            <img src="{{ Storage::url($img) }}" alt="{{ $product->name }}" loading="lazy">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            @else
                {{-- Professional placeholder --}}
                <div class="product-gallery-swiper flex flex-col items-center justify-center text-gray-300 h-96"
                     style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                    <div class="w-24 h-24 rounded-3xl flex items-center justify-center mb-4"
                         style="background: linear-gradient(135deg, #1a56db20, #3b82f640);">
                        <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-blue-300 font-bold text-lg">Viam Semicon</span>
                    <span class="text-blue-200 text-sm mt-1">Sản phẩm chất lượng cao</span>
                </div>
            @endif

            {{-- Lightbox --}}
            <div x-show="lightboxOpen" x-cloak
                 class="lightbox-overlay"
                 @click.self="lightboxOpen = false"
                 @keydown.escape.window="lightboxOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <img :src="lightboxSrc" alt="{{ $product->name }}">
                <button @click="lightboxOpen = false"
                        class="absolute top-4 right-4 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- PRODUCT INFO PANEL: 2 cols on desktop, sticky --}}
        <div class="lg:col-span-2">
            <div class="sticky-info-panel" data-aos="fade-left" data-aos-delay="100">

                {{-- Category + Featured badges --}}
                <div class="flex items-center gap-2 mb-4 flex-wrap">
                    @if($product->category)
                    <a href="{{ route('products.category', $product->category->slug) }}"
                       class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-main bg-blue-50 px-3 py-1.5 rounded-full hover:bg-blue-100 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                        {{ $product->category->name }}
                    </a>
                    @endif
                    @if($product->is_featured)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold text-white rounded-full"
                          style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Nổi bật
                    </span>
                    @endif
                </div>

                {{-- Product Name --}}
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight mb-4">{{ $product->name }}</h1>

                {{-- Short Description --}}
                @if($product->short_description)
                <p class="text-gray-600 leading-relaxed text-sm mb-5 border-l-4 border-blue-200 pl-4 bg-blue-50/50 py-2 rounded-r-lg">
                    {{ strip_tags($product->short_description) }}
                </p>
                @endif

                {{-- Price --}}
                @if($product->price)
                <div class="price-tag mb-6">
                    <div class="text-xs text-red-400 font-semibold mb-1 uppercase tracking-wide">Giá bán</div>
                    <div class="text-3xl font-black text-red-600">{{ number_format($product->price, 0, ',', '.') }} ₫</div>
                    <div class="text-xs text-red-400 mt-1">Đã bao gồm VAT • Liên hệ để được giá tốt</div>
                </div>
                @elseif($product->price_text)
                <div class="price-tag mb-6" style="background: linear-gradient(135deg, #eff6ff, #dbeafe); border-color: #bfdbfe;">
                    <div class="text-xs text-blue-500 font-semibold mb-1 uppercase tracking-wide">Giá bán</div>
                    <div class="text-2xl font-black text-blue-700">{{ $product->price_text }}</div>
                </div>
                @else
                <div class="mb-6 p-4 bg-gradient-to-r from-gray-50 to-blue-50/50 rounded-xl border border-gray-200">
                    <div class="text-xs text-gray-500 font-semibold mb-1 uppercase tracking-wide">Giá bán</div>
                    <div class="text-2xl font-black text-gray-700">Liên hệ báo giá</div>
                    <div class="text-xs text-gray-500 mt-1">Giá tốt nhất theo số lượng — Phản hồi trong 1 giờ</div>
                </div>
                @endif

                {{-- Quick specs (first 4 only in info panel) --}}
                @if($product->specifications && is_countable($product->specifications) && count($product->specifications) > 0)
                <div class="mb-6">
                    <h3 class="font-bold text-gray-700 text-xs mb-3 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-4 h-0.5 bg-brand-main block"></span>
                        Thông số nhanh
                        <span class="w-4 h-0.5 bg-brand-main block"></span>
                    </h3>
                    <div class="grid grid-cols-1 gap-1.5">
                        @foreach(array_slice($product->specifications, 0, 4) as $spec)
                        <div class="flex items-center justify-between px-3 py-2 bg-gray-50 rounded-lg border border-gray-100 text-xs">
                            <span class="text-gray-500 font-medium">{{ $spec['key'] ?? $spec['name'] ?? '' }}</span>
                            <span class="font-bold text-gray-800 text-right ml-2">{{ $spec['value'] ?? '' }}</span>
                        </div>
                        @endforeach
                        @if(count($product->specifications) > 4)
                        <div class="text-center text-xs text-brand-main font-semibold py-1.5 cursor-pointer" onclick="document.getElementById('tab-specs').click(); document.getElementById('specs-tab-section').scrollIntoView({behavior:'smooth'})">
                            + {{ count($product->specifications) - 4 }} thông số khác →
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Gradient CTA Card --}}
                <div class="cta-gradient-card mb-5">
                    <p class="text-white/80 text-xs font-medium mb-3 relative z-10">Cần tư vấn hoặc báo giá?</p>
                    <p class="text-white font-black text-lg mb-4 leading-snug relative z-10">Liên hệ ngay để nhận<br>giá tốt nhất hôm nay!</p>
                    <div class="flex flex-col gap-2.5 relative z-10">
                        <a href="{{ route('contact') }}?product={{ urlencode($product->name) }}"
                           class="flex items-center justify-center gap-2 px-4 py-3 bg-brand-accent text-white font-bold rounded-xl hover:bg-red-500 transition-all shadow-lg text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Gửi yêu cầu báo giá
                        </a>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="tel:0986020896"
                               class="flex items-center justify-center gap-1.5 px-3 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all text-xs border border-white/20">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                                0986 020 896
                            </a>
                            <a href="tel:0528152831"
                               class="flex items-center justify-center gap-1.5 px-3 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all text-xs border border-white/20">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                                0528 152 831
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Trust Badges --}}
                <div class="grid grid-cols-2 gap-2 mb-5">
                    <div class="trust-badge">
                        <svg class="w-3.5 h-3.5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Hàng chính hãng
                    </div>
                    <div class="trust-badge">
                        <svg class="w-3.5 h-3.5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Giao hàng nhanh
                    </div>
                    <div class="trust-badge">
                        <svg class="w-3.5 h-3.5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Hóa đơn VAT
                    </div>
                    <div class="trust-badge">
                        <svg class="w-3.5 h-3.5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Hỗ trợ kỹ thuật
                    </div>
                </div>

                {{-- Share --}}
                <div class="flex items-center gap-3 text-xs text-gray-400 pt-3 border-t border-gray-100">
                    <span class="font-medium">Chia sẻ:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank" rel="noopener"
                       class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors font-semibold">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Facebook
                    </a>
                    <a href="https://zalo.me/0986020896" target="_blank" rel="noopener"
                       class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-400 rounded-lg hover:bg-blue-100 transition-colors font-semibold">
                        Zalo
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== TABS: DESCRIPTION / SPECS ======================== --}}
    <div id="specs-tab-section" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-10 lg:mb-14"
         x-data="{ tab: 'description' }" data-aos="fade-up" data-aos-delay="50">

        {{-- Tab Header --}}
        <div class="border-b border-gray-200 flex overflow-x-auto">
            <button @click="tab = 'description'"
                    :class="tab === 'description' ? 'active' : ''"
                    class="product-tab-btn flex items-center gap-2"
                    id="tab-description">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Mô tả sản phẩm
            </button>

            @if($product->specifications && is_countable($product->specifications) && count($product->specifications) > 0)
            <button @click="tab = 'specs'"
                    :class="tab === 'specs' ? 'active' : ''"
                    class="product-tab-btn flex items-center gap-2"
                    id="tab-specs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Thông số kỹ thuật
                <span class="px-1.5 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-md font-bold">
                    {{ count($product->specifications) }}
                </span>
            </button>
            @endif

            <button @click="tab = 'contact'"
                    :class="tab === 'contact' ? 'active' : ''"
                    class="product-tab-btn flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Tư vấn & Hỏi đáp
            </button>
        </div>

        {{-- Description Tab --}}
        <div x-show="tab === 'description'" class="p-6 lg:p-10">
            @if($product->description)
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! $product->description !!}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="text-gray-400 font-medium">Chưa có mô tả chi tiết cho sản phẩm này.</p>
                    <p class="text-gray-400 text-sm mt-1">Liên hệ với chúng tôi để biết thêm thông tin.</p>
                </div>
            @endif
        </div>

        {{-- Specs Tab --}}
        @if($product->specifications && is_countable($product->specifications) && count($product->specifications) > 0)
        <div x-show="tab === 'specs'" x-cloak class="p-6 lg:p-10">
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-sm spec-table">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #0f2444, #1a56db);">
                            <th class="text-left px-5 py-3.5 font-bold text-white w-1/3 text-xs uppercase tracking-wide">Thông số</th>
                            <th class="text-left px-5 py-3.5 font-bold text-white text-xs uppercase tracking-wide">Giá trị</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->specifications as $index => $spec)
                        <tr class="border-b border-gray-100 transition-colors" style="{{ $index % 2 === 1 ? 'background: #f8fafc;' : '' }}">
                            <td class="spec-key px-5 py-3 border-r border-gray-100">{{ $spec['key'] ?? $spec['name'] ?? 'Thông số ' . ($index + 1) }}</td>
                            <td class="spec-val px-5 py-3">{{ $spec['value'] ?? '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Contact / FAQ Tab --}}
        <div x-show="tab === 'contact'" x-cloak class="p-6 lg:p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Contact Form --}}
                <div>
                    <h3 class="font-bold text-gray-800 text-lg mb-4">Đặt câu hỏi về sản phẩm</h3>
                    <form action="{{ route('contact') }}" method="GET" class="space-y-3">
                        <input type="hidden" name="product" value="{{ $product->name }}">
                        <div>
                            <input type="text" name="name" placeholder="Họ và tên *"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-brand-main transition-all">
                        </div>
                        <div>
                            <input type="tel" name="phone" placeholder="Số điện thoại *"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-brand-main transition-all">
                        </div>
                        <div>
                            <textarea name="message" rows="3" placeholder="Nội dung câu hỏi hoặc yêu cầu..."
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-brand-main transition-all resize-none"></textarea>
                        </div>
                        <a href="{{ route('contact') }}?product={{ urlencode($product->name) }}"
                           class="w-full flex items-center justify-center gap-2 py-3 text-white font-bold rounded-xl text-sm transition-all"
                           style="background: linear-gradient(135deg, #1a56db, #3b82f6);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Gửi yêu cầu tư vấn
                        </a>
                    </form>
                </div>
                {{-- Direct contact info --}}
                <div>
                    <h3 class="font-bold text-gray-800 text-lg mb-4">Liên hệ trực tiếp</h3>
                    <div class="space-y-4">
                        <a href="tel:0986020896" class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors group">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 text-white"
                                 style="background: linear-gradient(135deg, #1a56db, #3b82f6);">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 group-hover:text-brand-main transition-colors">0986 020 896</div>
                                <div class="text-xs text-gray-500">Gọi ngay — Phản hồi trong 5 phút</div>
                            </div>
                        </a>
                        <a href="tel:0528152831" class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors group">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 text-white"
                                 style="background: linear-gradient(135deg, #1a56db, #3b82f6);">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 group-hover:text-brand-main transition-colors">0528 152 831</div>
                                <div class="text-xs text-gray-500">Hotline hỗ trợ kỹ thuật</div>
                            </div>
                        </a>
                        <a href="mailto:sale@viamsemicon.com" class="flex items-center gap-4 p-4 bg-red-50 rounded-xl hover:bg-red-100 transition-colors group">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 text-white"
                                 style="background: linear-gradient(135deg, #dc2626, #ef4444);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 group-hover:text-brand-accent transition-colors">sale@viamsemicon.com</div>
                                <div class="text-xs text-gray-500">Email báo giá — Phản hồi trong 2 giờ</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== RELATED PRODUCTS ======================== --}}
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <section data-aos="fade-up" data-aos-delay="100">
        {{-- Section Header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-8 rounded-full" style="background: linear-gradient(to bottom, #1a56db, #3b82f6);"></div>
                <div>
                    <h2 class="text-xl font-black text-brand-dark">Sản phẩm liên quan</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Các sản phẩm tương tự bạn có thể quan tâm</p>
                </div>
            </div>
            @if($product->category)
            <a href="{{ route('products.category', $product->category->slug) }}"
               class="hidden sm:flex items-center gap-1.5 text-sm font-semibold text-brand-main hover:text-blue-700 transition-colors">
                Xem tất cả
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endif
        </div>

        {{-- Related Products Swiper --}}
        <div class="swiper related-products-swiper" id="relatedProductsSwiper">
            <div class="swiper-wrapper pb-2">
                @foreach($relatedProducts as $related)
                <div class="swiper-slide h-auto">
                    @include('partials.product-card', ['product' => $related, 'size' => 'sm'])
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Initialize product gallery Swiper only if multiple images exist
    @if(count($allImages) > 1)
    var thumbSwiper = new Swiper('#productThumbSwiper', {
        spaceBetween: 8,
        slidesPerView: 'auto',
        freeMode: true,
        watchSlidesProgress: true,
    });

    var mainSwiper = new Swiper('#productMainSwiper', {
        spaceBetween: 0,
        loop: {{ count($allImages) > 2 ? 'true' : 'false' }},
        navigation: {
            nextEl: '#galleryNext',
            prevEl: '#galleryPrev',
        },
        thumbs: {
            swiper: thumbSwiper
        },
        keyboard: { enabled: true },
        a11y: { prevSlideMessage: 'Ảnh trước', nextSlideMessage: 'Ảnh tiếp' },
    });
    @elseif(count($allImages) === 1)
    new Swiper('#productMainSwiper', {
        spaceBetween: 0,
        allowTouchMove: false,
    });
    @endif

    // Related products Swiper
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    new Swiper('#relatedProductsSwiper', {
        spaceBetween: 16,
        slidesPerView: 2,
        pagination: {
            el: '.related-products-swiper .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: { slidesPerView: 3 },
            1024: { slidesPerView: 4 },
            1280: { slidesPerView: 5 },
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
    });
    @endif

    // Make product-tab-btn work with Alpine.js
    // The :class binding handles active state
    document.querySelectorAll('.product-tab-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.product-tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

});
</script>
@endpush

@endsection
